<?php
use app\models\Account;
/**
 * @var $user \app\models\User
 * @var $profile \app\models\UserProfile
 * @var $email string
 * @var $account \app\models\Account
 * @var $accountTemplate \app\models\AccountTemplate
 * @var $userAccounts array
 * @var $templates Account
 */
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/A33/style.css">
    <link rel="stylesheet" href="/css/A33/responsive.css">
    <link rel="stylesheet" href="/css/A43/style.css">
    <link rel="stylesheet" href="/css/A43/responsive.css">
    <link rel="stylesheet" href="/css/A53/style.css">
    <link rel="stylesheet" href="/css/A53/responsive.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,900" rel="stylesheet">
    <title>Document</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
    <header class="header">

    </header>

    <main class="create-cv">
        <ul class="create-list steps-registration">
            <li class="create-list__link steps-registration__link"><a href="" class="create-link steps-link">create cv</a></li>
            <li class="create-list__link steps-registration__link"><a href="" class="create-link steps-link active-link">choose template</a></li>
            <li class="create-list__link steps-registration__link"><a href="" class="create-link steps-link">share & download</a></li>
        </ul>
        <section class="choose-tmpl reg-step">
            <a href="" class="link-blue choose-back">Back</a>
            <p class="reg-step__item">STEP 3:  choose template</p>
        </section>
        <div class="choose-container">
            <input type="hidden" id="account-template-user-id" value="<?php echo $user->id; ?>">
            <section class="choice-cv">
                <?php foreach ($onlyAccounts as $acc => $value): ?>
                <?php if($templateTypeSession == $value): ?>
                <div class="choice-cv__wrap active-cv" id="account-template-free" data-name="<?= $value?>">
                    <h4 class="free-cv__title"><?= $value ?></h4>
                    <img src="/img/A33/free.png" alt="free-cv" class="free-cv__item">
                </div>
                <?php else : ?>
                        <div class="choice-cv__wrap" id="account-template-free" data-name="<?= $value?>">
                            <h4 class="free-cv__title"><?= $value ?></h4>
                            <img src="/img/A33/free.png" alt="free-cv" class="free-cv__item">
                        </div>
                    <?php endif;

                 endforeach; ?>
            </section>
            <div class="btns-wrap">
                <a href="" class="button-simple" id="account-template-preview-button">preview</a>
<!--              <button class="button-simple" id="account-template-preview-button">preview</button>-->
                <button class="button-orange" id="account-template-continue-button">continue</button>
            </div>

            <section class="choice-cv images-cvs">
                <?php foreach ($templates['relationship'] as $template):
                     if ($template['tmpl'][0]['name'] == $templateNameSession): ?>
                <div class="choice-img__wrap active-img" id="account-template-free-plus" data-name="<?= $template['tmpl'][0]['name']?>"  data-url="<?=$template['url']?>" data-type="<?php echo Account::ACCOUNT_FREE_PLUS; ?>">
                    <h4 class="free-cv-plus__title"><?= $template['tmpl'][0]['name'] ?></h4>
                    <img src="<?= $template['tmpl'][0]['path_to_image']?>" alt="free-cv" class="free-cv-plus__item">
                </div>
                    <?php  else :?>
                  <div class="choice-img__wrap" id="account-template-free-plus" data-name="<?= $template['tmpl'][0]['name']?>" data-url="<?=$template['url']?>" data-type="<?php echo Account::ACCOUNT_FREE_PLUS; ?>">
                    <h4 class="free-cv-plus__title"><?= $template['tmpl'][0]['name'] ?></h4>
                    <img src="<?= $template['tmpl'][0]['path_to_image']?>" alt="free-cv" class="free-cv-plus__item">
                  </div>
                        <?php endif;
               endforeach; ?>
            </section>
        </div>

        <div id="account-premium-popup invitation" class="popup-premium invitation" style="position: fixed; top: 0; left: 0; display: none">
            <input type="hidden" id="premium-template-user-id" value="<?php echo $user->id; ?>">
            <div class="popup-premium-container" id="invite-friends">
                <button id="account-premium-popup-close" class="popup-premium-close"><img src="/img/A43/icons/close.svg" alt="close"></button>
                <section class="popup-title">
                    <p class="popup-text">To unlock <span>PREMIUM</span> for 6 months, please recommend dropcv to <a href="" class="link-blue">3 of your friends</a></p>
                </section>
                <section class="popup-inputs-wrap popup-inputs">
                    <input id="recommend-name-one" type="text" class="input-base" placeholder="Name" >
                    <input id="recommend-email-one" type="text" class="input-base" placeholder="Email Address" >
                </section>
                <section class="popup-inputs-wrap">
                    <input id="recommend-name-two" type="text" class="input-base" placeholder="Name" >
                    <input id="recommend-email-two" type="text" class="input-base" placeholder="Email Address" >
                </section>
                <section class="popup-inputs-wrap">
                    <input id="recommend-name-three" type="text" class="input-base" placeholder="Name" >
                    <input id="recommend-email-three" type="text" class="input-base" placeholder="Email Address" >
                </section>
                <h4 id="popup-premium-message" style="color: red"></h4>
                <form id="my-form">
                    <div class="g-recaptcha" data-sitekey="6LdLq2QUAAAAABldXROCWgaOX5HXeusTEdtK29Gp"></div>
                </form>
                    <button id="account-premium-popup-unlock" class="button-orange popup-unlock">Unlock now</button>

            </div>
        </div>

<!--        --><?php //if (!empty($userAccounts) && !$session['invitation']) {?>
<!--            --><?php //foreach ($userAccounts as $userAccount) { ?>
<!---->
<!--        <div id="popup-template---><?php //echo $userAccount['name']; ?><!--" class="popup-premium choose-prof-popup" style="position: fixed; top: 0; left: 0">-->
<!--            <div class="popup-premium-container popup-premium-template-container">-->
<!--                <button class="popup-template-close---><?php //echo $userAccount['name']; ?><!--"><img src="/img/A53/icons/close.svg" alt="close"></button>-->
<!--                <section class="popup-title">-->
<!--                    <p class="popup-text">Choose your <span>--><?php //echo strtoupper($userAccount['name']); ?><!--</span>template</p>-->
<!--                </section>-->
<!--                <div class="choose-prof-container">-->
<!--                    <div class="choose-prof-templates">-->
<!---->
<!--                        --><?php //foreach ($userAccount['data'] as $datum) { ?>
<!--                        <figure class="choose-prof-tmpl ">-->
<!--                            <img src="/img/A53/pro-1.png" alt="pro-template" class="choose-prof-tmpl__img">-->
<!--                            <figcaption class="choose-prof-descr">-->
<!--                                    <p class="choose-prof-descr__item" data-template-id="--><?//= $datum['id']?><!--">--><?php //echo $datum['name']; ?><!--</p>-->
<!--                            </figcaption>-->
<!--                        </figure>-->
<!--                    --><?php //} ?>
<!---->
<!--                    </div>-->
<!--                </div>-->
<!--                <button class="choose-template-button">choose tmpl</button>-->
<!--            </div>-->
<!--        </div>-->
<!--                --><?php //} ?>
<!--        --><?php //} ?>

        <div id="success-payment" class="popup-premium popup-payment" style="display: none">
            <div class="popup-premium-container" id="success-payment-container" style="top:-1100px">
                <button class="popup-premium-close" id="close-popup-success"><img src="/templates/A73/img/icons/close.svg" alt="close"></button>
                <section class="title">
                    <h1 class="title__item">Thank you for your Payment</h1>
                </section>
                <section class="popup-title">
                    <p class="popup-text">You have now unlocked a <span>PROFESSIONAL</span> Membership</p>
                </section>
                <button class="button-orange">continue</button>
            </div>
        </div>
    </main>

    <script src="/js/A33/app.js"></script>
    <script src="/js/A43/app.js"></script>
    <script src="/js/A53/app.js"></script>
</body>