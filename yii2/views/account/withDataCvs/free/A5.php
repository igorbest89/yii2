<?
/**
 * @var $user \app\models\UserProfile;
 */
$this->registerCssFile('/templates/A5/css/style.css');
$this->registerCssFile('/templates/A5/css/responsive.css'); ?>
<body>
<main class="main">
    <div class="free-tmpl free-preview">
        <section class="free-cv">
            <button class="btn-close"><img src="/templates/A5/img/icons/close.svg" alt="close"></button>
            <figure class="free-person">
                <img src="/templates/A5/img/free-photo.png" alt="photo-person" class="free-photo circle">
                <figcaption class="data-descr">
                    <div class="person-data-name">
                        <div class="person-data">
                            <div class="h-wrap">
                                <h1 class="person-data__name"><?= $user->first_name . ' ' . $user->last_name ?></h1>
                            </div>
                            <p class="person-data__profession"></p>
                            <div class="person-data-wrap">
                                <img src="/templates/A5/img/icons/age.svg" alt=""><p class="person-data__years"><?= gmdate("Y-m-d", $user->date_of_birth) ?></p>
                                <img src="/templates/A5/img/icons/location.svg" alt=""><p class="person-data__leave"><?= $user->country_of_birth ?></p>
                            </div>
                        </div>
                        <div class="person-exp">
                            <div class="person-exp__quant"></div>
                        </div>
                    </div>
                </figcaption>
            </figure>
            <div class="template-container">
                <section class="contact-details free-sections">
                    <h2 class="free-sections__title">Contact details</h2>
                    <div class="contact-wrap">
                        <div class="contact-phone">
                            <p class="link-blue contact-phone__item"></p>
                            <p href="" class="link-blue"></p>
                        </div>
                        <div class="contact-addr">
                            <p class="link-blue"></p>
                            <p class="contact-addr__address"></p>
                        </div>
                    </div>
                </section>
                <section class="sum-experience free-sections">
                    <h2 class="free-sections__title">Summary of experience</h2>
                    <p class="free-sections__descr"></p>
                </section>
                <section class="skills-free free-sections">
                    <h2 class="free-sections__title">Skills:</h2>

                    <?php $skills = explode(',',$user->skills);
                    foreach ($skills as $skill):
                        if(!empty($skill)):?>
                            <li class="premium-list__item"><span><?= $skill ?></span></li>
                        <?php endif;
                    endforeach; ?>

                </section>
                <section class="experience-free free-sections">
                    <h2 class="free-sections__title">Experince</h2>

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
                <section class="education-free free-sections">
                    <h2 class="free-sections__title">Education</h2>

                    <?php foreach ($user->education as $education) : ?>
                        <p class="free-sections__descr"><?= $education->school_name ?></p>
                        <p class="free-sections__company"><?= $education->name ?></p>
                    <?php endforeach; ?>

                </section>
            </div>
            <section class="free-certificate-download free-download">
                <a href="<?= $user->certificate[0]->path ?>" class="link-blue"><?= $user->certificate[0]->name.'.'.$user->certificate[0]->mime_type?></a>
                <p class="free-download__code"><?= $education->license_number ?></p>
                <p class="free-download__date"><?= $education->from_month .' '. $education->from_year .'-'. $education->to_month .' '. $education->to_year?> </p>
            </section>
            <div class="template-container">
                <section class="interests-free free-sections">
                    <h2 class="free-sections__title">Interests</h2>

                    <?php $interests = explode(',',$user->interests);
                    foreach ($interests as $interest): ?>
                        <?php if(!empty($interest)):?>
                            <li class="premium-list__item"><span><?= $interest ?></span></li>
                        <?
                        endif;
                    endforeach;
                    ?>

                </section>
                <section class="recommendations-free free-sections">
                    <h2 class="free-sections__title">Recomendation</h2>
                </section>
            </div>

            <div class="created-logo">
                <p class="created-logo__descr">Created by</p>
                <img src="/templates/A5/img/icons/logo.svg" alt="logo">
                <a href="" class="link-blue">Build your career</a>
            </div>
        </section>
        <div class="copyright">© Copyright Protection Dropcv.io</div>
    </div>
</main>
<script src="/template/A5/js/app.js"></script>
</body>
