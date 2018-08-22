<?php /**
 * @var $user \app\models\UserProfile;
 */
$this->registerCssFile('/templates/A25/css/style.css');
$this->registerCssFile('/templates/A25/css/responsive.css');
$datetime1 = new DateTime('now');
$datetime2 = new DateTime(gmdate("Y-m-d", $user->date_of_birth));
$interval = $datetime2->diff($datetime1);
?>
<body>
    <main class="main">
        <div class="free-pls-tmpl preview-premium">
            <div class="preview-premium-container">
                <button class="btn-close"><img src="/templates/A25/img/icons/close.svg" alt="close"></button>
            </div>
            <div class="premium-cv-content">
                <aside class="right-part">
                    <div class="container-right-sidebar">
                        <span class="premium-absolute">Premium</span>
                        <img src="/templates/A25/img/cv-profile.png" alt="profile" class="premium-photo circle">
                        <h2 class="premium-title">Christoffer J. Simpson</h2>
                        <span class="premium-content__years">
                            <p class="years-old"><label><?= $interval->format('%Y%'); ?></label></p>
                            <p class="years-exp"><label></label> years of experience</p>
                        </span>
                        <h1 class="premium-content__title">Quality Assurance, Product Manager, Business Analyst </h1>
                        <section class="premium-sections">
                            <h4 class="premium-sections__title">contact details</h4>
                            <span class="premium-phones">
                                <p class="premium-phones__item"><?= $user->phone ?></p>
                            </span>
                            <span class="free-pls-sections__phones">
                                <img src="/templates/A25/img/icons/msg.svg" alt=""><p class="premium-sections__email"><?= $user->email ?></p>
                            </span>
                            <span class="free-pls-sections__phones">
                                <img src="/templates/A25/img/icons/planet.svg" alt=""><p class="premium-sections__addr"><?= $user->address ?></p>
                            </span>
                        </section>
                        <section class="premium-sections">
                            <h2 class="premium-sections__title">Summary of experience</h2>
                            <p class="premium-sections__descr"></p>
                        </section>
                        <section class="premium-sections">
                            <h2 class="premium-sections__title">Skills</h2>
                            <div class="preview-wrap-plus">
                                <ul class="free-pls-list">

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
                        <h1 class="premium-content__title"></h1>
                        <span class="premium-content__years">
                            <img src="/templates/A25/img/icons/profile.svg" alt=""><p class="years-old"></p>
                            <img src="/templates/A25/img/icons/exp.svg" alt=""><p class="years-exp"></p>
                        </span>
                        <section class="premium-content-section">
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
                        <section class="premium-content-section">
                            <h2 class="premium-content-section__title">interests</h2>
                            <?php $interests = explode(',',$user->interests);
                            foreach ($interests as $interest): ?>
                                <?php if(!empty($interest)):?>
                                    <li class="premium-list__item"><span><?= $interest ?></span></li>
                                <?
                                endif;
                            endforeach;
                            ?>

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
                        <div class="free-plus-footer">
                            <p class="created-logo__descr">Created by</p>
                            <img src="/templates/A25/img/icons/logo.svg" alt="logo">
                            <a href="" class="link-blue">Build your career</a>
                        </div>
                        <p class="free-plus-copyright">© Copyright Protection Dropcv.io</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="js/app.js"></script>
</body>
</html>