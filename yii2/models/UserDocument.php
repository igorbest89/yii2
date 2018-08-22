<?php

namespace app\models;

require_once  __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "user_document".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $path
 * @property string $mime_type
 */

class UserDocument extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_document';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['user_id'],
                'required',
                'on' => [self::SCENARIO_CREATE]
            ],
            [
                ['name', 'path', 'mime_type'],
                'string',
                'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]
            ],
            [
                ['user_id'],
                'integer',
                'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]
            ],
            [
                ['id'],
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
            'id'        => 'ID',
            'user_id'   => 'User ID',
            'name'      => 'Name',
            'path'      => 'Path',
            'mime_type' => 'Mime Type'
        ];
    }

    /**
     * Create new user document method
     *
     * @param object $userData
     * @return boolean
     */
    public static function createUserDocument($userData)
    {
        $userDocument = new self();
        $userDocument->setScenario(self::SCENARIO_CREATE);

        $userDocument->setAttributes([
            'user_id'   => $userData->user_id,
            'name'      => $userData->name,
            'path'      => $userData->path,
            'mime_type' => $userData->mime_type
        ]);

        if ($userDocument->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * Update user document method
     *
     * @param object $userData
     * @return boolean
     */
    public static function updateUserDocument($userData)
    {
        $userDocument = self::findOne(['id' => $userData->id]);
        $userDocument->setScenario(self::SCENARIO_UPDATE);

        $userDocument->setAttributes([
            'name'      => (!empty($userData->name)) ? $userData->name : $userDocument->name,
            'path'      => (!empty($userData->path)) ? $userData->path : $userDocument->path,
            'mime_type' => (!empty($userData->mime_type)) ? $userData->mime_type : $userDocument->mime_type
        ]);

        if ($userDocument->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * Method of getting user documents data by user ID
     *
     * @param $userId
     * @return array
     */
    public static function getUserDocument($userId)
    {
        $userDocument = !empty(self::findOne(['user_id' => $userId])) ? self::find()->where(['user_id' => $userId])->asArray()->all() : [];

        return $userDocument;
    }

    /**
     * Method for creating queue and sending some data with using rabbitMQ
     *
     * @param $queueName
     * @param $data
     */
    public static function sendData($queueName, $data)
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
     * Method for receiving data for creating user document of user with using rabbitMQ
     *
     * @param $queueName
     * @param $received
     */
    public static function receiveDocumentData($queueName, $received = false)
    {
        $connection = new AMQPStreamConnection(Yii::$app->params['rabbitMQHost'], Yii::$app->params['rabbitMQPort'], Yii::$app->params['rabbitMQUser'], Yii::$app->params['rabbitMQPassword']);

        $channel = $connection->channel();
        $channel->queue_declare($queueName, false, false, false, false);
        $channel->queue_bind($queueName, Yii::$app->params['rabbitMQExchange'], $queueName);

        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

        $callback = function($msg) {
//            echo $msg->body;
            self::changeActionUserDocument($msg->body);
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
     * Method of getting user document by ID
     *
     * @param $id
     * @return self
     */
    public static function getUserDocumentById($id)
    {
        return self::findOne(['id' => $id]);
    }

    /**
     * Method of deleting user document by ID
     *
     * @param $id
     * @throws
     * @return boolean
     */
    public static function deleteUserDocument($id)
    {
        $userDocument = self::findOne(['id' => $id]);

        return ($userDocument->delete()) ? true : false;
    }

    /**
     * Create new user document method
     *
     * @param array $data
     * @throws
     * @return boolean
     */
    public static function createDocument($data)
    {
        $userDocument = new self();
        $userDocument->setScenario(self::SCENARIO_CREATE);

        $userDocument->setAttributes([
            'user_id'   => $data['user_id'],
            'name'      => !empty($data['name']) ? $data['name'] : '',
            'path'      => !empty($data['path']) ? $data['path'] : '',
            'mime_type' => !empty($data['mime_type']) ? $data['mime_type'] : ''
        ]);

        return ($userDocument->save(false)) ? true : false;
    }

    /**
     * Update user document method
     *
     * @param array $data
     * @param string $id
     * @return boolean
     */
    public static function updateDocument($id, $data)
    {
        $userDocument = self::findOne(['id' => $id]);
        $userDocument->setScenario(self::SCENARIO_UPDATE);

        $userDocument->setAttributes([
            'name'      => empty($data['name']) ? $userDocument->name : $data['name'],
            'path'      => empty($data['path']) ? $userDocument->path : $data['path'],
            'mime_type' => empty($data['mime_type']) ? $userDocument->mime_type : $data['mime_type']
        ]);

        return ($userDocument->save(false)) ? true : false;
    }

    /**
     * Method for change create or update method must be used by ID
     *
     * @param string $jsonData
     */
    public static function changeActionUserDocument($jsonData)
    {
        $userData = json_decode($jsonData);

        if (empty($userData->id)) {
            self::createUserDocument($userData);
        } else {
            self::updateUserDocument($userData);
        }
    }

    public static function addDocument($userId, $fileName, $filePath, $fileMimeType)
    {
        $document = new self();
        $document->user_id = $userId;
        $document->name = $fileName;
        $document->path = $filePath;
        $document->mime_type = $fileMimeType;

        if ($document->save()) {

            return true;
        } else {

            return false;
        }
    }

    /**
     * Method for saving files
     *
     * @param $userId
     * @return string
     */
    public static function saveDocument($userId) {
        $oldName = $_FILES['UserDocument']['name']['path'];
        $newName = File::generateRandomString() . File::getExtension($oldName);
        $fileUrl = Yii::$app->params['processedDocumentsUrl'] . $newName;
        $filePath = realpath(Yii::$app->params['processedDocumentsUrl']) . '/' . $newName;
        $dataFile =  file_get_contents($_FILES['UserDocument']['tmp_name']['path']);
        file_put_contents($filePath, $dataFile);
        $mimeType = File::getMimeType(realpath($filePath));
        self::addDocument($userId, $fileUrl, $filePath, $mimeType);

        return true;
    }
}
