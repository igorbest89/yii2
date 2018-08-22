<?php

namespace app\models;

require_once  __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use Yii;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * This is the model class for table "file".
 *
 * @property integer $file_id
 * @property string $file_name
 * @property string $file_path
 * @property string $file_mime_type
 * @property integer $file_extension_id
 * @property integer $file_created_at
 * @property integer $file_updated_at
 */
class File extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /*Errors codes and messages*/
    const ERROR_CODE_IMAGE_NOT_SAVED = 40;
    const ERROR_MESSAGE_IMAGE_NOT_SAVED = 'Internal server error. Image not saved!';
    const ERROR_CODE_DOCUMENT_NOT_SAVED = 42;
    const ERROR_MESSAGE_DOCUMENT_NOT_SAVED = 'Internal server error. Document not saved!';

    //Success messages
    const MESSAGE_IMAGE_RESIZE_COMPLETED = 'Resize successfully completed and new image saved!';
    const MESSAGE_DOCUMENT_CREATED = 'Document successfully created and saved!';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['file_name', 'file_path', 'file_mime_type', 'file_extension_id'],
                'required',
                'on' => [self::SCENARIO_CREATE]
            ],
            [
                ['file_name', 'file_path', 'file_mime_type'],
                'string',
                'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]
            ],
            [
                ['file_extension_id', 'file_created_at', 'file_updated_at'],
                'integer',
                'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]
            ],
            [
                ['file_id', 'file_created_at', 'file_updated_at'],
                'safe',
                'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file_id'           => 'ID',
            'file_name'         => 'Name',
            'file_path'         => 'Path to file',
            'file_mime_type'    => 'MIME type',
            'file_extension_id' => 'ID of file extension',
            'file_created_at'   => 'Date of creating',
            'file_updated_at'   => 'Date of updating'
        ];
    }

    /**
     * Method for add file to DB
     * @param $fileName
     * @param $filePath
     * @param $fileMimeType
     * @param $fileExtensionId
     * @return integer | null
     */
    public function addFile($fileName, $filePath, $fileMimeType, $fileExtensionId)
    {
        $this->file_name = $fileName;
        $this->file_path = $filePath;
        $this->file_mime_type = $fileMimeType;
        $this->file_extension_id = $fileExtensionId;
        $this->file_created_at = time();
        $this->file_updated_at = time();

        if ($this->save()) {

            return $this->file_id;

        } else {

            return null;
        }
    }

    /**
     * Method for creating queue and sending some file with using rabbitMQ
     *
     * @param $queueName
     * @param $data
     */
    public static function sendFile($queueName, $data)
    {
        $connection = new AMQPStreamConnection(Yii::$app->params['rabbitMQHost'], Yii::$app->params['rabbitMQPort'], Yii::$app->params['rabbitMQUser'], Yii::$app->params['rabbitMQPassword']);

        $channel = $connection->channel();
        $channel->queue_declare($queueName, false, false, false, false);

        $messageData = new AMQPMessage(json_encode($data));

        $channel->basic_publish($messageData, Yii::$app->params['rabbitMQExchange'], $queueName);

        $channel->close();

        $connection->close();
    }

    /**
     * Method for receiving files with using rabbitMQ
     *
     * @param $queueName
     * @param $received
     */
    public static function receiveFile($queueName, $received = false)
    {
        $connection = new AMQPStreamConnection(Yii::$app->params['rabbitMQHost'], Yii::$app->params['rabbitMQPort'], Yii::$app->params['rabbitMQUser'], Yii::$app->params['rabbitMQPassword']);

        $channel = $connection->channel();
        $channel->queue_declare($queueName, false, false, false, false);
        $channel->queue_bind($queueName, Yii::$app->params['rabbitMQExchange'], $queueName);

        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

        $callback = function($msg) {
//            echo $msg->body;
            self::changeSaverByFileExtension($msg->body);
        };

        $channel->basic_consume($queueName, '', false, true, false, false, $callback);

        while(count($channel->callbacks)) {
            $channel->wait();

            if ($received) {
                $channel->close();

                $connection->close();

                break;
            }
        }

        $channel->close();

        $connection->close();
    }

    /**
     * Method for preparing file to sending
     *
     * @param $filePath
     * @return string
     */
    public static function prepareFileToSending($filePath)
    {
        $fileBase64 = base64_encode(file_get_contents($filePath));

        return $fileBase64;
    }

    /**
     * Method for creating and saving in DB test image file
     */
    public static function createTestFile()
    {
        self::createImageFile('hd_cosmo_cat.jpg');
    }

    /**
     * Method for getting from DB test image file
     *
     * @return array
     */
    public static function getTestFile()
    {
        $fileBase64 = self::prepareFileToSending(realpath(Yii::$app->params['unprocessedImages'] . 'hd_cosmo_cat.jpg'));

        $fileData = [
            'name'         => 'hd_cosmo_cat.jpg',
            'path'         => realpath(Yii::$app->params['unprocessedImages'] . 'hd_cosmo_cat.jpg'),
            'mime_type'    => self::getMimeType('hd_cosmo_cat.jpg'),
            'extension_id' => FileExtension::find()
                ->where(['file_extension_name' => self::getExtension('hd_cosmo_cat.jpg')])
                ->asArray()->one()['file_extension_id'],
            'fileBase64'   => $fileBase64,
            'width'        => 800,
            'height'       => 600
        ];

//        $registerData = User::createTestRegistrationData();
//
//        $fileData = [
//            'name'      => 'test_summary',
//            'mime_type' => 'text/html',
//            'data'      => $registerData,
//            'target'    => 'summary'
//        ];

        return $fileData;
    }

    /**
     * Method for saving image files to directory and DB
     *
     * @param $jsonData
     */
    public static function saveImageFile($jsonData)
    {
        $fileData = json_decode($jsonData);

        $newFileName = substr($fileData->name, 0,strripos($fileData->name, '.')) . '_' . $fileData->width . '_x_' . $fileData->height . '.' . self::getExtension($fileData->name);

        $file = base64_decode($fileData->fileBase64);
        $newPath = Yii::$app->params['processedImages'] . $newFileName;

        self::createImageFile($newFileName);

        file_put_contents($newPath, $file);
    }

    /**
     * Method for saving document files to directory and DB
     *
     * @param $jsonData
     */
    public static function saveDocumentFile($jsonData)
    {
        $fileData = json_decode($jsonData);

        $file = base64_decode($fileData->fileBase64);
        $newPath = Yii::$app->params['processedDocuments'] . $fileData->name;

        self::createDocumentFile($fileData->name);

        file_put_contents($newPath, $file);
    }


    /**
     * Method for saving other files to directory and DB
     * @param $jsonData
     * @return mixed
     */
    public static function saveOtherFile($jsonData)
    {
        $fileData = json_decode($jsonData);
        return $fileData;
    }

    /**
     * Method for creating and saving in DB image file
     *
     * @param $fileName
     */
    public static function createImageFile($fileName)
    {
        $file = new self();

        $file->setScenario(self::SCENARIO_CREATE);

        $newPath =  realpath(Yii::$app->params['processedImages']) . '\\' . $fileName;

        $file->setAttributes([
            'file_name'         => $fileName,
            'file_path'         => $newPath,
            'file_mime_type'    => self::getMimeType($fileName),
            'file_extension_id' => FileExtension::find()
                ->where(['file_extension_name' => self::getExtension($fileName)])
                ->asArray()->one()['file_extension_id'],
            'file_created_at'        => time(),
            'file_updated_at'        => time()
        ]);

        if ($file->save(false)) {
            $message = [
                'name'         => 'MESSAGE',
                'image_name'   => $fileName,
                'status'       => self::MESSAGE_IMAGE_RESIZE_COMPLETED
            ];

            echo "\n" . json_encode($message);
        } else {
            $error = [
                'name'      => 'ERROR',
                'code'      => self::ERROR_CODE_IMAGE_NOT_SAVED,
                'message'   => self::ERROR_MESSAGE_IMAGE_NOT_SAVED,
                'file_path' => $newPath
            ];

            echo "\n" . json_encode($error);
        }
    }

    /**
     * Method for creating and saving in DB document file
     *
     * @param $fileName
     */
    public static function createDocumentFile($fileName)
    {
        $file = new self();

        $file->setScenario(self::SCENARIO_CREATE);

        $newPath =  realpath(Yii::$app->params['processedDocuments']) . '\\' . $fileName;

        $file->setAttributes([
            'file_name'         => $fileName,
            'file_path'         => $newPath,
            'file_mime_type'    => self::getMimeType($fileName),
            'file_extension_id' => FileExtension::find()
                ->where(['file_extension_name' => self::getExtension($fileName)])
                ->asArray()->one()['file_extension_id'],
            'file_created_at'        => time(),
            'file_updated_at'        => time()
        ]);

        if ($file->save(false)) {
            $message = [
                'name'          => 'MESSAGE',
                'document_name' => $fileName,
                'status'        => self::MESSAGE_DOCUMENT_CREATED
            ];

            echo "\n" . json_encode($message);
        } else {
            $error = [
                'name'    => 'ERROR',
                'code'    => self::ERROR_CODE_DOCUMENT_NOT_SAVED,
                'message' => self::ERROR_MESSAGE_DOCUMENT_NOT_SAVED,
                'file_path' => $newPath
            ];

            echo "\n" . json_encode($error);
        }
    }

    /**
     * Method for change method of saving files by extension
     *
     * @param $jsonData
     */
    public static function changeSaverByFileExtension($jsonData)
    {
        $fileData = json_decode($jsonData);

        $type = $fileData->mime_type;

        if (stristr($type, 'image')) {
            self::saveImageFile($jsonData);
        } elseif (
            (stristr($type, 'msword')) || (stristr($type, 'officedocument')) ||
            (stristr($type, 'excel')) ||(stristr($type, 'powerpoint')) ||
            (stristr($type, 'pdf')) || (stristr($type, 'html'))
        ) {
            self::saveDocumentFile($jsonData);
        } else {
            self::saveOtherFile($jsonData);
        }
    }

    /**
     *Method of saving unprocessed post file
     *
     *@param $data
     *@return string
     */
    public static function savePostImage($data) {
        $oldName = $data['name'];
        $newName = self::generateRandomString() . '.' . self::getExtension($oldName);
        $filePath = Yii::$app->params['unprocessedImages'] . $newName;
        $imageFile =  file_get_contents($data['tmp_name']);
        file_put_contents($filePath, $imageFile);

        return self::processPostImage($filePath);
    }

    /**
     *Method of processing post file
     *
     *@param $imageName
     *@return string
     */
    public static function processPostImage($imageName) {

        $fileBase64 = self::prepareFileToSending(realpath($imageName));

        $fileData = [
            'name'         => substr($imageName, strripos($imageName, '/') + 1),
            'path'         => realpath($imageName),
            'mime_type'    => self::getMimeType($imageName),
            'extension_id' => FileExtension::find()
                ->where(['file_extension_name' => self::getExtension($imageName)])
                ->asArray()->one()['file_extension_id'],
            'fileBase64'   => $fileBase64,
            'width'        => 500,
            'height'       => 500
        ];

        $newFileName = substr($fileData['name'], 0, strripos($fileData['name'], '.')) . '_' . $fileData['width'] . '_x_' . $fileData['height'] . '.' . self::getExtension($fileData['name']);

        $newPath = Url::base(true).'/files/images/processed/' . $newFileName;
echo Url::base(true).'/files/images/processed/' . $newFileName;
        self::sendFile('unprocessedFile', $fileData);
        return $newPath;
    }

    /**
     *Method of generating random string
     *
     *@param $length
     *@return string
     */
    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * Method for processing user photo by file path from administrator path
     *
     * @return string
     */
    public static function createUserPhoto() {
        $oldName = $_FILES['User']['name']['user_photo'];
        $newName = self::generateRandomString() . '_' . Yii::$app->params['userPhotoWidth'] . '_x_' . Yii::$app->params['userPhotoHeight'] . '.' . self::getExtension($oldName);
        $processedImage = Yii::$app->params['processedImages'] . $newName;
        $unprocessedImage = Yii::$app->params['unprocessedImages'] . $newName;
        $imageFile =  file_get_contents($_FILES['User']['tmp_name']['user_photo']);
        file_put_contents($unprocessedImage, $imageFile);

        $imageBox = new Box(Yii::$app->params['userPhotoWidth'], Yii::$app->params['userPhotoHeight']);
        Image::getImagine()->open($unprocessedImage)->resize($imageBox)->save($processedImage , ['quality' => 100]);

//        $userPhoto = Url::base(true) . '/files/images/processed/' . $newName;
        $userPhoto = realpath($processedImage);
        return $userPhoto;
    }

    /**
     * Method for processing user photo by base64 file path from rabbitMQ queue
     *
     * @param $file
     * @return string
     */
    public static function createUserPhotoFromBase64($file) {
        $imageData = base64_decode($file);
        $f = finfo_open();
        $mime_type = finfo_buffer($f, $imageData, FILEINFO_MIME_TYPE);
        $extension = substr($mime_type, (strripos($mime_type, '/') + 1));
        $newName = self::generateRandomString() . '_' . Yii::$app->params['userPhotoWidth'] . '_x_' . Yii::$app->params['userPhotoHeight'] . '.' . $extension;
        $processedImage = Yii::$app->params['processedImages'] . $newName;
        $unprocessedImage = Yii::$app->params['unprocessedImages'] . $newName;
//        $imageFile =  file_get_contents($_FILES['User']['tmp_name']['user_photo']);
        file_put_contents($unprocessedImage, $imageData);

        $imageBox = new Box(Yii::$app->params['userPhotoWidth'], Yii::$app->params['userPhotoHeight']);
        Image::getImagine()->open($unprocessedImage)->resize($imageBox)->save($processedImage , ['quality' => 100]);

        //$userPhoto = Url::base(true) . '/files/images/processed/' . $newName;
        $userPhoto = realpath($processedImage);

        return $userPhoto;
    }

    /**
     * @param $url
     * @return string
     */
    public static function createFullBase64($url) {
        $base64 = base64_encode(file_get_contents($url));
        $mime_type = finfo_buffer(finfo_open(), base64_decode($base64), FILEINFO_MIME_TYPE);
        $fullBase64 = 'data:' . $mime_type . ';base64,' . $base64;

        return $fullBase64;
    }

    /**
     *Method for getting file extension by file name
     *
     * @param $filename
     * @return string
     */
    public static function getExtension($filename) {

        return substr($filename, strripos($filename, '.'));
    }

    /**
     *Method for getting file mime-type by file name
     *
     * @param $filename
     * @throws
     * @return string
     */
    public static function getMimeType($filename) {

        return FileHelper::getMimeType($filename);
    }
}
