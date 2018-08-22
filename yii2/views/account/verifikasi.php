<?php
$this->pageTitle=Yii::app()->name . ' - Change Password';
$this->breadcrumbs=array(
    'Change Password',
);
?>
<h2>Hi! <?php echo $model->nama_asli;?> :v</h2>
<div class="form">
    <h2>Change Password</h2>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'Ganti-form',
    )); ?>

    <div class="row">
        New Password : <input name="Ganti[password]" id="ContactForm_email" type="password">
        <input name="Ganti[tokenhid]" id="ContactForm_email" type="hidden" value="<?php echo $model->token?>">
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <?
    $this->registerCssFile('/templates/A1/css/style.css');
    $this->registerCssFile('/templates/A1/css/responsive.css');
    ?>
</head>
<body>
<header class="header">

</header>
<main class="main">
    <div class="container">
        <section class="title">
            <h1 class="title__item">Sign in to your account</h1>
        </section>
        <div class="buttons">
            <button class="buttons__facebook"><img src="img/icons/facebook.svg" alt="facebook"><span class="buttons__text">sign in with facebook</span></button>
            <button class="buttons__google"><img src="img/icons/google+.svg" alt="google+"><span class="buttons__text">sign in with google+</span></button>
        </div>
        <section class="another">
            <h3 class="another__or">or</h3>
        </section>
        <?php
        $form = \yii\widgets\ActiveForm::begin(['class' => 'signin', 'enableClientValidation' => true,'options' =>
            ['class' => 'signin','action'=>['/account/login']]]); ?>
        <span class="wrap wrap-email">
                      <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ]) ?>

                </span>
        <span class="wrap-btn">
                   <?= \yii\helpers\Html::submitButton('Отправить', ['class' => 'button-orange login']) ?>
            </span>
        <?php \yii\widgets\ActiveForm::end();?>

        <div class="register">
            <a class="link-blue" href="">Forgot Password</a>
            <p class="no_account">Don't have an account yet?</p>
            <a class="link-blue" href="">Register</a>
        </div>
    </div>
</main>
<?php $this->registerJsFile('/js/A1/app.js'); ?>
</body>
</html>