<?php

use yii\helpers\Html;
use kartik\file\FileInput;

/**
 * @var $user \app\models\User
 * @var $profile \app\models\UserProfile
 * @var $education \app\models\UserEducation
 * @var $experience \app\models\UserExperience
 * @var $certificate \app\models\UserCertificate
 * @var $document \app\models\UserDocument
 * @var $reference \app\models\UserReference
 * @var $months array
 * @var $years array
 * @var $email string
 * @var $password string
 * @var $marital array
 * @var $countries array
 * @var $states array
 * @var $cities array
 * @var $courses array
 */
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/templates/A24n/css/style.css">
    <link rel="stylesheet" href="/templates/A24n/css/responsive.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,900" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<header class="header">

</header>

<main class="create-cv">
    <ul class="create-list steps-registration">
        <li class="create-list__link steps-registration__link"><a href="" class="create-link steps-link active-link">1. create cv</a></li>
        <li class="create-list__link steps-registration__link"><a href="" class="create-link steps-link">2. choose template</a></li>
        <li class="create-list__link steps-registration__link"><a href="" class="create-link steps-link">3. send & download</a></li>
    </ul>
    <section class="reg-step">
        <p class="reg-step__item">STEP 1:  CREATE CV</p>
    </section>
    <form id="registrationFormFront" name="registrationForm" method="post" action="/registration">
        <div class="container">
            <div class="create-photo-name">
                <?php
                echo FileInput::widget([
                    'model' => $user,
                    'attribute' => 'user_photo',
                    'name' => 'photo',
                    'id' => 'registration-user-photo-front',
                    'options' => [
                        'multiple' => false,
                        'accept' => 'image/*',
                    ],
                    'pluginOptions' => [
                        'showUpload' => true,
                        'initialPreview' => ($user->user_photo) ? [
                            Html::img($user->user_photo, ['width' => 200, 'maxHeight' => 200, 'id' => 'fl-upld__inp', 'class' => "upload-photo__item circle"] )
                        ] : false,
                        'initialCaption' => (!$user->user_photo) ? "Select photo ..." : null,
                        'overwriteInitial' => true,
                        'showRemove' => false,
                        'allowedFileExtensions' => ['jpg', 'jpeg', 'png', 'gif'],
                        'browseLabel' => 'Select'
                    ]
                ]);
                ?>
                <div class="create-column">
                    <div class="create-space-between">
                        <input name="firstname" type="text"
                               class="input-base create-input234" placeholder="First name">
                        <input name="middlename" type="text"
                               class="input-base create-input234" placeholder="Middle Name(optional)">
                    </div>
                    <div class="create-space-between">
                        <input name="lastname" type="text"
                               class="input-base create-input234" placeholder="Last name">
                        <span class="calendar">
                            <input type="date" id="registration-user-date-of-birth-front" name="date-of-birth"
                                   class="input-base create-input234" placeholder="YYYY-MM-DD" min="1950-01-01" max="<?= date("Y-m-d") ?>" value="2000-01-01">
                        </span>
                    </div>
                    <div class="create-space-between">
                        <span class="choice-edit">
                            <select name="gender"
                                    class="create-select select-base create-input234">
                                <option value="f">Female</option>
                                <option value="m">Male</option>
                            </select>
                        </span>
                        <span class="choice-edit">
                            <select id="registration-user-marital-front" name="marital"
                                    class="create-select select-base create-input234 choice-edit">
                                <option value="">Marital Status</option>
                                <?php foreach ($marital as $item) { ?>
                                    <option><?php echo $item; ?></option>
                                <?php } ?>
                            </select>
                        </span>
                    </div>
                </div>
            </div>
            <section class="place-of-birth">
                <h6 class="place-of-birth__title">Place of Birth:</h6>
                <div class="create-space-between">
                    <span class="choice-edit">
                        <select id="registration-user-birth-place-front" name="birth-place"
                                class="create-select select-base create-input350 choice-edit">
                            <option value="">Country</option>
                            <?php foreach ($countries as $country) { ?>
                                <option value="<?php echo $country['code']; ?>"><?php echo $country['en']; ?></option>
                            <?php } ?>
                        </select>
                    </span>
                    <span class="choice-edit">
                        <input list="registration-user-city-list-front"
                               class="form-control full-width create-input350 choice-edit" required="required"
                               id="registration-user-city-front" name="city" placeholder="Select City" data-city-id="">
                                                            <datalist id="registration-user-city-list-front">
                                                                <option value="City" data-city-id=""></option>
                                                            </datalist>
                    </span>
                </div>
                <div class="create-space-between">
                    <input id="registration-user-phone-front" name="phone" type="text"
                           class="input-base create-input350" placeholder="Phone">
                    <input disabled id="registration-user-email-front" name="email" type="text"
                           class="input-base create-input350" placeholder="Email"
                           value="<?php echo (!empty($email)) ? $email : ''; ?>">
                </div>
                <div class="create-space-between">
                    <span class="choice-edit">
                        <select id="registration-user-country-front" name="country"
                                class="create-select select-base create-input350 choice-edit">
                            <option value="">Country</option>
                            <?php foreach ($countries as $country) { ?>
                                <option value="<?php echo $country['code']; ?>"><?php echo $country['en']; ?></option>
                            <?php } ?>
                        </select>
                    </span>
                    <span class="choice-edit">
                        <select id="registration-user-state-front" name="state"
                                class="create-select select-base create-input350 choice-edit">
                            <option value="">State</option>
                        </select>
                    </span>
                </div>
                <div class="create-space-between">
                    <input id="registration-user-address-front" name="address" type="text"
                           class="input-base create-input539" placeholder="Address Line">
                    <input id="registration-user-zip-front" name="zip" type="text" class="input-base create-input159"
                           placeholder="ZIP">
                </div>
            </section>
            <section class="create-overview">
                <h4 class="create-title">Overview</h4>
                <textarea id="registration-user-overview-front" name="overview"
                          placeholder="Personal Statement Use this space to write two paragraphs about your strongest skill sets, abilities and experience."
                          class="create-textarea"></textarea>
                <input id="registration-user-skills-front" name="skills" type="text" class="input-base create-input100"
                       placeholder="Add your skills, separated by comma">
                <input id="registration-user-strengths-front" name="strengths" type="text"
                       class="input-base create-input100" placeholder="Add your personal strengths, separated by comma">
            </section>

            <section class="create-experience">
                <h4 class="create-title">experience (optional)</h4>
                <div id="experience-container">
                    <div id="registration-user-experience-front">
                        <div class="experience-block">
                            <div class="create-space-between">
                                <input name="experience[1][employer]" type="text" class="input-base create-input350"
                                       placeholder="Employer">
                                <input name="experience[1][job]" type="text" class="input-base create-input350"
                                       placeholder="Job Title">
                            </div>
                            <div class="create-space-between">
                    <span class="choice-edit">
                        <select name="experience[1][country]"
                                class="create-select select-base create-input350 choice-edit">
                            <option value="">Country</option>
                            <?php foreach ($countries as $country) { ?>
                                <option value="<?php echo $country['code']; ?>"><?php echo $country['en']; ?></option>
                            <?php } ?>
                        </select>
                    </span>
                                <input name="experience[1][location]" type="text" class="input-base create-input350"
                                       placeholder="Location">
                            </div>
                            <textarea name="experience[1][achievements]" placeholder="Achievements and responsibilities"
                                      class="create-textarea"></textarea>
                            <div class="add-experience">
                                <div class="time-from">
                                    <p class="month-at">Time period from</p>
                                    <div class="create-space-between">
                            <span class="choice-edit">
                                <select name="experience[1][from-month]"
                                        class="create-select select-base create-input159 choice-edit">
                                    <option value="">Month</option>
                                    <?php foreach ($months as $month) { ?>
                                        <option><?php echo $month; ?></option>
                                    <?php } ?>
                                </select>
                            </span>
                                        <span class="choice-edit">
                                <select name="experience[1][from-year]"
                                        class="create-select select-base create-input159 choice-edit">
                                    <option value="">Year</option>
                                    <?php foreach ($years as $year) { ?>
                                        <option><?php echo $year; ?></option>
                                    <?php } ?>
                                </select>
                            </span>
                                    </div>
                                </div>
                                <div class="time-to">
                                    <div class="time-to-checkbox">
                                        <p class="month-to">Time period to</p>
                                        <span>
                                <input name="experience[1][current]" type="checkbox">
                                <label for="cur-work">I currently work here</label>
                            </span>
                                    </div>
                                    <div class="create-space-between">
                            <span class="choice-edit">
                                <select name="experience[1][to-month]"
                                        class="create-select select-base create-input159 choice-edit">
                                    <option value="">Month</option>
                                    <?php foreach ($months as $month) { ?>
                                        <option><?php echo $month; ?></option>
                                    <?php } ?>
                                </select>
                            </span>
                                        <span class="choice-edit">
                                <select name="experience[1][to-year]"
                                        class="create-select select-base create-input159 choice-edit">
                                    <option value="">Year</option>
                                    <?php foreach ($years as $year) { ?>
                                        <option><?php echo $year; ?></option>
                                    <?php } ?>
                                </select>
                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <button id="add-experience-link" type="button" class="add-another link-blue">+ Add another experience</button>
            </section>

            <section class="education">
                <h4 class="create-title">education (optional)</h4>
                <div id="education-container">
                    <div id="registration-user-education-front">
                        <div class="education-block">
                            <div class="create-space-between">
                    <span class="choice-edit">
                        <select name="education[1][courses]"
                                class="create-select select-base create-input350 choice-edit">
                            <option value="">Course</option>
                            <?php foreach ($courses as $course) { ?>
                                <option><?php echo $course; ?></option>
                            <?php } ?>
                        </select>
                    </span>
                                <input name="education[1][school]" type="text" class="input-base create-input350"
                                       placeholder="School Name">
                            </div>
                            <div class="create-space-between">
                    <span class="choice-edit">
                        <select name="education[1][country]"
                                class="create-select select-base create-input350 choice-edit">
                            <option value="">Country</option>
                            <?php foreach ($countries as $country) { ?>
                                <option value="<?php echo $country['code']; ?>"><?php echo $country['en']; ?></option>
                            <?php } ?>
                        </select>
                    </span>
                                <input name="education[1][location]" type="text" class="input-base create-input350"
                                       placeholder="Location">
                            </div>
                            <div class="add-study-exp">
                                <div class="time-from">
                                    <p class="month-at">Time period from</p>
                                    <div class="create-space-between">
                            <span class="choice-edit">
                                <select name="education[1][from-month]"
                                        class="create-select select-base create-input159 choice-edit">
                                    <option value="">Month</option>
                                    <?php foreach ($months as $month) { ?>
                                        <option><?php echo $month; ?></option>
                                    <?php } ?>
                                </select>
                            </span>
                                        <span class="choice-edit">
                                <select name="education[1][from-year]"
                                        class="create-select select-base create-input159 choice-edit">
                                    <option value="">Year</option>
                                    <?php foreach ($years as $year) { ?>
                                        <option><?php echo $year; ?></option>
                                    <?php } ?>
                                </select>
                            </span>
                                    </div>
                                </div>
                                <div class="time-to">
                                    <div class="time-to-checkbox">
                                        <p class="month-to">Time period to</p>
                                        <span>
                                <input name="education[1][current]" type="checkbox">
                                <label for="cur-stud">I currently study here</label>
                            </span>
                                    </div>
                                    <div class="create-space-between">
                            <span class="choice-edit">
                                <select name="education[1][to-month]"
                                        class="create-select select-base create-input159 choice-edit">
                                    <option value="">Month</option>
                                    <?php foreach ($months as $month) { ?>
                                        <option><?php echo $month; ?></option>
                                    <?php } ?>
                                </select>
                            </span>
                                        <span class="choice-edit">
                                <select name="education[1][to-year]"
                                        class="create-select select-base create-input159 choice-edit">
                                    <option value="">Year</option>
                                    <?php foreach ($years as $year) { ?>
                                        <option><?php echo $year; ?></option>
                                    <?php } ?>
                                </select>
                            </span>
                                    </div>
                                </div>
                            </div>
                            <input name="education[1][specialization]" type="text" class="input-base create-input100"
                                   placeholder="Specialization">
                            <textarea name="education[1][description]" placeholder="Description (optional)"
                                      class="create-textarea-descr"></textarea>
                        </div>
                    </div>
                </div>
                <br>
                <button id="add-education-link" type="button" class="add-another link-blue">+ Add another education
                </button>
                <div class="create-doc-upld">
                    <?php
                    echo FileInput::widget([
                        'model' => $certificate,
                        'attribute' => 'path',
                        'name' => 'certificate',
                        'id' => 'registration-user-certificate-front',
                        'options' => [
                            'multiple' => false
                        ],
                        'pluginOptions' => [
                            'showUpload' => false,
                            'initialPreview' => ($certificate->path) ? [
                                Html::img($certificate->path, ['width' => 200, 'maxHeight' => 200])
                            ] : false,
                            'initialCaption' => (!$certificate->path) ? "Select certificate ..." : null,
                            'overwriteInitial' => true,
                            'showRemove' => false,
                            'allowedFileExtensions' => ['doc', 'docx', 'pdf'],
                            'browseLabel' => 'Select'
                        ]
                    ]);
                    ?>
                </div>
            </section>
            <section class="inserts">
                <h4 class="create-title">Interests</h4>
                <input id="registration-user-interests-front" name="interests" type="text"
                       class="input-base create-input100" placeholder="Interests">
            </section>
            <section class="references">
                <h4 class="create-title">references (optional)</h4>
                <div id="reference-container">
                    <div id="registration-user-references-front">
                        <div class="references-contacts">
                            <div class="create-space-between">
                                <input name="references[1][name]" type="text" class="input-base create-input350"
                                       placeholder="Name">
                                <input name="references[1][surname]" type="text" class="input-base create-input350"
                                       placeholder="Surname">
                            </div>
                            <div class="create-space-between">
                                <input name="references[1][job]" type="text" class="input-base create-input350"
                                       placeholder="Job Title">
                                <input name="references[1][company]" type="text" class="input-base create-input350"
                                       placeholder="Company Name">
                            </div>
                            <div class="create-space-between rem-margin">
                                <input name="references[1][phone]" type="text" class="input-base create-input350"
                                       placeholder="Phone Number">
                                <input name="references[1][email]" type="email" class="input-base create-input350"
                                       placeholder="Email">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <button id="add-reference-link" type="button" class="add-another link-blue">+ Add another reference
                </button>
                <div class="create-doc-upld">

                    <?php
                    echo FileInput::widget([
                        'model' => $document,
                        'attribute' => 'path',
                        'name' => 'document',
                        'id' => 'registration-user-document-front',
                        'options' => [
                            'multiple' => false
                        ],
                        'pluginOptions' => [
                            'showUpload' => false,
                            'initialPreview' => ($document->path) ? [
                                Html::img($document->path, ['width' => 200, 'maxHeight' => 200])
                            ] : false,
                            'initialCaption' => (!$document->path) ? "Select document ..." : null,
                            'overwriteInitial' => true,
                            'showRemove' => false,
                            'allowedFileExtensions' => ['doc', 'docx', 'pdf'],
                            'browseLabel' => 'Select'
                        ]
                    ]);
                    ?>

                </div>
            </section>
            <div id="not-required-fields" class="error-title" style="display: none">
                <span style="color: red"></span>
            </div>
            <button type="submit" hidden id="submit-registration-btn">Submit</button>
            <button type="button" hidden id="save-cont-btn"></button>
            <button type="button" id="registration-user-data-create-button-front" class="button-orange create-continue">
                Continue
            </button>
        </div>
        <?php echo Html:: hiddenInput(Yii::$app->getRequest()->csrfParam, Yii::$app->getRequest()->getCsrfToken(), []); ?>
    </form>
</main>

<script src="/js/A23/app.js"></script>
</body>
<div id="account-premium-popup invitation" class="popup-premium invitation" style="position: fixed; top: 0; left: 0; display: none">
    <input type="hidden" id="premium-template-user-id" value="<?php echo $user->id; ?>">
    <div class="popup-premium-container">
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
        <div class="g-recaptcha" data-sitekey="6LdLq2QUAAAAABldXROCWgaOX5HXeusTEdtK29Gp"></div>
        <button id="account-premium-popup-unlock" class="button-orange popup-unlock">Unlock now</button>
    </div>
</div>