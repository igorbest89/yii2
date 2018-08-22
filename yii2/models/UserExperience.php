<?php

namespace app\models;

require_once  __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "user_experience".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $job_title
 * @property string $employer
 * @property string $country
 * @property string $location
 * @property string $from_month
 * @property string $from_year
 * @property string $to_month
 * @property string $to_year
 * @property string $achievements
 * @property integer $current_place
 */

class UserExperience extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_experience';
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
                    'job_title', 'employer', 'country', 'location', 'from_month', 'from_year', 'to_month',
                    'to_year', 'achievements'
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
            'job_title'      => 'Job Title',
            'employer'       => 'Employer',
            'country'        => 'Country',
            'location'       => 'Location',
            'from_month'     => 'From Month',
            'from_year'      => 'From Year',
            'to_month'       => 'To Month',
            'to_year'        => 'To Year',
            'achievements'   => 'Achievements',
            'current_place'  => 'Current Place'
        ];
    }

    /**
     * Create new user experience method
     *
     * @param object $userData
     * @return boolean
     */
    public static function createUserExperience($userData)
    {
        $userExperience = new self();
        $userExperience->setScenario(self::SCENARIO_CREATE);

        $userExperience->setAttributes([
            'user_id'        => $userData->user_id,
            'job_title'      => $userData->job_title,
            'employer'       => $userData->employer,
            'country'        => $userData->country,
            'location'       => $userData->location,
            'from_month'     => $userData->from_month,
            'from_year'      => $userData->from_year,
            'to_month'       => (!empty($userData->to_month)) ? $userData->to_month : '',
            'to_year'        => (!empty($userData->to_year)) ? $userData->to_year : '',
            'achievements'   => $userData->achievements,
            'current_place'  => (!empty($userData->current_place)) ? $userData->current_place : 0
        ]);

        if ($userExperience->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * Update user experience method
     *
     * @param object $userData
     * @return boolean
     */
    public static function updateUserExperience($userData)
    {
        $userExperience = self::findOne(['id' => $userData->id]);
        $userExperience->setScenario(self::SCENARIO_UPDATE);

        $userExperience->setAttributes([
            'job_title'      => (!empty($userData->job_title)) ? $userData->job_title : $userExperience->job_title,
            'employer'       => (!empty($userData->employer)) ? $userData->employer : $userExperience->employer,
            'country'        => (!empty($userData->country)) ? $userData->country : $userExperience->country,
            'location'       => (!empty($userData->location)) ? $userData->location : $userExperience->location,
            'from_month'     => (!empty($userData->from_month)) ? $userData->from_month : $userExperience->from_month,
            'from_year'      => (!empty($userData->from_year)) ? $userData->from_year : $userExperience->from_year,
            'to_month'       => (!empty($userData->to_month)) ? $userData->to_month : $userExperience->to_month,
            'to_year'        => (!empty($userData->to_year)) ? $userData->to_year : $userExperience->to_year,
            'achievements'   => (!empty($userData->achievements)) ? $userData->achievements : $userExperience->achievements,
            'current_place'  => (!empty($userData->current_place)) ? $userData->current_place : $userExperience->current_place
        ]);

        if ($userExperience->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * Method of getting user experience data by user ID
     *
     * @param $userId
     * @return array
     */
    public static function getUserExperience($userId)
    {
        $userExperience = !empty(self::findOne(['user_id' => $userId])) ? self::find()->where(['user_id' => $userId])->asArray()->all() : [];

        return $userExperience;
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
            self::changeActionUserExperience($msg->body);
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
     * Method of getting user experience by ID
     *
     * @param $id
     * @return self
     */
    public static function getUserExperienceById($id)
    {
        return self::findOne(['id' => $id]);
    }

    /**
     * Method of deleting user experience by ID
     *
     * @param $id
     * @throws
     * @return boolean
     */
    public static function deleteUserExperience($id)
    {
        $userExperience = self::findOne(['id' => $id]);

        return ($userExperience->delete()) ? true : false;
    }

    /**
     * Create new user experience method
     *
     * @param $data
     * @throws
     * @return boolean
     */
    public static function createExperience($data)
    {
        $userExperience = new self();
        $userExperience->setScenario(self::SCENARIO_CREATE);

        $userExperience->setAttributes([
            'user_id'        => $data['user_id']->getAttribute('id'),
            'job_title'      => !empty($data['job_title']) ? $data['job_title'] : '',
            'employer'       => !empty($data['employer']) ? $data['employer'] : '',
            'country'        => !empty($data['country']) ? $data['country'] : '',
            'location'       => !empty($data['location']) ? $data['location'] : '',
            'from_month'     => !empty($data['from_month']) ? $data['from_month'] : '',
            'from_year'      => !empty($data['from_year']) ? $data['from_year'] : '',
            'to_month'       => !empty($data['to_month']) ? $data['to_month'] : '',
            'to_year'        => !empty($data['to_year']) ? $data['to_year'] : '',
            'achievements'   => !empty($data['achievements']) ? $data['achievements'] : '',
            'current_place'  => !empty($data['current_place']) ? $data['current_place'] : 0
        ]);

        return ($userExperience->save(false)) ? true : false;
    }

    /**
     * Update user experience method
     *
     * @param array $data
     * @param string $id
     * @return boolean
     */
    public static function updateExperience($id, $data)
    {
        $userExperience = self::findOne(['id' => $id]);
        $userExperience->setScenario(self::SCENARIO_UPDATE);

        $userExperience->setAttributes([
            'job_title'      => empty($data['job_title']) ? $userExperience->job_title : $data['job_title'],
            'employer'       => empty($data['employer']) ? $userExperience->employer : $data['employer'],
            'country'        => empty($data['country']) ? $userExperience->country : $data['country'],
            'location'       => empty($data['location']) ? $userExperience->location : $data['location'],
            'from_month'     => empty($data['from_month']) ? $userExperience->from_month : $data['from_month'],
            'from_year'      => empty($data['from_year']) ? $userExperience->from_year : $data['from_year'],
            'to_month'       => empty($data['to_month']) ? $userExperience->to_month : $data['to_month'],
            'to_year'        => empty($data['to_year']) ? $userExperience->to_year : $data['to_year'],
            'achievements'   => empty($data['achievements']) ? $userExperience->achievements : $data['achievements'],
            'current_place'  => empty($data['current_place']) ? $userExperience->current_place : $data['current_place']
        ]);

        return ($userExperience->save(false)) ? true : false;
    }

    /**
     * Method for change create or update method must be used by ID
     *
     * @param string $jsonData
     */
    public static function changeActionUserExperience($jsonData)
    {
        $userData = json_decode($jsonData);

        if (empty($userData->id)) {
            self::createUserExperience($userData);
        } else {
            self::updateUserExperience($userData);
        }
    }
}
