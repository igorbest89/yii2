<?php
/**
 * Created by PhpStorm.
 * User: intetn2
 * Date: 17.07.2018
 * Time: 16:41
 */
$this->registerCssFile('/templates/A11/css/style.css');
$this->registerCssFile('/templates/A11/css/responsive.css');
?>

<body>
<main class="restore-pass">
    <div class="container">
        <section class="title">
            <h1 class="title__item">password restore</h1>
        </section>
        <form class="restore-form-email signin">
                <span class="wrap wrap-email">
                    <input class="input-with-icon wrap__email" type="email" placeholder="E-Mail">
                    <p class="wrong-text">Error Message goes here, Regular 11</p>
                </span>
            <span class="continue-wrap wrap-btn">
                    <button class="button-orange login">continue</button>
                </span>
        </form>
        <section class="check-email title">
            <h1 class="check-email__title title__item">password restore</h1>
            <p class="check-email__text">Please, check your email for further instructions</p>
        </section>
        <form class="restore-form-password signin">
            <h1 class="title__item">password restore</h1>
            <div class="registration-password">
                    <span class="wrap wrap-pass">
                        <input class="input-with-icon set-password" type="password" placeholder="Set new password">
                        <p class="wrong-text">Error Message goes here, Regular 11</p>
                    </span>
                <span class="wrap wrap-pass">
                        <input class="input-with-icon confirm-password" type="password" placeholder="Confirm new password">
                        <p class="wrong-text">Error Message goes here, Regular 11</p>
                    </span>
            </div>
            <span class="continue-wrap wrap-btn">
                    <button class="button-orange login">continue</button>
                </span>
        </form>
    </div>
</main>

<?php $this->registerJsFile('/js/A11/app.js'); ?>
</body>
</html>
