<?php /**
 * @var $user \app\models\UserProfile;
 */
$this->registerCssFile('/templates/A55/css/style.css');
$this->registerCssFile('/templates/A55/css/responsive.css'); ?>
<body>
      <main class="main">
        <div class="professional-cv-template">
            <div class="free-pls-tmpl">
                <div class="prof-cv">
                    <div class="share-dwnl create-cv">
                        <ul class="create-list steps-registration">
                            <li class="create-list__link steps-registration__link"><a href="" class="create-link steps-link">create cv</a></li>
                            <li class="create-list__link steps-registration__link"><a href="" class="create-link steps-link">choose template</a></li>
                            <li class="create-list__link steps-registration__link"><a href="" class="create-link steps-link active-link">send & download</a></li>
                        </ul>
                        <section class="choose-tmpl reg-step">
                            <a href="" class="link-blue choose-back">Back</a>
                            <p class="reg-step__item">STEP 4:  download & send</p>
                        </section>
                        <div class="btns-wrap free-plus-btns">
                            <button class="button-orange send">send as application</button>
                            <button class="button-simple download">download as pdf</button>
                            <div class="btns-share-print">
                                <button class="button-simple share">share</button>
                                <button class="button-simple print">print</button>
                            </div>
                        </div>
                        <p class="professional-use">You use a professional template</p>
                    </div>
                </div>
            </div>
            <div class="professional-third-template preview-prof-third">
                <section class="professional-third-title-wrap">
                    <div class="professional-third-mask">
                        <section class="professional-third-photo third-profile-mob">
                            <img src="/templates/A55/img/photo.png" alt="Photo" class="professional-third-photo__item circle">
                        </section>
                        <h1 class="professional-title"><?= $user->first_name . ' ' . $user->last_name ?></h1>
                        <h4 class="professional-descr"></h4>
                        <p class="professional-years"></p>
                    </div>
                </section>
                <section class="professional-third-contact-wrap">
                    <div class="professional-third-mask">
                        <div class="professional-third-container">
                            <section class="prof-sections section-contact-details">
                                <h2 class="prof-sections__title">CONTACT DETAILS</h2>
                                <span class="premium-phones">
                                   <img src="/templates/A55/img/icons/phone.svg" alt=""><p class="premium-phones__item"><?= $user->phone ?></p>
                                </span>
                                <span class="premium-phones">
                                    <img src="/templates/A55/img/icons/msg.svg" alt=""><p class="prof-sections__email"><?= $user->email ?></p>
                                </span>
                                <span class="premium-phones">
                                    <img src="/templates/A55/img/icons/planet.svg" alt=""><p class="prof-sections__addr"><?= $user->address ?></p>
                                </span>
                            </section>
                            <section class="professional-third-photo">
                                <img src="/templates/A55/img/photo.png" alt="Photo" class="professional-third-photo__item circle">
                            </section>
                            <section class="icon-year-exp">
                                <img src="/templates/A55/img/pro-big.png" alt="PRO" class="icon-year-exp__image">
                                <span class="icon-year-exp__years"><label></label><p class="prof-year-exp">Years Experience</p></span>
                            </section>
                        </div>
                    </div>
                </section>
                <div class="professional-third-cv">
                    <div class="professional-third-container">
                        <aside class="right-part">
                            <div class="container-right-sidebar">
                                <section class="premium-sections prof-third-skills-mob">
                                    <h2 class="premium-sections__title">Skills</h2>
                                    <p class="premium-sections__descr">Testing, Manual Testing, Analyses, Management</p>
                                </section>
                                <section class="premium-sections">
                                    <h2 class="premium-sections__title">Summary of experience</h2>
                                    <p class="premium-sections__descr"></p>
                                </section>
                                <section class="premium-sections prof-third-skills">
                                    <h2 class="premium-sections__title">Skills</h2>
                                    <div class="preview-wrap-plus">

                                        <?php $skills = explode(',',$user->skills);
                                        foreach ($skills as $skill):
                                            if(!empty($skill)):?>
                                                <li class="premium-list__item"><span><?= $skill ?></span></li>
                                            <?php endif;
                                        endforeach; ?>

                                        <p class="preview-parag"></p>
                                    </div>
                                </section>
                                <section class="premium-sections prof-third-interests">
                                    <h2 class="premium-sections__title">interests</h2>
                                    <div class="preview-wrap-plus">
                                        <ul class="premium-list">

                                            <?php $interests = explode(',',$user->interests);
                                            foreach ($interests as $interest): ?>
                                                <?php if(!empty($interest)):?>
                                                    <li class="premium-list__item"><span><?= $interest ?></span></li>
                                                <?
                                                endif;
                                            endforeach;
                                            ?>

                                        </ul>
                                        <p class="preview-parag"></p>
                                    </div>
                                </section>
                            <div>
                        </aside>
                        <div class="premium-content">
                            <div class="container-premium">
                                <section class="premium-content-section section-experience">
                                    <h2 class="premium-content-section__title">EXPERIENCE</h2>

                                    <?php foreach ($user->exp as $experience ) : ?>
                                        <p class="premium-content-section__company"><?= $experience->employer ?></p>
                                        <p class="premium-content-section__years"><?= $experience->from_month .' '. $experience->from_year .' - '. $experience->to_month .''. $experience->to_year ?></p>
                                        <div class="preview-wrap-plus">
                                            <ul class="premium-content-list">
                                                <li class="premium-content-list__item"><?= $experience->job_title ?></li>
                                            </ul>
                                            <p class="preview-parag-second"></p>
                                        </div>
                                    <?php endforeach; ?>

                                </section>
                                <section class="premium-content-section">
                                    <h2 class="premium-content-section__title">Education</h2>

                                    <?php foreach ($user->education as $education) : ?>
                                        <p class="premium-content-section__education"><?= $education->school_name ?></p>
                                        <p class="premium-content-section__company"><?= $education->name ?></p>
                                        <section class="free-certificate-download free-download">
                                            <a href="<?= $user->certificate[0]->path ?>" class="link-blue"><?= $user->certificate[0]->name.'.'.$user->certificate[0]->mime_type?></a>
                                            <p class="free-download__code"><?= $education->license_number ?></p>
                                            <p class="free-download__date"><?= $education->from_month .' '. $education->from_year .'-'. $education->to_month .' '. $education->to_year?> </p>
                                        </section>
                                    <?php endforeach; ?>

                                </section>
                                <section class="premium-content-section prof-third-interests-mobile">
                                    <h2 class="premium-content-section__title">Interests</h2>
                                    <p class="premium-content-section__education">Information Technology, Software Development</p>
                                </section>
                                <section class="premium-content-section">
                                    <h2 class="premium-content-section__title">Recommendations</h2>
                                    <section class="free-recommendation-download free-download">
                                        <a href="<?= $user->document[0]->path ?>" class="link-blue"><?= $user->document[0]->name.'.'.$user->document[0]->mime_type?></a>
                                        <div class="recommendation-paragraphs">
                                        <span class="recommendation-person">
                                            <p class="recommendation-person__name"></p>
                                        </span>
                                        <span class="recommendation-person">
                                            <p class="recommendation-person__name"></p>
                                        </span>
                                    </section>
                                </section>
                            </div>
                            <p class="copyright">© Copyright Protection Dropcv.io</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
      <?php $this->registerJsFile('/templates/A55/js/app.js'); ?>
</body>

