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
                    <h1 class="pro-person-data__title"></h1>
                    <h4 class="pro-person-data__descr"></h4>
                    <span class="pro-person-data__years">
                        <p class="years-old"><label></label></p>
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
                                <p class="premium-phones__item"></p>
                            </span>
                            <span class="free-pls-sections__phones">
                                <img src="/templates/A35/img/icons/msg.svg" alt=""><p class="premium-sections__email"></p>
                            </span>
                            <span class="free-pls-sections__phones">
                                <img src="/templates/A35/img/icons/planet.svg" alt=""><p class="premium-sections__addr"></p>
                            </span>
                        </section>
                        <section class="premium-sections">
                            <h2 class="premium-sections__title">Skills</h2>
                            <div class="preview-wrap-plus">
                                <ul class="premium-list">
                                    <li class="premium-list__item"><span><?= $skill ?></span></li>
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


                                <p class="premium-content-section__company"></p>
                                <p class="premium-content-section__years"></p>
                                <div class="preview-wrap-prof">
                                    <ul class="premium-content-list">
                                        <li class="premium-content-list__item"></li>
                                    </ul>
                                    <p class="preview-par"></p>
                                </div>

                        </section>
                        <section class="premium-content-section">
                            <h2 class="premium-content-section__title">Education</h2>
                            <hr>

                                <p class="premium-content-section__education"></p>
                                <p class="premium-content-section__company"></p>
                                <section class="free-certificate-download free-download">
                                    <a href="" class="link-blue"></a>
                                    <p class="free-download__code"></p>
                                    <p class="free-download__date"></p>
                                </section>
                        </section>
                        <section class="premium-content-section">
                            <h2 class="premium-content-section__title">interests</h2>
                            <hr>
                            <div class="preview-wrap-prof">
                                <ul class="premium-content-list">
                                    <li class="premium-list__item"><span></span></li>
                                </ul>
                                <p class="preview-par"></p>
                            </div>
                        </section>
                        <section class="premium-content-section">
                            <h2 class="premium-content-section__title">Recommendations</h2>
                            <hr>
                            <section class="free-recommendation-download free-download">
                                <a href="" class="link-blue"></a>
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