<?php

namespace app\models;

require_once  __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "user_education".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $school_name
 * @property string $country
 * @property string $location
 * @property string $from_month
 * @property string $from_year
 * @property string $to_month
 * @property string $to_year
 * @property string $specialization
 * @property string $description
 * @property string $document_type
 * @property string $license_number
 * @property integer $current_place
 */

class UserEducation extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_education';
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
                [
                    'name', 'school_name', 'country', 'location', 'from_month', 'from_year', 'to_month',
                    'to_year', 'specialization', 'description', 'document_type', 'license_number'
                ],
                'string',
                'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]
            ],
            [
                ['user_id', 'current_place'],
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
            'id'             => 'ID',
            'user_id'        => 'User ID',
            'name'           => 'Name',
            'school_name'    => 'School Name',
            'country'        => 'Country',
            'location'       => 'Location',
            'from_month'     => 'From Month',
            'from_year'      => 'From Year',
            'to_month'       => 'To Month',
            'to_year'        => 'To Year',
            'specialization' => 'Specialization',
            'description'    => 'Description',
            'document_type'  => 'Document Type',
            'license_number' => 'License Number',
            'current_place'  => 'Current Place'
        ];
    }

    /**
     * Create new user education method
     *
     * @param object $userData
     * @return boolean
     */
    public static function createUserEducation($userData)
    {
        $userEducation = new self();
        $userEducation->setScenario(self::SCENARIO_CREATE);

        $userEducation->setAttributes([
            'user_id'        => $userData->user_id,
            'name'           => $userData->name,
            'school_name'    => $userData->school_name,
            'country'        => $userData->country,
            'location'       => $userData->location,
            'from_month'     => $userData->from_month,
            'from_year'      => $userData->from_year,
            'to_month'       => (!empty($userData->to_month)) ? $userData->to_month : '',
            'to_year'        => (!empty($userData->to_year)) ? $userData->to_year : '',
            'specialization' => $userData->specialization,
            'description'    => $userData->description,
            'document_type'  => $userData->document_type,
            'license_number' => $userData->license_number,
            'current_place'  => (!empty($userData->current_place)) ? $userData->current_place : 0
        ]);

        if ($userEducation->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * Update user education method
     *
     * @param object $userData
     * @return boolean
     */
    public static function updateUserEducation($userData)
    {
        $userEducation = self::findOne(['id' => $userData->id]);
        $userEducation->setScenario(self::SCENARIO_UPDATE);

        $userEducation->setAttributes([
            'name'           => (!empty($userData->name)) ? $userData->name : $userEducation->name,
            'school_name'    => (!empty($userData->school_name)) ? $userData->school_name : $userEducation->school_name,
            'country'        => (!empty($userData->country)) ? $userData->country : $userEducation->country,
            'location'       => (!empty($userData->location)) ? $userData->location : $userEducation->location,
            'from_month'     => (!empty($userData->from_month)) ? $userData->from_month : $userEducation->from_month,
            'from_year'      => (!empty($userData->from_year)) ? $userData->from_year : $userEducation->from_year,
            'to_month'       => (!empty($userData->to_month)) ? $userData->to_month : $userEducation->to_month,
            'to_year'        => (!empty($userData->to_year)) ? $userData->to_year : $userEducation->to_year,
            'specialization' => (!empty($userData->specialization)) ? $userData->specialization : $userEducation->specialization,
            'description'    => (!empty($userData->description)) ? $userData->description : $userEducation->description,
            'document_type'  => (!empty($userData->document_type)) ? $userData->document_type : $userEducation->document_type,
            'license_number' => (!empty($userData->license_number)) ? $userData->license_number : $userEducation->license_number,
            'current_place'  => (!empty($userData->current_place)) ? $userData->current_place : $userEducation->current_place
        ]);

        if ($userEducation->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * Method of getting user educations data by user ID
     *
     * @param $userId
     * @return array
     */
    public static function getUserEducation($userId)
    {
        $userEducation = !empty(self::findOne(['user_id' => $userId])) ? self::find()->where(['user_id' => $userId])->asArray()->all() : [];

        return $userEducation;
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
    public static function receiveEducationData($queueName, $received = false)
    {
        $connection = new AMQPStreamConnection(Yii::$app->params['rabbitMQHost'], Yii::$app->params['rabbitMQPort'], Yii::$app->params['rabbitMQUser'], Yii::$app->params['rabbitMQPassword']);

        $channel = $connection->channel();
        $channel->queue_declare($queueName, false, false, false, false);
        $channel->queue_bind($queueName, Yii::$app->params['rabbitMQExchange'], $queueName);

        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

        $callback = function($msg) {
//            echo $msg->body;
            self::changeActionUserEducation($msg->body);
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
     * Method of getting user profile by ID
     *
     * @param $id
     * @return self
     */
    public static function getUserEducationById($id)
    {
        return self::findOne(['id' => $id]);
    }

    /**
     * Method of deleting user profile by ID
     *
     * @param $id
     * @throws
     * @return boolean
     */
    public static function deleteUserEducation($id)
    {
        $userEducation = self::findOne(['id' => $id]);

        return ($userEducation->delete()) ? true : false;
    }

    /**
     * Create new user education method
     *
     * @param $data
     * @throws
     * @return boolean
     */
    public static function createEducation($data)
    {
        $userEducation = new self();
        $userEducation->setScenario(self::SCENARIO_CREATE);

        $userEducation->setAttributes([
            'user_id'        =>  $data['user_id']->getAttribute('id'),
            'name'           => !empty($data['name']) ? $data['name'] : '',
            'school_name'    => !empty($data['school_name']) ? $data['school_name'] : '',
            'country'        => !empty($data['country']) ? $data['country'] : '',
            'location'       => !empty($data['location']) ? $data['location'] : '',
            'from_month'     => !empty($data['from_month']) ? $data['from_month'] : '',
            'from_year'      => !empty($data['from_year']) ? $data['from_year'] : '',
            'to_month'       => !empty($data['to_month']) ? $data['to_month'] : '',
            'to_year'        => !empty($data['to_year']) ? $data['to_year'] : '',
            'specialization' => !empty($data['specialization']) ? $data['specialization'] : '',
            'description'    => !empty($data['description']) ? $data['description'] : '',
            'document_type'  => !empty($data['document_type']) ? $data['document_type'] : '',
            'license_number' => !empty($data['license_number']) ? $data['license_number'] : '',
            'current_place'  => !empty($data['current_place']) ? $data['current_place'] : 0
        ]);

        return ($userEducation->save(false)) ? true : false;
    }

    /**
     * Update user education method
     *
     * @param array $data
     * @param string $id
     * @return boolean
     */
    public static function updateEducation($id, $data)
    {
        $userEducation = self::findOne(['id' => $id]);
        $userEducation->setScenario(self::SCENARIO_UPDATE);

        $userEducation->setAttributes([
            'name'           => empty($data['name']) ? $userEducation->name : $data['name'],
            'school_name'    => empty($data['school_name']) ? $userEducation->school_name : $data['school_name'],
            'country'        => empty($data['country']) ? $userEducation->country : $data['country'],
            'location'       => empty($data['location']) ? $userEducation->location : $data['location'],
            'from_month'     => empty($data['from_month']) ? $userEducation->from_month : $data['from_month'],
            'from_year'      => empty($data['from_year']) ? $userEducation->from_year : $data['from_year'],
            'to_month'       => empty($data['to_month']) ? $userEducation->to_month : $data['to_month'],
            'to_year'        => empty($data['to_year']) ? $userEducation->to_year : $data['to_year'],
            'specialization' => empty($data['specialization']) ? $userEducation->specialization : $data['specialization'],
            'description'    => empty($data['description']) ? $userEducation->description : $data['description'],
            'document_type'  => empty($data['document_type']) ? $userEducation->document_type : $data['document_type'],
            'license_number' => empty($data['license_number']) ? $userEducation->license_number : $data['license_number'],
            'current_place'  => empty($data['current_place']) ? $userEducation->current_place : $data['current_place']
        ]);

        return ($userEducation->save(false)) ? true : false;
    }

    /**
     * Method for change create or update method must be used by ID
     *
     * @param string $jsonData
     */
    public static function changeActionUserEducation($jsonData)
    {
        $userData = json_decode($jsonData);

        if (empty($userData->id)) {
            self::createUserEducation($userData);
        } else {
            self::updateUserEducation($userData);
        }
    }
}
