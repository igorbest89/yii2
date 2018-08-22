<?php
//use yii\helpers\Html;
//use yii\bootstrap\ActiveForm;
//
///* @var $this yii\web\View */
///* @var $form yii\bootstrap\ActiveForm */
///* @var $model \common\models\LoginForm */
//
//$this->title = 'Sign In';
//
//$fieldOptions1 = [
//    'options' => ['class' => 'form-group has-feedback'],
//    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
//];
//
//$fieldOptions2 = [
//    'options' => ['class' => 'form-group has-feedback'],
//    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
//];
//?>
<!---->
<!--<div class="login-box">-->
<!--    <div class="login-logo">-->
<!--        <a href="#"><b>Admin</b>LTE</a>-->
<!--    </div>-->
<!--    <!-- /.login-logo -->-->
<!--    <div class="login-box-body">-->
<!--        <p class="login-box-msg">Sign in to start your session</p>-->
<!---->
<!--        --><?php //$form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
<!---->
<!--        --><?//= $form
//            ->field($model, 'user_name', $fieldOptions1)
//            ->label(false)
//            ->textInput(['placeholder' => $model->getAttributeLabel('user_name')]) ?>
<!---->
<!--        --><?//= $form
//            ->field($model, 'password', $fieldOptions2)
//            ->label(false)
//            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
<!---->
<!--        <div class="row">-->
<!--            <div class="col-xs-8">-->
<!--                --><?//= $form->field($model, 'rememberMe')->checkbox() ?>
<!--            </div>-->
<!--            <!-- /.col -->-->
<!--            <div class="col-xs-4">-->
<!--                --><?//= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
<!--            </div>-->
<!--            <!-- /.col -->-->
<!--        </div>-->
<!---->
<!---->
<!--        --><?php //ActiveForm::end(); ?>
<!---->
<!--        <div class="social-auth-links text-center">-->
<!--            <p>- OR -</p>-->
<!--            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in-->
<!--                using Facebook</a>-->
<!--            <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign-->
<!--                in using Google+</a>-->
<!--        </div>-->
<!--        <!-- /.social-auth-links -->-->
<!---->
<!--        <a href="#">I forgot my password</a><br>-->
<!--        <a href="register.html" class="text-center">Register a new membership</a>-->
<!---->
<!--    </div>-->
<!--    <!-- /.login-box-body -->-->
<!--</div><!-- /.login-box -->-->
<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\form\Login */

$this->title = Yii::t('rbac-admin', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
            <div style="color:#999;margin:1em 0">
                If you forgot your password you can <?= Html::a('reset it', ['user/request-password-reset']) ?>.
                For new user you can <?= Html::a('signup', ['user/signup']) ?>.
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('rbac-admin', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
