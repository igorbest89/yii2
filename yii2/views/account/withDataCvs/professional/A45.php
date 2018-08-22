<?php /**
 * @var $user \app\models\UserProfile;
 */
$this->registerCssFile('/templates/A45/css/style.css');
$this->registerCssFile('/templates/A45/css/responsive.css'); ?>
<main class="main">
    <div class="professional-cv-template preview-prof-second">
        <button class="btn-close"><img src="/templates/A45/img/icons/close.svg" alt="close"></button>
        <div class="professional-sec-cv">
            <div class="professional-sec">
                <section class="prof-left-part">
                    <h1 class="prof-left-part__title"><?= $user->first_name . ' ' . $user->last_name ?></h1>
                    <h4 class="prof-left-part__descr"></h4>
                    <span class="preview-sec-wrap">
                                <img src="/templates/A45/img/icons/profile-wh.svg" alt="">
                                <p class="prof-left-part__years"></p>
                            </span>
                    <div class="contact-summary">
                        <section class="prof-sections section-contact-details">
                            <h2 class="prof-sections__title">CONTACT DETAILS</h2>
                            <span class="premium-phones">
                                        <img src="/templates/A45/img/icons/phone.svg" alt=""><p class="premium-phones__item"><?= $user->phone ?></p>
                                    </span>
                            <span class="premium-phones">
                                        <img src="/templates/A45/img/icons/msg.svg" alt=""><p class="prof-sections__email"><?= $user->email ?></p>
                                    </span>
                            <span class="premium-phones">
                                        <img src="/templates/A45/img/icons/planet.svg" alt=""><p class="prof-sections__addr"><?= $user->address ?></p>
                                    </span>
                        </section>
                        <section class="prof-sections section-summary-experience">
                            <h2 class="prof-sections__title">Summary of experience</h2>
                            <p class="prof-sections__descr"></p>
                        </section>
                    </div>
                    <section class="icon-year-exp">
                        <span class="icon-year-exp__years"><label></label><p class="prof-year-exp">Years Experience</p></span>
                        <img src="/templates/A45/img/pro-big.png" alt="PRO" class="icon-year-exp__image">
                    </section>
                </section>
                <img src="/templates/A45/img/pro-profile.png" alt="profile" class="prof-sec-foto">
            </div>
        </div>


        <div class="professional-cv-content premium-cv-content">
            <aside class="right-part">
                <div class="container-right-sidebar">
                    <?php if($user->skills !== null && !empty($user->skills)) : ?>
                    <section class="premium-sections">
                        <h2 class="premium-sections__title">Skills</h2>
                        <div class="preview-wrap-plus">
                            <ul class="premium-list">
                                <?php $skills = explode(',',$user->skills);
                                foreach ($skills as $skill):
                                    if(!empty($skill)): ?>
                                    <li class="premium-list__item"><span><?= $skill ?></span></li>
                                    <?php endif;
                                endforeach; ?>
                            </ul>
                            <p class="preview-parag"></p>
                        </div>
                    </section>
                    <?php endif; ?>
                    <section class="premium-sections">
                        <h2 class="premium-sections__title">interests</h2>
                        <div class="preview-wrap-plus">
                            <ul class="premium-list">
                                <?php $interests = explode(',',$user->interests);
                                foreach ($interests as $interest): ?>
                                    <?php if(!empty($interest)):?>
                                        <li class="premium-list__item"><span><?= $interest ?></span></li>
                                <?php
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
                    <section class="premium-content-section section-summary-exp">
                        <h2 class="premium-content-section__title">Summary of experience</h2>
                        <p class="premium-content-section__descr">Product Manager and Curator. Curate digital design resources to be included in multipurpose design bundles, as well as managing products and liaising with designers. Other tasks include design work and website maintenance. Combined customer supplied documents with new InDesign content, and using data merges, Photoshop and Quark software, created the artwork, layout and print work for school print orders including diaries.</p>
                    </section>
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
</main>
<?php $this->registerJsFile('/templates/A45/js/app.js'); ?>
