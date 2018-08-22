<?php

namespace app\controllers;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use app\core\controllers\CoreController;
use app\models\Account;
use app\models\AccountTemplate;
use app\models\AccountToTemplate;
use app\models\Invitation;
use app\models\LoginForm;
use app\models\Mail;
use app\models\SubscribeUser;
use app\models\TempPassword;
use app\models\User;
use app\models\UserProfile;
use app\models\UserReference;
use app\models\UserToAccount;
use app\models\UserToAccountTemplate;
use services\httpclient\Exception;
use Yii;
use yii\web\ForbiddenHttpException;
use PayPal\Api\CreditCard;
use PayPal\Exception\PaypalConnectionException;
class AccountController extends CoreController
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $templateTypeSession = Yii::$app->session['templateType'];
        $templateNameSession = Yii::$app->session['templateName'];
        if(!empty($templateTypeSession) && !empty($templateNameSession)){
            $templateType = $templateTypeSession;
        }else{
            $templateType = 'free';
        }
        $account = new Account();

        $res = $account->getConstants();
        $only_Accounts = [];
        foreach ($res as $key => $value) {
            if (strpos($key, 'ACCOUNT_') === 0){
                $only_Accounts[$key] = $value;
            }
        }
        $session = Yii::$app->session;
        $email = $session->get('email');
        $user = User::findOne(['email' => $email]);
        $templates = Account::find()->where(['name' => $templateType])->with('relationship')->asArray()->all();
        $session->set('invitation',false);
        $invitation = Invitation::findOne(['referer_id' => $user->id]);
        if(is_null($invitation)){
            $session->set('unlock_premium',false);
        }else{
            $session->set('unlock_premium',true);
        }
        return $this->render('index', [
            'onlyAccounts'        => $only_Accounts,
            'templateNameSession' => $templateNameSession,
            'templateTypeSession' => $templateTypeSession,
            'user'                => $user,
            'templates'           => $templates[0]
        ]);
    }


    /**
     * @param $userId
     * @param $accountName
     * @return array
     */
    public static function actionSetUserAccount($userId, $accountName)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $templateName = Yii::$app->request->get('templateName');
        $account = Account::findOne(['name' => $accountName]);
        $accountIsExist = UserToAccount::findOne(['user_id' => $userId, 'account_id' => $account->id]);
        $tmplName = AccountTemplate::findOne(['name' =>  $templateName]);
        $accToTmpl = UserToAccountTemplate::findOne(['user_id'=> $userId,'template_id'=> $tmplName->id]);
        $userReference = UserReference::findOne(['user_id' => $userId]);
        $invitation = Invitation::findOne(['referer_id' => $userId]);
        if($accountName == Account::ACCOUNT_PREMIUM && !is_null($userReference) || $accountName == Account::ACCOUNT_FREE_PLUS && !is_null($userReference)) {
            self::existingInsertTemplateToUser($userId,$accountIsExist,$account,$accToTmpl,$tmplName);
        }elseif ($accountName == Account::ACCOUNT_PROFESSIONAL && !is_null($userReference) ){
            self::existingInsertTemplateToUser($userId,$accountIsExist,$account,$accToTmpl,$tmplName);
            return ['statusProfessional' => true];
        }elseif ($accountName== Account::ACCOUNT_FREE) {
            self::existingInsertTemplateToUser($userId,$accountIsExist,$account,$accToTmpl,$tmplName);
            return ['free' => true];
        }else{
            self::existingInsertTemplateToUser($userId,$accountIsExist,$account,$accToTmpl,$tmplName);
                return [
                    'statusPremium' => 'error',
                    'session' => Yii::$app->session,
                    'invitation' => $invitation
                ];
        }


        return [
            'session' => Yii::$app->session,
            'statusPremium' => 'ok',
            'invitation' => $invitation
        ];
    }

    public static function existingInsertTemplateToUser($userId,$accountIsExist,$account,$accToTmpl,$tmplName)
    {
        if (empty($accountIsExist)) {
            $userToAccount = new UserToAccount();
            $userToAccount->user_id = $userId;
            $userToAccount->account_id = $account->id;

            $userToAccount->save(false) ? true : false;
        }
        if (is_null($accToTmpl)) {

            $userToAccountTemplate = new UserToAccountTemplate();
            $userToAccountTemplate->user_id = $userId;
            $userToAccountTemplate->template_id = $tmplName->id;
            $userToAccountTemplate->save();

        }

}
    /**
     * @param $userId
     * @param $templateId
     *
     * @return boolean
     */
    public static function actionSetUserTemplate($userId, $templateId)
    {
        $userToTemplate = new UserToAccountTemplate();
        $userToTemplate->user_id = $userId;
        $userToTemplate->template_id = $templateId;

        return ($userToTemplate->save(false)) ? true : false;
    }

    public function actionInvitation()
    {
        $data = array(
            'secret' => '6LdLq2QUAAAAAGbYphk9vd1Lirl9WuA4KB4VoLCG',
            'response' => $_POST["request"],
            'remoteip' => $_SERVER['REMOTE_ADDR']
        );
        $ch = curl_init("https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $captcha_success = json_decode($server_output);
        curl_close($ch);

        if ($captcha_success->success == false) {

        } else if ($captcha_success->success==true) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $userId = Yii::$app->request->post('userId');
            $accountName = Yii::$app->request->post('accountName');
            $session = Yii::$app->session;
            $email = $session->get('email');
            $user = User::findOne(['email' => $email]);
            $invitations = Yii::$app->request->post()['invitations'];
            $session->set('invitation',false);

            $refId = $user->user_id;

            foreach ($invitations as $invitation) {
                $refInvitation = new Invitation();
                $tmpInvitation = sha1('confirm_invitation'.$invitation['email'].time());
                $refInvitation->email = $invitation['email'];
                $refInvitation->referer_id = $refId;
                $refInvitation->active_status = 0;
                $refInvitation->tmpInvitation = $tmpInvitation;
                $refInvitation->save();

                Mail::mailInvitationSent($invitation['email'], $invitation['name'],$tmpInvitation,$refId);
            }
            $session->set('invitation',false);


            if(self::actionSetUserAccount($userId,$accountName)){
                return [
                    'statusCode' => Yii::$app->response->statusCode,
                    'session' => $session
                ];
            }


        }
        return [
            'statusCode' => 500,
        ];
    }

    public function actionUserAccounts()
    {
        $session = Yii::$app->session;
        $email = $session->get('email');
        $user = User::findOne(['email' => $email]);
        Yii::$app->session->set('accounts', Account::getNewUserAccounts($user->user_id));
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'session' => Yii::$app->session
        ];
    }

    public function actionChooseTemplate()
    {
        $userId = Yii::$app->request->post()['userId'];
        $templateId = Yii::$app->request->post()['templateId'];

        if(intval($userId) && intval($templateId) && Yii::$app->request->isAjax){
            $userToAccountTemplate =  new UserToAccountTemplate();
            $userToAccountTemplate->user_id = $userId;
            $userToAccountTemplate->template_id = $templateId;
            $userToAccountTemplate->save();
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'statusCode' => Yii::$app->response->statusCode
            ];
        }else{
            http_response_code(400);
            exit;
        }
     }

    /**
     * @return string|\yii\web\Response
     */
    public function actionPreviewPage()
    {
        $templateType = Yii::$app->request->get('templateType');
        $templateName = Yii::$app->request->get('templateName');
            if(strlen($templateName) >1 && strlen($templateType)>2) {
                Yii::$app->session['templateType'] = $templateType;
                Yii::$app->session['templateName'] = $templateName;

                $user_email = Yii::$app->session['email'];

//            $templateRelation = Account::find()->where(['name'=> $templateName])->with('template')->all();

                $user = UserProfile::find()->where(['email' => $user_email])->with(['exp', 'education', 'document', 'certificate'])->all();
                    return $this->render("$templateType/$templateName", [
                    'user' => $user[0],
                ]);
            }else{
                return $this->redirect('index',302);
            }
    }


    public function actionSelectAllCvsByType()
    {
        $templateName = Yii::$app->request->post('templateName');
        if (Yii::$app->request->isAjax && strlen($templateName) > 0) {
            $account = Account::find()->where(['name' => $templateName])->with('relationship')->asArray()->all();
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'account' => $account,
            ];
        }
        return false;
    }

    public function actionPaypal()
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS',     // ClientID
                'EGnHDxD_qRPdaLdZz8iCr8N7_MzF-YHPTkjs6NKYQvQSBngp4PTTVWkPZRbL'      // ClientSecret
            )
        );
// 3. Lets try to create a Payment
// https://developer.paypal.com/docs/api/payments/#payment_create
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');
        $amount = new \PayPal\Api\Amount();
        $amount->setTotal('1.00');
        $amount->setCurrency('USD');
        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);
        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl("https://dropcv/cvs/success")
            ->setCancelUrl("https://dropcv/cvs/cancel");
        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);
// 4. Make a Create Call and print the values
        try {
            $payment->create($apiContext);
           $this->redirect($payment->getApprovalLink(),302);
        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // This will print the detailed information on the exception.
            //REALLY HELPFUL FOR DEBUGGING
            echo $ex->getData();
        }
        $user = UserProfile::find()->where(['email' => Yii::$app->session->get('email')])->with(['exp', 'education', 'document', 'certificate','countryData'])->one();
        $period = Yii::$app->request->post('period');


//        findOne(['user_id' => $user->user_id]);
        if(Yii::$app->request->isAjax && $period){

            $subscribeUssr = new SubscribeUser();
            $subscribeUssr->user_id = $user->user_id;
            $subscribeUssr->country_id = $user->countryData->country_id;
            $subscribeUssr->is_active_subscribe = 1;
            $subscribeUssr->save();



            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'status' => 'success',
            ];
        }


        return $this->render('paypal');

    }

    public function actionUrl()
    {

        $acountToTemplate = AccountToTemplate::findOne(['url' => $_SERVER['REQUEST_URI']]);

        $user_email = Yii::$app->session['email'];
        $user = UserProfile::find()->where(['email' => $user_email])->with(['exp', 'education', 'document', 'certificate'])->one();

//        return  $this->render('free/test.php');
        return $this->render('/account/'.$acountToTemplate->path_to_markup,
                    [
                        'user' => $user
                    ]);

    }
    public function actionQwe(){

        try{
            echo 'qwe';
        }catch (Exception $e){
            var_dump($e);
        }

    }

    /**
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
    */
    public function actionLogin()
    {
        if (!Yii::$app->getUser()->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            Yii::$app->session->set('email',Yii::$app->request->post()['LoginForm']['username']);
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }

//        if (!Yii::$app->getUser()->isGuest) {
//            return $this->goHome();
//        }
//
//        $model = new LoginForm();
//        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
//            return $this->goBack();
//        } else {
//            return $this->render('login', [
//                'model' => $model,
//            ]);
//        }

//        $email = Yii::$app->request->post('LoginForm')['email'];
//        $password = Yii::$app->request->post('LoginForm')['password'];
//        TempPassword::findByTempPassword(sha1($password));
//        if(!empty($email) && !empty($password)) {
//            if (Yii::$app->request->post() && User::userExist($email, $password)) {
//                Yii::$app->session->set('user',User::userExist($email, $password));
////                    return $this->goHome();
//                $user = User::findByEmail($email);
//                Yii::$app->user->login($user);
//                $duration = 30 * 24 * 3600;
//                Yii::$app->user->login($user, $duration);
//                return $this->redirect('index',302);
//            }
//        }
//        $model = new User();
//        $modelLogin = new \app\models\LoginForm();
//        return $this->render('login', [
//            'model' => $modelLogin,
//            'modelLogin' => $modelLogin,
//        ]);
    }


    /**
     * @return string|\yii\web\Response
     * @throws \Throwable Yii::$app->security->generateRandomString()
     * @throws \yii\base\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionResetPassword()
    {
        $password = Yii::$app->request->post('User')['password'];
        $passwordRepeat = Yii::$app->request->post('User')['passwordRepeat'];
        $token = Yii::$app->session->get('token');
        if(strlen($token)>10) {
            $user = User::findOne(['user_token' => $token]);
            $model = new User();
            if ($password == $passwordRepeat && $user != null) {
                $user->user_password = $passwordHash = md5(sha1($password) . $user->user_email);;
                $user->user_token = md5(Yii::$app->security->generateRandomString() . '_' . time());
                $user->update();
                return $this->redirect('/account', 302);
            }
        }
        return $this->render('forgot',[
            'model' => $model,
            'acceptResetPassword' => false
        ]);

    }


    public function actionForgot()
    {
        $getEmail = Yii::$app->request->post('User')['email'];
        $token = Yii::$app->request->get('userToken');
        if(is_string($getEmail) && !empty($getEmail)) {
            $getModel = User::findOne(['email' => $getEmail]);
            if (!empty($getEmail) && $getModel != null) {
                if ($getModel->validate()) {
                    Mail::mailResetPasswordSent($getModel->user_email, $getModel->user_token);
                }
            }

            $user = User::findOne(['user_token' => $token]);
            $model = new User();
            if (!empty($token) && strlen($token) >= 20) {
                if ($user->user_token == $token) {
                    Yii::$app->session['token'] = $token;
                    return $this->render('forgot', [
                        'model' => $model,
                        'acceptResetPassword' => true,
                    ]);
                }
            }
        }
        $model = new User();
        return $this->render('forgot', [
            'model' => $model,
            'acceptResetPassword' => false
        ]);
    }

    /**
     * @return bool|string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionProfileSettings(){
        if(!empty(Yii::$app->request->post('userData'))){
            $userData = Yii::$app->request->post('userData');
            $userEmail = Yii::$app->session->get('email');
            $user = \mdm\admin\models\User::findOne(['username' => $userEmail]);
            $user->username = $userData['username'];
            $user->last_name = $userData['last_name'];
            $user->gender = $userData['gender'];
            $user->user_date_births = $userData['bday'];
            if($userData['password'] == $userData['confirm_password'] && !empty($userData['confirm_password']) && !empty($userData['password'] )){
                $user->password_hash = Yii::$app->security->generatePasswordHash($userData['password']);
            }else{
                return false;
            }
            $user->save(false);
        }
        $userEmail = Yii::$app->session->get('email');
        if(!empty($userEmail)){
            $user = User::findByEmail($userEmail);
            return $this->render('profileSettings',['user' => $user]);
        }
    }

    /**
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteProfile()
    {
        $userEmail = Yii::$app->session->get('email');
        if(!empty($userEmail)){
            $user = User::findOne(['email' => $userEmail]);
            $user->user_status =0;
            $user->update();
            unset(Yii::$app->session['email']);
            return $this->goHome();
        }
    }

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUnsubscribe(){

        $userEmail = Yii::$app->session->get('email');
        if(!empty($userEmail)){
            $user = UserProfile::findByEmail($userEmail);
            $updateSubscribe = SubscribeUser::findOne(['user_id' => $user->user_id]);
            $updateSubscribe->is_active_subscribe = 0;
            $updateSubscribe->save(false);
        }


    }

    public function actionSuccess()
    {
        $userEmail = Yii::$app->session->get('email');
        if(!empty($userEmail)){

            $user = UserProfile::find()->where(['email' => $userEmail])->with(['exp', 'education', 'document', 'certificate'])->all();
            $updateSubscribe = new SubscribeUser;
            $updateSubscribe->user_id = $user->user_id;
            $updateSubscribe->is_active_subscribe = 0;
            $updateSubscribe->country_id = 0;
            $updateSubscribe->save();
        }

    }

    public function actionCancel()
    {
        var_dump('cancel');

        die;
    }

}
