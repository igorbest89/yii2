<?php

namespace app\models;
use Yii;
use mdm\admin\models\User as UserModel;
class User extends  UserModel
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const DEFAULT_ROLE = 'User';
    /*Errors codes and messages*/
    const ERROR_CODE_USER_EMAIL_NOT_FOUND = 10;
    const ERROR_MESSAGE_USER_EMAIL_NOT_FOUND = 'User with this email is not found in DB!';
    const ERROR_CODE_PASSWORD_NOT_VALID = 11;
    const ERROR_MESSAGE_PASSWORD_NOT_VALID = 'Password is not valid!';
    const ERROR_CODE_CONFIRM_LINK_NOT_VALID = 12;
    const ERROR_MESSAGE_CONFIRM_LINK_NOT_VALID = 'Confirm link is not valid!';

    const ERROR_CODE_INTERNAL_SERVER_DATA_NOT_SAVED = 20;
    const ERROR_MESSAGE_INTERNAL_SERVER_DATA_NOT_SAVED = 'Server internal error. Data is not saved. Try later.';
    const ERROR_CODE_PASSWORD_NOT_RECOVERED = 21;
    const ERROR_MESSAGE_PASSWORD_NOT_RECOVERED = 'Server internal error. Password is not recovered, changes not saved. Try later.';

    //Success messages
    const MESSAGE_USER_CREATED = 'Is created!';
    const MESSAGE_USER_CONFIRMED = 'Is confirmed!';
    const MESSAGE_USER_UPDATED = 'Is updated!';
    const MESSAGE_USER_SAVED = 'Created and saved in DB!';

    //User roles
    const USER_ROLE  = 'user';
    const ADMIN_ROLE = 'administrator';
    const GUEST_ROLE = 'guest';

    //User statuses
    const USER_STATUS_ENABLED  = 1;
    const USER_STATUS_DISABLED = 0;



//    public $id;
//    public $email;
//    public $username;
    public $password_hash;
//    public $passwordRepeat;
//    public $authKey;
//    public $accessToken;
//    public $payments;
//    public $new_password;
//    public $status;
//    public $new_password_confirm;
//    public $password_hash;
    public $user_date_births;
    public static $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    public static $marital = ['Unmarried', 'Married'];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['username','auth_key', 'password_hash'],
                'required',
                'on' => [self::SCENARIO_CREATE]
            ],
            [
                ['email', 'username', 'user_city', 'user_phone1', 'user_phone2', 'user_description', 'auth_key', 'user_cv_url', 'user_photo'],
                'string',
                'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]
            ],
            [
                ['user_country', 'user_permission'],
                'integer',
                'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]
            ],
            [
                ['id', 'user_status', 'user_date_last_login', 'user_date_add', 'user_date_births', 'user_status', 'user_token', 'user_cv_url', 'user_photo', 'user_experience_years', 'password_hash'],
                'safe',
                'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]
            ],
//            [
//                ['new_password_confirm', 'new_password'],
//                'validatePasswords',
//                'skipOnError' => false,
//                'on'          => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE],
//            ]
        ];
    }

    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return isset ($id) ? self::findOne(['id' => $id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $accessToken = self::findOne(['user_token' => $token]);
        if($accessToken !=  null){
                return $accessToken;
        }
        return null;

    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password_hash === $password;
    }
    public static function findByEmail($email)
    {
        return User::findOne(['email' => $email]);
    }
    public static function getYears() {
        $years = [];

        for ($i = 1900; $i <= 2018; $i++) {
            $years[] = $i;
        }

        return $years;
    }

    /**
     * @return string
     */
    public static function savePhoto() {
        $oldName = $_FILES['User']['name']['user_photo'];
        $newName = File::generateRandomString() . File::getExtension($oldName);
        $postImage = Yii::$app->params['processedImagesUrl'] . $newName;
        $imagePath = realpath(Yii::$app->params['processedImages']) . '/' . $newName;
        $imageFile =  file_get_contents($_FILES['User']['tmp_name']['user_photo']);
        file_put_contents($imagePath, $imageFile);

        return $postImage;
    }

    /**
     * @param $data
     * @return mixed|string
     * @throws \yii\base\Exception
     */
    public static function createUser($data)
    {
//        $user = new User();
//        User::userExist($data['user_email'],$data['new_password']);
//        $user->setScenario(User::SCENARIO_CREATE);
//
//        $password = (!empty($data['new_password_confirm']) && !empty($data['new_password']) && ($data['new_password_confirm'] == $data['new_password'])) ? $data['new_password'] : '12345';
//
//        $user->setAttributes([
//            'auth_key'              => Yii::$app->security->generateRandomString(),
//            'user_country'          => !empty($data['user_country']) ? $data['user_country'] : '',
//            'user_city'             => !empty($data['user_city']) ? $data['user_city'] : '',
//            'user_date_births'      => !empty($data['user_date_births']) ? $data['user_date_births'] : '',
//            'user_phone1'           => !empty($data['user_phone1']) ? $data['user_phone1'] : '',$data['user_phone1'],
//            'user_phone2'           => !empty($data['user_phone2']) ? $data['user_phone2'] : '',
//            'user_date_add'         => date("Y-m-d H:i:s", time()),
//            'user_date_last_login'  => date("Y-m-d H:i:s", time()),
//            'user_description'      => !empty($data['user_description']) ? $data['user_description'] : '',
//            'user_token'            => md5(Yii::$app->security->generateRandomString() . '_' . time()),
//            'user_permission'       => !empty($data['user_permission']) ? $data['user_permission'] : 2,
//            'user_status'           => !empty($data['user_status']) ? $data['user_status'] : 1,
//            'user_cv_url'           => !empty($data['user_cv_url']) ? $data['user_cv_url'] : '',
//            'user_photo'            => !empty($data['user_photo']) ? $data['user_photo'] : '',
//            'user_experience_years' => !empty($data['user_experience_years']) ? $data['user_experience_years'] : 0,
//        ]);

        $rbacuser = new \mdm\admin\models\User();
        $rbacuser->setPassword(Yii::$app->session->get('originalPwd'));
        $rbacuser->email = $data['user_email'];
        $rbacuser->auth_key = Yii::$app->security->generateRandomString();
        $rbacuser->username = $data['user_email'];
        $rbacuser->password_reset_token = $data['new_password'] ? $data['new_password'] : 0;
        $rbacuser->user_country = !empty($data['user_country']) ? $data['user_country'] : '';
        $rbacuser->user_city = !empty($data['user_city']) ? $data['user_city'] : '';
        $rbacuser->user_date_births = !empty($data['user_date_births']) ? $data['user_date_births'] : '';
        $rbacuser->user_phone1 = !empty($data['user_phone1']) ? $data['user_phone1'] : '';
        $rbacuser->user_phone2 = !empty($data['user_phone2']) ? $data['user_phone2'] : '';
        $rbacuser->user_date_add = date("Y-m-d H:i:s", time());
        $rbacuser->user_date_last_login = date("Y-m-d H:i:s", time());
        $rbacuser->user_description = !empty($data['user_description']) ? $data['user_description'] : '';
        $rbacuser->user_status = !empty($data['user_permission']) ? $data['user_permission'] : 2;
        $rbacuser->user_cv_url = !empty($data['user_status']) ? $data['user_status'] : 1;
        $rbacuser->user_photo = !empty($data['user_cv_url']) ? $data['user_cv_url'] : '';
        $rbacuser->user_experience_years = !empty($data['user_photo']) ? $data['user_photo'] : '';
        $rbacuser->save();

        $authAssignment = new AuthAssignment();
        $authAssignment->setAttribute('user_id',$rbacuser->id);
        $authAssignment->setAttribute('item_name','User');
        $authAssignment->save();
//        return ($user->save(false)) ? $user->id : '';
    }
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    public static function userExist($userEmail,$password)
    {
        if(!empty($userEmail) && !empty($password)){
            $passwordHash = md5(sha1($password).$userEmail);
            $existUser = User::findOne(['email' => $userEmail,'password_hash' => $passwordHash]);
            if($existUser != null){
                return true;
            }

        }
        return false;


    }

}
