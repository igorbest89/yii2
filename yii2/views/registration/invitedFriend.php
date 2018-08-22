<?php /**
 * @var $user \app\models\UserProfile;
 */
$this->registerCssFile('/templates/A12/css/style.css');
$this->registerCssFile('/templates/A12/css/responsive.css'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,900" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<header class="header">

</header>
<main class="main invite-friends-landing">
    <div class="welcome-background">
        <section class="invite-friends">
            <h1 class="invite-friends__title">WELCOME TO DROPCV.IO</h1>
            <h4 class="invite-friends__descr">YOU WERE INVITED BY</h4>
            <img src="img/profile.png" alt="profile" class="invite-friends__img">
            <h2 class="invite-friends__name">Melinda Johnes</h2>
            <p class="invite-friends__accellerate">Accellerate your career:</p>
            <a href="/registration" class="button-orange">create cv for free</a>
        </section>
    </div>
    <section class="invite-bonus">
        <h4 class="invite-bonus__register">YOUR special BONUS WHEN YOU REGISTER NOW:</h4>
        <a href="" class="invite-bonus__link link-blue">OUR SUPER COOL FREE+ CV TEMPLATE FOR YOU!!!</a>
        <img src="img/CVPremium.png" alt="premium CV" class="invite-bonus__img">
        <img src="img/icons/quote.svg" alt="quote" class="invite-bonus__quote">
        <h2 class="invite-bonus__developed">We have developed Dropcv to offer you a unique and simple way to create, send and share your CV with employers.</h2>
        <p class="invite-bonus__co-founder">- Caleb, CO-Founder DropCV -</p>
    </section>
</main>
<script src="js/app.js"></script>
</body>
</html>
<?php $this->registerJsFile('/templates/A12/js/app.js'); ?>
