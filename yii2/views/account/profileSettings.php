<?php /**
 * @var $user \app\models\UserProfile;
 */
use yii\helpers\Html;
$this->registerCssFile('/templates/A22/css/style.css');
$this->registerCssFile('/templates/A22/css/responsive.css');
$this->registerCssFile('/templates/A32/css/responsive.css');
$this->registerCssFile('/templates/A32/css/responsive.css');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="userData[viewport]" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,900" rel="stylesheet">
    <title>Document</title>
    <?php
        $this->registerCssFile('/templates/A22/css/style.css');
        $this->registerCssFile('/templates/A22/css/responsive.css');
        $this->registerCssFile('/templates/A32/css/responsive.css');
        $this->registerCssFile('/templates/A32/css/responsive.css');
    ?>
</head>
<body>
<header class="header">
</header>
<main class="main">
    <div class="profile-set-template">
        <div class="profile-container">
            <section class="title">
                <h1 class="title__item">PROFILE SETTINGS</h1>
            </section>
            <form id="profile-edit" action="/account/profile-settings" method="post">
            <div class="profile-set-data">
                    <span class="profile-set-image">
                        <img src="<?php echo $user->user_photo ?>" alt="profile">
                        <a href="" class="link-blue">Upload a photo</a>
                    </span>
                <div class="profile-set-inputs">
                    <input type="text" name="userData[username]" class="input-base" value="<?php echo $user->username?>">
                    <input type="text" name="userData[last_name]" class="input-base" value="<?php echo $user->last_name?>">
                    <div class="profile-set-inputs-cal">
                    </div>
                    <?php
                        if(is_null($user->getAttribute('user_date_births'))){?>
                            <span class="calendar-wrap"><input type="date" name="userData[bday]" class="input-calendar" value="2018-03-03" ></span>
                        <?php }else{?>
                            <span class="calendar-wrap"><input type="date" name="userData[bday]" class="input-calendar"
                                                               value="<?php echo $user->getAttribute('user_date_births')?>" ></span>

                        <?php }?>

                        <select id="registration-user-gender-front" name="userData[gender]" class="create-select select-base create-input234">
                            <?php
                                if($user->gender == 'Male'){?>
                                    <option  selected value="Male">Male</option>
                                    <option value="Female">Female</option>
                                <?php }else{?>
                                    <option  value="Male">Male</option>
                                    <option  selected  value="Female">Female</option>
                                <?php }
                            ?>

                        </select>
                    </div>
                </div>
            </div>
                <?php echo Html::hiddenInput(Yii::$app->getRequest()->csrfParam, Yii::$app->getRequest()->getCsrfToken(), []); ?>
            <div class="profile-set-inputs-wrap">
                <input type="text" class="input-base" name="userData[email]" value="<?php echo $user->email?>" placeholder="Email Address">
                <hr>
                <div class="profile-set-pass-wrap">
                    <span><input type="password" class="input-with-icon" name="userData[password]" placeholder="Set new password"></span>
                    <span><input type="password"  name="userData[confirm_password]" class="input-with-icon" placeholder="Confirm new password"></span>
                </div>

                <hr>
            </div>
            <div class="btns-wrap">
                <button class="button-simple">CANCEL</button>
                <input type="submit" id="update-data-profile-info" class="button-orange">SAVE CHANGES</input>
            </div>
            </form>
        <button class="link-blue delete-prof">Delete Profile</button>
        </div>
    </div>
    <div class="popup-premium popup-cancel" id="black-background" style="display:none;top: -900px;position: relative;">
        <div class="popup-premium-container">
            <button  id="close-popup-delete" class="popup-premium-close unlock-btn-close"><img src="/templates/A32/img/icons/close.svg" alt="close"></button>
            <p class="popup-cancel-paragraph">Are you sure you want to delete your profile?</p>
            <div class="btns-wrap">
                <button class="button-orange">NO</button>
                <button id="accept-delete-profile" class="button-simple">yes</button>
            </div>
        </div>
    </div>
</main>
<?php $this->registerJsFile('/templates/A22/js/app.js'); ?>
</body>
</html>