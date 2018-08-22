<?php /**
 * @var $user \app\models\UserProfile;
 */
$this->registerCssFile('/templates/A35/css/style.css');
$this->registerCssFile('/templates/A35/css/responsive.css'); ?>
<body>
    <main class="main">
        <div class="free-pls-tmpl preview-prof-first">
            <button class="btn-close"><img src="/templates/A35/img/icons/close.svg" alt="close"></button>
            <div class="professional-cv">
                <div class="background-prof">
                <section class="icon-year-exp">
                    <img src="/templates/A35/img/pro-big.png" alt="PRO" class="icon-year-exp__image">
                    <span class="icon-year-exp__years"><label></label><p class="prof-year-exp">Years Experience</p></span>
                </section>
                <section class="pro-person-data">
                    <img src="/templates/A35/img/prof-person.png" alt="photo" class="pro-person-data__photo circle">
                    <h1 class="pro-person-data__title"><?= $user->first_name . ' ' . $user->last_name ?></h1>
                    <h4 class="pro-person-data__descr"></h4>
                    <span class="pro-person-data__years">
                        <p class="years-old"><label><?= gmdate("Y-m-d", $user->date_of_birth) ?></label></p>
                    </span>
                </section>
                </div>
            </div>

            <div class="professional-cv-content premium-cv-content">
                <aside class="right-part">
                    <div class="container-right-sidebar">
                        <section class="premium-sections">
                            <h4 class="premium-sections__title">contact details</h4>
                            <span class="premium-phones">
                                <p class="premium-phones__item"><?= $user->phone ?></p>
                            </span>
                            <span class="free-pls-sections__phones">
                                <img src="/templates/A35/img/icons/msg.svg" alt=""><p class="premium-sections__email"><?= $user->email ?></p>
                            </span>
                            <span class="free-pls-sections__phones">
                                <img src="/templates/A35/img/icons/planet.svg" alt=""><p class="premium-sections__addr"><?= $user->address ?></p>
                            </span>
                        </section>
                        <section class="premium-sections">
                            <h2 class="premium-sections__title">Skills</h2>
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
                    <div>
                </aside>
                <div class="premium-content">
                    <div class="container-premium">
                        <section class="premium-content-section">
                            <h2 class="premium-content-section__title">Summary of experience</h2>
                            <hr>
                            <p class="premium-content-section__descr"></p>
                        </section>
                        <section class="premium-content-section">
                            <h2 class="premium-content-section__title">EXPERIENCE</h2>
                            <hr>

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

                        </section>
                        <section class="premium-content-section">
                            <h2 class="premium-content-section__title">Education</h2>
                            <hr>

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
                        <section class="premium-content-section">
                            <h2 class="premium-content-section__title">interests</h2>
                            <hr>
                            <div class="preview-wrap-prof">
                                <ul class="premium-content-list">

                                    <?php $interests = explode(',',$user->interests);
                                    foreach ($interests as $interest): ?>
                                        <?php if(!empty($interest)):?>
                                            <li class="premium-list__item"><span><?= $interest ?></span></li>
                                        <?
                                        endif;
                                    endforeach;
                                    ?>
                                </ul>
                                <p class="preview-par"></p>
                            </div>
                        </section>
                        <section class="premium-content-section">
                            <h2 class="premium-content-section__title">Recommendations</h2>
                            <hr>
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
    </main>
</body>
<?php $this->registerJsFile('/templates/A45/js/app.js'); ?>