<?php

namespace app\models;

require_once  __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "user_certificate".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $path
 * @property string $mime_type
 */

class UserCertificate extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_certificate';
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
     * Create new user certificate method
     *
     * @param object $userData
     * @return boolean
     */
    public static function createUserCertificate($userData)
    {
        $userCertificate = new self();
        $userCertificate->setScenario(self::SCENARIO_CREATE);

        $userCertificate->setAttributes([
            'user_id'   => $userData->user_id,
            'name'      => $userData->name,
            'path'      => $userData->path,
            'mime_type' => $userData->mime_type
        ]);

        if ($userCertificate->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * Update user certificate method
     *
     * @param object $userData
     * @return boolean
     */
    public static function updateUserCertificate($userData)
    {
        $userCertificate = self::findOne(['id' => $userData->id]);
        $userCertificate->setScenario(self::SCENARIO_UPDATE);

        $userCertificate->setAttributes([
            'name'      => (!empty($userData->name)) ? $userData->name : $userCertificate->name,
            'path'      => (!empty($userData->path)) ? $userData->path : $userCertificate->path,
            'mime_type' => (!empty($userData->mime_type)) ? $userData->mime_type : $userCertificate->mime_type
        ]);

        if ($userCertificate->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * Method of getting user certificates data by user ID
     *
     * @param $userId
     * @return array
     */
    public static function getUserCertificate($userId)
    {
        $userCertificate = !empty(self::findOne(['user_id' => $userId])) ? self::find()->where(['user_id' => $userId])->asArray()->all() : [];

        return $userCertificate;
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
     * Method for receiving data for creating user profile of user with using rabbitMQ
     *
     * @param $queueName
     * @param $received
     */
    public static function receiveCertificateData($queueName, $received = false)
    {
        $connection = new AMQPStreamConnection(Yii::$app->params['rabbitMQHost'], Yii::$app->params['rabbitMQPort'], Yii::$app->params['rabbitMQUser'], Yii::$app->params['rabbitMQPassword']);

        $channel = $connection->channel();
        $channel->queue_declare($queueName, false, false, false, false);
        $channel->queue_bind($queueName, Yii::$app->params['rabbitMQExchange'], $queueName);

        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

        $callback = function($msg) {
//            echo $msg->body;
            self::changeActionUserCertificate($msg->body);
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
     * Method of getting user certificate by ID
     *
     * @param $id
     * @return self
     */
    public static function getUserCertificateById($id)
    {
        return self::findOne(['id' => $id]);
    }

    /**
     * Method of deleting user certificate by ID
     *
     * @param $id
     * @throws
     * @return boolean
     */
    public static function deleteUserCertificate($id)
    {
        $userCertificate = self::findOne(['id' => $id]);

        return ($userCertificate->delete()) ? true : false;
    }

    /**
     * Create new user certificate method
     *
     * @param array $data
     * @throws
     * @return boolean
     */
    public static function createCertificate($data)
    {
        $userCertificate = new self();
        $userCertificate->setScenario(self::SCENARIO_CREATE);

        $userCertificate->setAttributes([
            'user_id'   => $data['user_id'],
            'name'      => !empty($data['name']) ? $data['name'] : '',
            'path'      => !empty($data['path']) ? $data['path'] : '',
            'mime_type' => !empty($data['mime_type']) ? $data['mime_type'] : ''
        ]);

        return ($userCertificate->save(false)) ? true : false;
    }

    /**
     * Update user certificate method
     *
     * @param array $data
     * @param string $id
     * @return boolean
     */
    public static function updateCertificate($id, $data)
    {
        $userCertificate = self::findOne(['id' => $id]);
        $userCertificate->setScenario(self::SCENARIO_UPDATE);

        $userCertificate->setAttributes([
            'name'      => empty($data['name']) ? $userCertificate->name : $data['name'],
            'path'      => empty($data['path']) ? $userCertificate->path : $data['path'],
            'mime_type' => empty($data['mime_type']) ? $userCertificate->mime_type : $data['mime_type']
        ]);

        return ($userCertificate->save(false)) ? true : false;
    }

    /**
     * Method for change create or update method must be used by ID
     *
     * @param string $jsonData
     */
    public static function changeActionUserCertificate($jsonData)
    {
        $userData = json_decode($jsonData);

        if (empty($userData->id)) {
            self::createUserCertificate($userData);
        } else {
            self::updateUserCertificate($userData);
        }
    }

    public static function addCertificate($userId, $fileName, $filePath, $fileMimeType)
    {
        $certificate = new self();
        $certificate->user_id = $userId;
        $certificate->name = $fileName;
        $certificate->path = $filePath;
        $certificate->mime_type = $fileMimeType;

        if ($certificate->save()) {

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
    public static function saveCertificate($userId) {
        $oldName = $_FILES['UserCertificate']['name']['path'];
        $newName = File::generateRandomString() . File::getExtension($oldName);
        $fileUrl = Yii::$app->params['processedDocumentsUrl'] . $newName;
        $filePath = realpath(Yii::$app->params['processedDocumentsUrl']) . '/' . $newName;
        $dataFile =  file_get_contents($_FILES['UserCertificate']['tmp_name']['path']);
        file_put_contents($filePath, $dataFile);
        $mimeType = File::getMimeType(realpath($filePath));
        self::addCertificate($userId, $fileUrl, $filePath, $mimeType);

        return true;
    }
}
