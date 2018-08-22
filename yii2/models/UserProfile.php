<?php

namespace app\models;

require_once  __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $gender
 * @property integer $date_of_birth
 * @property string $country
 * @property integer $state
 * @property integer $city
 * @property string $country_of_birth
 * @property string $phone
 * @property string $address
 * @property string $zip
 * @property string $overview
 * @property string $skills
 * @property string $strengths
 * @property string $marital_status
 * @property string $interests
 */

class UserProfile extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['email', 'user_id'],
                'required',
                'on' => [self::SCENARIO_CREATE]
            ],
            [
                [
                    'email', 'first_name', 'last_name', 'middle_name', 'gender', 'country', 'country_of_birth',
                    'phone', 'address', 'zip', 'overview', 'skills', 'strengths', 'marital_status', 'interests'
                ],
                'string',
                'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]
            ],
            [
                ['user_id', 'date_of_birth', 'state', 'city'],
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
            'id'                    => 'ID',
            'user_id'               => 'User ID',
            'email'                 => 'Email',
            'first_name'            => 'First Name',
            'last_name'             => 'Last Name',
            'middle_name'           => 'Middle Name',
            'gender'                => 'Gender',
            'country'               => 'Country',
            'country_of_birth'      => 'Place Of Birth',
            'phone'                 => 'Phone Number',
            'address'               => 'Address',
            'zip'                   => 'ZIP Code',
            'overview'              => 'Overview',
            'skills'                => 'Skills',
            'strengths'             => 'Strengths',
            'marital_status'        => 'Martial Status',
            'interests'             => 'Interests',
            'date_of_birth'         => 'Date Of Birth',
            'state'                 => 'State',
            'city'                  => 'City'
        ];
    }

    /**
     * Get user profile by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return self::findOne(['email' => $email]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->user_id;
    }

    /**
     * Create new user profile method
     *
     * @param object $userData
     * @return boolean
     */
    public static function createUserProfile($userData)
    {
        $userProfile = new self();
        $userProfile->setScenario(self::SCENARIO_CREATE);

        $userProfile->setAttributes([
            'email'            => $userData->email,
            'user_id'          => $userData->user_id,
            'first_name'       => $userData->first_name,
            'last_name'        => $userData->last_name,
            'middle_name'      => !empty($userData->middle_name) ? $userData->middle_name : '',
            'gender'           => $userData->gender,
            'country'          => $userData->country,
            'country_of_birth' => $userData->country_of_birth,
            'phone'            => $userData->phone,
            'address'          => $userData->address,
            'zip'              => $userData->zip,
            'overview'         => $userData->overview,
            'skills'           => $userData->skills,
            'strengths'        => $userData->strengths,
            'marital_status'   => $userData->marital_status,
            'interests'        => $userData->interests,
            'date_of_birth'    => $userData->date_of_birth,
            'state'            => $userData->state,
            'city'             => $userData->city
        ]);

        if ($userProfile->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * Update user profile method
     *
     * @param object $userData
     * @return boolean
     */
    public static function updateUserProfile($userData)
    {
        $userProfile = self::findOne(['user_id' => $userData->user_id]);
        $userProfile->setScenario(self::SCENARIO_UPDATE);

        $userProfile->setAttributes([
            'email'            => empty($userData->email) ? $userProfile->email : $userData->email,
            'first_name'       => empty($userData->first_name) ? $userProfile->first_name : $userData->first_name,
            'last_name'        => empty($userData->last_name) ? $userProfile->last_name : $userData->last_name,
            'middle_name'      => empty($userData->middle_name) ? $userProfile->middle_name : $userData->middle_name,
            'gender'           => empty($userData->gender) ? $userProfile->gender : $userData->gender,
            'country'          => empty($userData->country) ? $userProfile->country : $userData->country,
            'country_of_birth' => empty($userData->country_of_birth) ? $userProfile->country_of_birth : $userData->country_of_birth,
            'phone'            => empty($userData->phone) ? $userProfile->phone : $userData->phone,
            'address'          => empty($userData->address) ? $userProfile->address : $userData->address,
            'zip'              => empty($userData->zip) ? $userProfile->zip : $userData->zip,
            'overview'         => empty($userData->overview) ? $userProfile->overview : $userData->overview,
            'skills'           => empty($userData->skills) ? $userProfile->skills : $userData->skills,
            'strengths'        => empty($userData->strengths) ? $userProfile->strengths : $userData->strengths,
            'marital_status'   => empty($userData->marital_status) ? $userProfile->marital_status : $userData->marital_status,
            'interests'        => empty($userData->interests) ? $userProfile->interests : $userData->interests,
            'date_of_birth'    => empty($userData->date_of_birth) ? $userProfile->date_of_birth : $userData->date_of_birth,
            'state'            => empty($userData->state) ? $userProfile->state : $userData->state,
            'city'             => empty($userData->user_password) ? $userProfile->state : $userData->state
        ]);

        if ($userProfile->save(false)) {
            return true;
        }

        return false;
    }

    /**
     * Method of getting user profile data by user ID
     *
     * @param $userId
     * @return array
     */
    public static function getUserProfile($userId)
    {
        $userProfile = !empty(self::findOne(['user_id' => $userId])) ? self::find()->where(['user_id' => $userId])->asArray()->one() : [];

        return $userProfile;
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
    public static function receiveProfileData($queueName, $received = false)
    {
        $connection = new AMQPStreamConnection(Yii::$app->params['rabbitMQHost'], Yii::$app->params['rabbitMQPort'], Yii::$app->params['rabbitMQUser'], Yii::$app->params['rabbitMQPassword']);

        $channel = $connection->channel();
        $channel->queue_declare($queueName, false, false, false, false);
        $channel->queue_bind($queueName, Yii::$app->params['rabbitMQExchange'], $queueName);

        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

        $callback = function($msg) {
//            echo $msg->body;
            self::changeActionUserProfile($msg->body);
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
     * Method of getting all profiles
     */
    public static function getAllProfiles ()
    {
        return self::find();
    }

    /**
     * Method of getting user profile by ID
     *
     * @param $id
     * @return self
     */
    public static function getUserProfileById($id)
    {
        return self::findOne(['user_id' => $id]);
    }

    /**
     * Method of deleting user profile by ID
     *
     * @param $id
     * @throws
     * @return boolean
     */
    public static function deleteUserProfile($id)
    {
        $userProfile = self::findOne(['user_id' => $id]);
        $currentAdminId = User::findOne(['user_email' => Yii::$app->session->get('email')])->user_id;

        if ($currentAdminId == $id) {
            return false;
        }

        return ($userProfile->delete()) ? true : false;
    }

    /**
     * Create new user profile method
     *
     * @param array $data
     * @throws
     * @return boolean
     */
    public static function createProfile($data)
    {
        $userProfile = new self();
        $userProfile->setScenario(self::SCENARIO_CREATE);

        $userProfile->setAttributes([
            'email'            => $data['email'],
            'user_id'          => $data['user_id']->getAttribute('id'),
            'first_name'       => !empty($data['first_name']) ? $data['first_name'] : '',
            'last_name'        => !empty($data['last_name']) ? $data['last_name'] : '',
            'middle_name'      => !empty($data['middle_name']) ? $data['middle_name'] : '',
            'gender'           => !empty($data['gender']) ? $data['gender'] : '',
            'country'          => !empty($data['country']) ? $data['country'] : '',$data['country'],
            'country_of_birth' => !empty($data['country_of_birth']) ? $data['country_of_birth'] : '',
            'phone'            => !empty($data['phone']) ? $data['phone'] : '',
            'address'          => !empty($data['address']) ? $data['address'] : '',
            'zip'              => !empty($data['zip']) ? $data['zip'] : '',
            'overview'         => !empty($data['overview']) ? $data['overview'] : '',
            'skills'           => !empty($data['skills']) ? $data['skills'] : '',
            'strengths'        => !empty($data['strengths']) ? $data['strengths'] : '',
            'marital_status'   => !empty($data['marital_status']) ? $data['marital_status'] : '',
            'interests'        => !empty($data['interests']) ? $data['interests'] : '',
            'date_of_birth'    => !empty($data['date_of_birth']) ? $data['date_of_birth'] : '',
            'state'            => !empty($data['state']) ? $data['state'] : '',
            'city'             => !empty($data['city']) ? $data['city'] : ''
        ]);

        return ($userProfile->save(false)) ? true : false;
    }

    /**
     * Update user profile method
     *
     * @param array $data
     * @param string $id
     * @return boolean
     */
    public static function updateProfile($id, $data)
    {
        $userProfile = self::findOne(['user_id' => $id]);
        $userProfile->setScenario(self::SCENARIO_UPDATE);

        $userProfile->setAttributes([
            'email'            => empty($data['email']) ? $userProfile->email : $data['email'],
            'first_name'       => empty($data['first_name']) ? $userProfile->first_name : $data['first_name'],
            'last_name'        => empty($data['last_name']) ? $userProfile->last_name : $data['last_name'],
            'middle_name'      => empty($data['middle_name']) ? $userProfile->middle_name : $data['middle_name'],
            'gender'           => empty($data['gender']) ? $userProfile->gender : $data['gender'],
            'country'          => empty($data['country']) ? $userProfile->country : $data['country'],
            'country_of_birth' => empty($data['country_of_birth']) ? $userProfile->country_of_birth : $data['country_of_birth'],
            'phone'            => empty($data['phone']) ? $userProfile->phone : $data['phone'],
            'address'          => empty($data['address']) ? $userProfile->address : $data['address'],
            'zip'              => empty($data['zip']) ? $userProfile->zip : $data['zip'],
            'overview'         => empty($data['overview']) ? $userProfile->overview : $data['overview'],
            'skills'           => empty($data['skills']) ? $userProfile->skills : $data['skills'],
            'strengths'        => empty($data['strengths']) ? $userProfile->strengths : $data['strengths'],
            'marital_status'   => empty($data['marital_status']) ? $userProfile->marital_status : $data['marital_status'],
            'interests'        => empty($data['interests']) ? $userProfile->interests : $data['interests'],
            'date_of_birth'    => empty($data['date_of_birth']) ? $userProfile->date_of_birth : $data['date_of_birth'],
            'state'            => empty($data['state']) ? $userProfile->state : $data['state'],
            'city'             => empty($data['city']) ? $userProfile->city : $data['city']
        ]);

        return ($userProfile->save(false)) ? true : false;
    }

    /**
     * Method for change create or update method must be used by user ID
     * @param string $jsonData
     */
    public static function changeActionUserProfile($jsonData)
    {
        $userData = json_decode($jsonData);
        $userProfile = self::findOne(['user_id' => $userData->user_id]);

        if (!$userProfile) {
            self::createUserProfile($userData);
        } else {
            self::updateUserProfile($userData);
        }
    }

    public function getExp(){
        return $this->hasMany(UserExperience::className(),['user_id' => 'user_id']);
    }
    public function getEducation(){
        return $this->hasMany(UserEducation::className(),['user_id' => 'user_id']);
    }
    public function getDocument(){
        return $this->hasMany(UserDocument::className(),['user_id' => 'user_id']);
    }
    public function getCertificate(){
        return $this->hasMany(UserCertificate::className(),['user_id' => 'user_id']);
    }

    public function getCountryData()
    {
        return $this->hasOne(Countries::className(),['code' => 'country']);
    }
}
