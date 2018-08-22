<?php

namespace app\models;

require_once  __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "user_reference".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $surname
 * @property string $job_title
 * @property string $company_name
 * @property string $phone
 * @property string $email
 */

class UserReference extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_reference';
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
                ['name', 'surname', 'job_title', 'company_name', 'phone', 'email'],
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
            'id'           => 'ID',
            'user_id'      => 'User ID',
            'name'         => 'Name',
            'surname'      => 'Path',
            'job_title'    => 'Job Title',
            'company_name' => 'Company Name',
            'phone'        => 'Phone Number',
            'email'        => 'Email'
        ];
    }

    /**
     * Create new user reference method
     *
     * @param object $userData
     * @return boolean
     */
    public static function createUserReference($userData)
    {
        $userReference = new self();
        $userReference->setScenario(self::SCENARIO_CREATE);

        $userReference->setAttributes([
            'user_id'      => $userData->user_id,
            'name'         => $userData->name,
            'company_name' => $userData->company_name,
            'surname'      => $userData->surname,
            'job_title'    => $userData->job_title,
            'phone'        => $userData->phone,
            'email'        => $userData->email
        ]);

        if ($userReference->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * Update user reference method
     *
     * @param object $userData
     * @return boolean
     */
    public static function updateUserReference($userData)
    {
        $userReference = self::findOne(['id' => $userData->id]);
        $userReference->setScenario(self::SCENARIO_UPDATE);

        $userReference->setAttributes([
            'name'         => (!empty($userData->name)) ? $userData->name : $userReference->name,
            'company_name' => (!empty($userData->company_name)) ? $userData->company_name : $userReference->company_name,
            'surname'      => (!empty($userData->surname)) ? $userData->surname : $userReference->surname,
            'job_title'    => (!empty($userData->job_title)) ? $userData->job_title : $userReference->job_title,
            'phone'        => (!empty($userData->phone)) ? $userData->phone : $userReference->phone,
            'email'        => (!empty($userData->email)) ? $userData->email : $userReference->email
        ]);

        if ($userReference->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * Method of getting user references data by user ID
     *
     * @param $userId
     * @return array
     */
    public static function getUserReference($userId)
    {
        $userReference = !empty(self::findOne(['user_id' => $userId])) ? self::find()->where(['user_id' => $userId])->asArray()->all() : [];

        return $userReference;
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
     * Method for receiving data for creating user reference of user with using rabbitMQ
     *
     * @param $queueName
     * @param $received
     */
    public static function receiveReferenceData($queueName, $received = false)
    {
        $connection = new AMQPStreamConnection(Yii::$app->params['rabbitMQHost'], Yii::$app->params['rabbitMQPort'], Yii::$app->params['rabbitMQUser'], Yii::$app->params['rabbitMQPassword']);

        $channel = $connection->channel();
        $channel->queue_declare($queueName, false, false, false, false);
        $channel->queue_bind($queueName, Yii::$app->params['rabbitMQExchange'], $queueName);

        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

        $callback = function($msg) {
//            echo $msg->body;
            self::changeActionUserReference($msg->body);
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
     * Method of getting user reference by ID
     *
     * @param $id
     * @return self
     */
    public static function getUserReferenceById($id)
    {
        return self::findOne(['id' => $id]);
    }

    /**
     * Method of deleting user reference by ID
     *
     * @param $id
     * @throws
     * @return boolean
     */
    public static function deleteUserReference($id)
    {
        $userReference = self::findOne(['id' => $id]);

        return ($userReference->delete()) ? true : false;
    }

    /**
     * Create new user reference method
     *
     * @param array $data
     * @throws
     * @return boolean
     */
    public static function createReference($data)
    {
        $userReference = new self();
        $userReference->setScenario(self::SCENARIO_CREATE);

        $userReference->setAttributes([
            'user_id'      =>  $data['user_id']->getAttribute('id'),
            'name'         => !empty($data['name']) ? $data['name'] : '',
            'company_name' => !empty($data['company_name']) ? $data['company_name'] : '',
            'surname'      => !empty($data['surname']) ? $data['surname'] : '',
            'job_title'    => !empty($data['job_title']) ? $data['job_title'] : '',
            'phone'        => !empty($data['phone']) ? $data['phone'] : '',
            'email'        => !empty($data['email']) ? $data['email'] : ''
        ]);

        return ($userReference->save(false)) ? true : false;
    }

    /**
     * Update user reference method
     *
     * @param array $data
     * @param string $id
     * @return boolean
     */
    public static function updateReference($id, $data)
    {
        $userReference = self::findOne(['id' => $id]);
        $userReference->setScenario(self::SCENARIO_UPDATE);

        $userReference->setAttributes([
            'name'         => empty($data['name']) ? $userReference->name : $data['name'],
            'email'        => empty($data['email']) ? $userReference->email : $data['email'],
            'company_name' => empty($data['company_name']) ? $userReference->company_name : $data['company_name'],
            'surname'      => empty($data['surname']) ? $userReference->surname : $data['surname'],
            'job_title'    => empty($data['job_title']) ? $userReference->job_title : $data['job_title'],
            'phone'        => empty($data['phone']) ? $userReference->phone : $data['phone']
        ]);

        return ($userReference->save(false)) ? true : false;
    }

    /**
     * Method for change create or update method must be used by ID
     *
     * @param string $jsonData
     */
    public static function changeActionUserReference($jsonData)
    {
        $userData = json_decode($jsonData);

        if (empty($userData->id)) {
            self::createUserReference($userData);
        } else {
            self::updateUserReference($userData);
        }
    }
}
