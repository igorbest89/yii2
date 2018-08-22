<?php

namespace app\controllers;

use app\core\controllers\CoreController;
use app\models\AuthAssignment;
use app\models\Cities;
use app\models\Countries;
use app\models\Invitation;
use app\models\Mail;
use app\models\Signup;
use app\models\States;
use app\models\TempPassword;
use app\models\User;
use app\models\UserCertificate;
use app\models\UserDocument;
use app\models\UserEducation;
use app\models\UserExperience;
use app\models\UserProfile;
use app\models\UserReference;
use Yii;
use yii\web\Response;


class RegistrationController extends CoreController
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $session = Yii::$app->session;
        $user = new User();
        $profile = new UserProfile();
        $education = new UserEducation();
        $experience = new UserExperience();
        $certificate = new UserCertificate();
        $document = new UserDocument();
        $reference = new UserReference();
        $months = User::$months;
        $years = User::getYears();
        $email = $session->get('email');
        $password = $session->get('password', '');
        $marital = User::$marital;
        $countries = Countries::find()->orderBy('en')->asArray()->all();
        $courses = ['Courses 1', 'Courses 2', 'Courses 3'];
        $post = Yii::$app->request->post();

        if (empty($email) || $session->get('usedEmail')) {
            $this->redirect('/');
        }
        if (!empty(Yii::$app->request->get()['tmpPwd'])) {
            $tmpPwd = Yii::$app->request->get()['tmpPwd'];
            $tempPassword = TempPassword::findByTempPassword($tmpPwd);
            if (!empty($tempPassword)) {
                $session->set('password', $tempPassword->password);
                $session->set('email', $tempPassword->email);
                return $this->render('email');
            }
        }
        if (!empty($post)) {
            //User
            $userData = [
                'new_password_confirm'  => $password,
                'new_password'          => $password,
                'user_email'            => $email,
                'user_name'             => $post['firstname'] . $post['lastname'],
                'user_country'          => Countries::findOne(['code' => $post['birth-place']])->country_id,
                'user_city'             => Cities::getCityId($post['birth-place'], $post['city']),
                'user_phone1'           => $post['phone']
            ];

            if (!empty($_FILES['User']['name']['user_photo'])){
                $userData['user_photo'] = User::savePhoto();
            }


            $userId = User::findByEmail($email);
            if(!$userId){
                 User::createUser($userData);
                 $userId = User::findByEmail($email);
            }

            //Profile
            $profileData = [
                'email'            => $email,
                'user_id'          => $userId,
                'first_name'       => $post['firstname'],
                'last_name'        => $post['lastname'],
                'middle_name'      => $post['middlename'],
                'gender'           => $post['gender'],
                'country'          => $post['country'],
                'country_of_birth' => $post['birth-place'],
                'phone'            => $post['phone'],
                'address'          => $post['address'],
                'zip'              => $post['zip'],
                'overview'         => $post['overview'],
                'skills'           => $post['skills'],
                'strengths'        => $post['strengths'],
                'marital_status'   => $post['marital'],
                'interests'        => $post['interests'],
                'date_of_birth'    => strtotime($post['date-of-birth']),
                'state'            => $post['state'],
                'city'             => $post['city'],
            ];

            UserProfile::createProfile($profileData);

            //Experience
            $experiences = $post['experience'];

            foreach ($experiences as $exp) {
                $experienceData = [
                    'user_id'        => $userId,
                    'job_title'      => $exp['job'],
                    'employer'       => $exp['employer'],
                    'country'        => $exp['country'],
                    'location'       => $exp['location'],
                    'from_month'     => $exp['from-month'],
                    'from_year'      => $exp['from-year'],
                    'to_month'       => $exp['to-month'],
                    'to_year'        => $exp['to-year'],
                    'achievements'   => $exp['achievements']
                ];

                if (empty($exp['to-month']) || empty($exp['to-year'])) {
                    $experienceData['current_place'] = 1;
                }

                UserExperience::createExperience($experienceData);
            }

            //Education
            $educations = $post['education'];

            foreach ($educations as $edu) {
                $educationData = [
                    'user_id'        => $userId,
                    'name'           => $edu['courses'],
                    'school_name'    => $edu['school'],
                    'country'        => $edu['country'],
                    'location'       => $edu['location'],
                    'from_month'     => $edu['from-month'],
                    'from_year'      => $edu['from-year'],
                    'to_month'       => $edu['to-month'],
                    'to_year'        => $edu['to-year'],
                    'specialization' => $edu['specialization'],
                    'description'    => $edu['description'],
                    'document_type'  => 0,
                    'license_number' => 0
                ];

                if (empty($edu['to-month']) || empty($edu['to-year'])) {
                    $educationData['current_place'] = 1;
                }

                UserEducation::createEducation($educationData);
            }

            //References
            $references = $post['references'];

            foreach ($references as $ref) {
                $referenceData = [
                    'user_id'      => $userId,
                    'name'         => $ref['name'],
                    'company_name' => $ref['company'],
                    'surname'      => $ref['surname'],
                    'job_title'    => $ref['job'],
                    'phone'        => $ref['phone'],
                    'email'        => $ref['email']
                ];

                UserReference::createReference($referenceData);
            }

            if (!empty($_FILES['UserCertificate']['name']['path'])){
                UserCertificate::saveCertificate($userId);
            }

            if (!empty($_FILES['UserDocument']['name']['path'])){
                UserDocument::saveDocument($userId);
            }

            return $this->redirect('/account/login');
        }
        return $this->render('index', [
            'user'        => $user,
            'certificate' => $certificate,
            'document'    => $document,
            'months'      => $months,
            'years'       => $years,
            'email'       => $email,
            'marital'     => $marital,
            'countries'   => $countries,
            'courses'     => $courses
        ]);
    }

    public function actionAppendReference($id)
    {
        $data = [ 'id' => $id];

        return $this->renderPartial('reference', $data);
    }

    public function actionAppendEducation($id)
    {
        $countries = Countries::find()->orderBy('en')->asArray()->all();
        $courses = ['Courses 1', 'Courses 2', 'Courses 3'];
        $months = User::$months;
        $years = User::getYears();
        $data = [
            'id'        => $id,
            'years'     => $years,
            'months'    => $months,
            'courses'   => $courses,
            'countries' => $countries
            ];

        return $this->renderPartial('education', $data);
    }

    public function actionAppendExperience($id)
    {
        $countries = Countries::find()->orderBy('en')->asArray()->all();
        $months = User::$months;
        $years = User::getYears();
        $data = [
            'id'        => $id,
            'years'     => $years,
            'months'    => $months,
            'countries' => $countries
        ];

        return $this->renderPartial('experience', $data);
    }

    public function actionSetRegistrationEmail()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        $session = Yii::$app->session;
        $json =[];
        $password = Yii::$app->request->post()['password'];
        $email = Yii::$app->request->post()['email'];
        if (!empty($password) && !empty($email)) {

            $session->set('password', $password);
            $session->set('email', $email);

            Mail::mailConfirmNewEmailSent($email, $password);

            return $json  = ['status' => 'success'];

        } else {

            $session->set('password', '');
            $session->set('email', '');

            $json =[
                'status' => 'fail'
            ];
        }

        return $json;
    }

    public function actionChangeCountry($code)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $country = Countries::findOne(['code' => $code]);

        if (!empty($country)) {
            $json = [
                'status'           => 'success',
                'message'          => 'Country found!',
                'countryStates'    => States::getCountryStates($code)
            ];
        } else {
            $json = [
                'status'  => 'fail',
                'message' => 'Country not found!'
            ];
        }

        return $json;
    }

    public function actionChangeCity($code)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $country = Countries::findOne(['code' => $code]);
        $symbols = Yii::$app->request->post()['symbols'];
        $region = (!empty(Yii::$app->request->post()['region'])) ? Yii::$app->request->post()['region'] : null;

        if (!empty($country)) {
            $json = [
                'status'        => 'success',
                'message'       => 'Country found!',
                'countryCities' => Cities::getCountryCities($code, $symbols, $region)
            ];
        } else {
            $json = [
                'status'  => 'fail',
                'message' => 'Country not found!'
            ];
        }

        return $json;
    }

    public static function findByEmail($email)
    {
        return User::findOne(['email' => $email]);
    }

    public function actionCheckUsedEmail()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!empty(Yii::$app->request->post()['email'])) {

            $user = User::findByEmail(Yii::$app->request->post()['email']);

            if(!empty($user)) {
                Yii::$app->session->set('usedEmail', true);

                $json = false;

            } else {
                Yii::$app->session->set('originalPwd', Yii::$app->request->post()['password']);
                Yii::$app->session->set('usedEmail', false);
                $this->actionSetRegistrationEmail();
                $json = true;

            }
        }else{
            $json = false;
        }

        return $json;
    }

    public function actionCheckExistingCity() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $country = Yii::$app->request->post()['country'];
        $city = Yii::$app->request->post()['city'];

        $cityId = Cities::getCityId($country, $city);

        if (!empty($cityId)) {
            $json = [
                'status'  => 'success',
                'message' => 'City is exist!'
            ];
        } else {
            $json = [
                'status'  => 'fail',
                'message' => 'City is not exist!'
            ];
        }

        return $json;
    }

    public function actionEmail()
    {
        return $this->render('email');
    }

    public function actionInvitationConfirm()
    {
        $refEmail = Yii::$app->request->get('refEmail');
        $tmpInvitation = Yii::$app->request->get('tmpInvitation');
        $refId = Yii::$app->request->get('refId');
        if( isset($refEmail) && isset($tmpInvitation) && isset($refId)  ){
             $invitation = Invitation::findOne(['email' => $refEmail, 'referer_id' => $refId]);
             $invitation->active_status = 1;
             $invitation->save();
            return $this->render('invite-friend');
        }
        return false;
    }

    public function actionRestore()
    {
        return $this->render('restore');
    }

    public function actionInviteFriend()
    {
        return $this->render('invitedFriend');

    }


}
