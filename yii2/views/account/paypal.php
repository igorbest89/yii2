<?
$this->registerCssFile('/templates/A63/css/style.css');
$this->registerCssFile('/templates/A63/css/responsive.css');
?>


<!DOCTYPE html>
<html lang="en">
<body>
    <div class="popup-premium unlock-professional">
        <div class="popup-premium-container">
            <button class="popup-premium-close unlock-btn-close"><img src="/templates/A63/img/icons/close.svg" alt="close"></button>
            <div class="unlock-professional-container">
                <section class="popup-title">
                    <p class="popup-text">Unlock <span>PROFESSIONAL</span> now:</p>
                </section>
                <section class="professional-advantages professional-advantages-cv">
                    <img src="/templates/A63/img/icons/verified.svg" alt="verified" class="professional-advantages__verified">
                    <p class="professional-advantages__descr">Use our beautiful PROFESSONAL CV templates</p>
                </section>
                <section class="professional-advantages professional-advantages-pro">
                    <img src="/templates/A63/img/icons/verified.svg" alt="verified" class="professional-advantages__verified">
                    <p class="professional-advantages__descr">Get a PROFESSIONAL label on your CV</p>
                    <img src="/templates/A63/img/pro-big.png" alt="pro" class="professional-advantages__pro">
                </section>
                <section class="professional-advantages professional-advantages-send">
                    <img src="/templates/A63/img/icons/verified.svg" alt="verified" class="professional-advantages__verified">
                    <p class="professional-advantages__descr">Send your CV to any company by email with our inbuild <br> PROFESSIONAL send system</p>
                </section>      
                <section class="professional-advantages professional-advantages-unbranded">
                    <img src="/templates/A63/img/icons/verified.svg" alt="verified" class="professional-advantages__verified">
                    <p class="professional-advantages__descr">Unbranded CV templates</p>
                </section>  
                <hr>    
                <section class="choose-period">
                    <h4 class="choose-period__title">Choose your period:</h4>
                    <div class="choose-period-wrap">
                        <div class="choose-period-month-wrap choose-period-month-active">
                            <div class="choose-period-three-month">
                                <h4 class="choose-period-three-month__quantity">3 MONTHS</h4>
                                <p class="choose-period-three-month__price">monthly price:</p>
                                <p class="choose-period-three-month__sum">$1.5</p>
                                <p class="choose-period-three-month__period">period price:</p>
                                <p class="choose-period-three-month__period-sum">$4.5</p>
                            </div>
                        </div>
                        <div class="choose-period-month-wrap">
                            <div class="choose-period-three-month choose-period-six-month">
                                <div class="choose-ribbon"><span>POPULAR</span></div>
                                <h4 class="choose-period-three-month__quantity">6 MONTHS</h4>
                                <p class="choose-period-three-month__price">monthly price:</p>
                                <p class="choose-period-three-month__sum">$1.0</p>
                                <p class="choose-period-three-month__period">period price:</p>
                                <p class="choose-period-three-month__period-sum">$6.0</p>
                            </div>
                        </div>
                        <div class="choose-period-month-wrap">
                            <div class="choose-period-three-month choose-period-twelve-month">
                                <div class="choose-ribbon"><span>BEST VALUE</span></div>
                                <h4 class="choose-period-three-month__quantity">12 MONTHS</h4>
                                <p class="choose-period-three-month__price">monthly price:</p>
                                <p class="choose-period-three-month__sum">$0.8</p>
                                <p class="choose-period-three-month__period">period price:</p>
                                <p class="choose-period-three-month__period-sum">$9.6</p>
                            </div>
                        </div>
                    </div>
                    <p class="choose-packages-period">All packages are automatically renewed after the selected period. You can cancel the extension at any time.</p>
                    <hr>
                </section>
                <div class="payment-method">
                    <p class="choose-payment-method">Choose your payment method:</p>
                    <button class="paypal-btn"><img src="/templates/A63/img/paypal.svg" alt="paypal"></button>
                </div>
                <button id="accept-payment">go to payment</button>
            </div>
        </div>
        <div id="success-payment" class="popup-premium popup-payment" style="display: none">
            <div class="popup-premium-container">
                <button class="popup-premium-close"><img src="/templates/A73/img/icons/close.svg" alt="close"></button>
                <section class="title">
                    <h1 class="title__item">Thank you for your Payment</h1>
                </section>
                <section class="popup-title">
                    <p class="popup-text">You have now unlocked a <span>PROFESSIONAL</span> Membership</p>
                </section>
                <button class="button-orange">continue</button>
            </div>
        </div>
    </div>
</body>
    <?php $this->registerJsFile('/js/A21/app.js'); ?>
</html>
<?php

$this->registerCssFile('/templates/A52/css/style.css');
$this->registerCssFile('/templates/A52/css/responsive.css');

?>

<div class="popup-premium popup-cancel">
    <div class="popup-premium-container">
        <button class="popup-premium-close unlock-btn-close"><img src="/templates/A52/img/icons/close.svg" alt="close"></button>
        <p class="popup-cancel-paragraph">Are you sure you want to cancel your subscription?</p>
        <div class="btns-wrap">
            <button class="button-orange">NO</button>
            <button class="button-simple" id="unsubscribe-user">yes</button>
        </div>
    </div>
</div>

<?php $this->registerJsFile('/templates/A52/js/app.js'); ?>