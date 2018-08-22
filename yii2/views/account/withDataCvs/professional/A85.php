<?php /**
 * @var $user \app\models\UserProfile;
 */
$this->registerCssFile('/templates/A35/css/style.css');
$this->registerCssFile('/templates/A35/css/responsive.css'); ?>
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
            <div class="preview-prof-fifth">
                <div class="professional-six-cv">
                    <div class="professional-six-container">
                        <div class="professional-six-wrap">
                            <div class="professional-six-image">
                                <img src="/templates/A85/img/profile.png" alt="Profile">
                            </div>
                            <section class="professional-fourth-descr">
                                <h1 class="professional-fourth-descr__title"><?= $user->first_name . ' ' . $user->last_name ?></h1>
                                <h4 class="professional-fourth-descr__prof"></h4>
                                <div class="prev-four-wrap">
                                    <img src="/templates/A85/img/icons/profile.svg" alt=""><p class="professional-fourth-descr__years"></p>
                                </div> 
                            </section>
                            <div class="professional-fifth-exp">
                                <img src="/templates/A85/img/pro-big.png" alt="PRO" class="professional-fifth-exp__pro">
                                <span class="icon-year-exp__years"><label>10</label><p class="prof-year-exp">Years Experience</p></span>
                            </div>
                        </div>
                        <hr>
                        <div class="professional-six-contacts">
                            <section class="professional-fourth-descr-mob">
                                <h1 class="professional-fourth-descr-mob__title"><?= $user->first_name . ' ' . $user->last_name ?></h1>
                                <h4 class="professional-fourth-descr-mob__prof">Quality Assurance, Product Manager, Business Analyst </h4>
                                <p class="professional-fourth-descr-mob__years"><label><?= gmdate("Y-m-d", $user->date_of_birth) ?></label></p>
                                <hr>
                            </section>
                            <section class="premium-sections section-contact-details-mobile">
                                <h2 class="prof-sections__title">CONTACT DETAILS</h2>
                                <span class="premium-phones">
                                    <p class="premium-phones__item"><?= $user->phone ?></p>
                                </span>
                                <p class="prof-sections__email"><?= $user->email ?></p>
                                <p class="prof-sections__addr"><?= $user->address ?><br> </p>
                            </section>
                            
                            <span class="premium-phones">
                                <p class="premium-phones__item"></p>
                            </span>
                            <p class="prof-sections__email"></p>
                            <p class="prof-sections__addr"></p>
                        </div>
                        <div class="professional-six-content">

                            <aside class="right-part">
                                <div class="right-part-mask">
                                    <div class="six-sidebar-container">
                                        <section class="premium-sections prof-third-skills">
                                            <h2 class="premium-sections__title"><span>Skills</span></h2>
                                            <div class="preview-wrap-plus">
                                                <ul class="premium-list">

                                                    <?php $skills = explode(',',$user->skills);
                                                    foreach ($skills as $skill):
                                                        if(!empty($skill)):?>
                                                            <li class="premium-list__item"><span><?= $skill ?></span></li>
                                                        <?php endif;
                                                    endforeach; ?>

                                                </ul>
                                                <p class="preview-parag"></p>
                                            </div>
                                        </section>
                                        <section class="premium-sections prof-third-interests">
                                            <h2 class="premium-sections__title"><span>interests</span></h2>
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
                                        <section class="premium-sections prof-six-section">
                                            <h2 class="premium-sections__title">Summary of experience</h2>
                                            <p class="premium-sections__descr"></p>
                                        </section>
                                    </div>
                                </div>                        
                            </aside>
                            <div class="premium-content">
                                <div class="container-premium">
                                    <section class="premium-content-section section-experience">
                                        <h2 class="premium-content-section__title">EXPERIENCE</h2>

                                        <?php foreach ($user->exp as $experience ) : ?>
                                            <p class="premium-content-section__company"><?= $experience->employer ?></p>
                                            <p class="premium-content-section__years"><?= $experience->from_month .' '. $experience->from_year .' - '. $experience->to_month .''. $experience->to_year ?></p>
                                            <div class="preview-wrap-prof">
                                                <ul class="premium-content-list">
                                                    <li class="premium-content-list__item"><?= $experience->job_title ?></li>
                                                </ul>
                                                <p class="preview-par"></p>
                                            </div>
                                        <?php endforeach; ?>

                                        <p class="premium-content-section__company"></p>
                                        <p class="premium-content-section__years"></p>
                                        <div class="preview-wrap-plus">
                                            <ul class="premium-content-list">
                                                <li class="premium-content-list__item"></li>
                                                <li class="premium-content-list__item"></li>
                                                <li class="premium-content-list__item"></li>
                                                <li class="premium-content-list__item"></li>
                                                <li class="premium-content-list__item"></li>
                                            </ul>
                                            <p class="prev-parag-third"></p>
                                        </div> 
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
                                        <h2 class="premium-content-section__title">interests</h2>

                                        <?php $skills = explode(',',$user->skills);
                                        foreach ($skills as $skill): ?>
                                            <p class="premium-content-section__education"><?= $skill ?></p>
                                        <?php endforeach; ?>

                                    </section>
                                    <section class="premium-content-section prof-fourth-recomendation">
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
                                    <p class="copyright">© Copyright Protection Dropcv.io</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<?php $this->registerJsFile('/templates/A85/js/app.js'); ?>