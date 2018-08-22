<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    $this->registerCssFile('/templates/A1/css/style.css');
    $this->registerCssFile('/templates/A1/css/responsive.css');
?>
</head>
<body>
<header class="header">
    <?php
        $this->title ='Login';
        $this->params['breadcrumbs'][] = $this->title;
    ?>
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
            <?php $form = ActiveForm::begin(['class' => 'signin', 'enableClientValidation' => true,'options' =>
                ['class' => 'signin','action'=>['/account/login']]]); ?>
            <span class="wrap wrap-email">
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ]) ?>
                <p class="wrong-text">Error Message goes here, Regular 11</p>
             </span>
        <span class="wrap-btn">
                   <?= \yii\helpers\Html::submitButton('Отправить', ['class' => 'button-orange login']) ?>
            </span>

            <?php ActiveForm::end(); ?>


        <div class="register">
            <a class="link-blue" href="">Forgot Password</a>
            <p class="no_account">Don't have an account yet?</p>
            <a class="link-blue" href="">Register</a>
        </div>

</main>

</body>
</html>


<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">

    </div>
</div>

<?php $this->registerJsFile('/js/A1/app.js'); ?>


