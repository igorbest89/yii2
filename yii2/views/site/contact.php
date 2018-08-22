<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/templates/A2/css/style.css">
    <link rel="stylesheet" href="/templates/A2/css/responsive.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,900" rel="stylesheet">
    <script src = "https://www.google.com/recaptcha/api.js" async defer ></script>
    <title>Document</title>
</head>
<body>
<header class="header">

</header>

<main class="contact-us">
    <div class="contact-container">
        <section class="title">
            <h1 class="title__item">Contact us</h1>
            <p class="title__descr">Please, FILL IN THE FIELDS BELOW, IF YOU HAVE ANY QUESTIONS OR WANT TO GET IN TOUCH WITH US</p>
        </section>
        <form class="form-contact"  method="POST">
            <div class="contact-inputs">
                <input type="text" name="userName" class="contact-inputs__name input-base" placeholder="Name">
                <input type="text" name="userEmail" class="contact-inputs__email input-base" placeholder="Email">
            </div>
            <textarea placeholder="Your message" name="textBody" class="contact-textarea base-textarea"></textarea>
            <div class = "g-recaptcha" data-sitekey="6LdLq2QUAAAAABldXROCWgaOX5HXeusTEdtK29Gp" ></div>

        </form>
        <button type="submit" class="button-orange contact-btn" id="cantact-btn-submit-form">send message</button>
        <section class="title contact-title" id="popup-after-success-send-email" style="display: none">
            <h1 class="title__item">YOUR MESSAGE WAS SENT</h1>
            <p class="title__descr">THANK YOU FOR CONTACTING US. Your message will be processed asap</p>
        </section>
    </div>
</main>
<?php $this->registerJsFile('/templates/A2/js/app.js'); ?>
</body>
</html>