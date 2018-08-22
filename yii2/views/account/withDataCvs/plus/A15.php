<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,900" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Document</title>
</head>
<body>
    <div class="popup-send popup-premium">
        <div class="popup-premium-container">
            <button class="popup-premium-close"><img src="img/icons/close.svg" alt="close"></button>
            <section class="title">
                <h1 class="title__item">Send your CV to company</h1>
                <p class="title__descr">Use our secure messaging function to email your CV as application to any company. Our email delivery service gives you a high chance, the receiver will get your CV. Also the receiver will get your email in a beautiful email template</p>
            </section>
            <form action="?" class="popup-form">
                <input type="text" class="send-input input-base" placeholder="Company Name">
                <input type="email" class="send-input input-base" placeholder="Email Address">
                <input type="text" class="send-input input-base" placeholder="Subject">
                <textarea class="base-textarea" placeholder="Cover Message"></textarea>
                <span class="preview-email">
                    <p>Send copy to of email to my inbox</p>
                    <a href="" class="link-blue">Preview Email</a>
                </span>
                <div class="g-recaptcha" data-sitekey="your_site_key"></div>
                <button class="button-orange">send</button>
            </form>
        </div>  
    </div>
    <script src="js/app.js"></script>
</body>
</html>