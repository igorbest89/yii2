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
                        <h1 class="professional-title"></h1>
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
                                   <img src="/templates/A55/img/icons/phone.svg" alt=""><p class="premium-phones__item"></p>
                                </span>
                                <span class="premium-phones">
                                    <img src="/templates/A55/img/icons/msg.svg" alt=""><p class="prof-sections__email"></p>
                                </span>
                                <span class="premium-phones">
                                    <img src="/templates/A55/img/icons/planet.svg" alt=""><p class="prof-sections__addr"></p>
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
                                                <li class="premium-list__item"><span></span></li>
                                        <p class="preview-parag"></p>
                                    </div>
                                </section>
                                <section class="premium-sections prof-third-interests">
                                    <h2 class="premium-sections__title">interests</h2>
                                    <div class="preview-wrap-plus">
                                        <ul class="premium-list">
                                            <li class="premium-list__item"><span><?= $interest ?></span></li>
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
                                        <p class="premium-content-section__company"></p>
                                        <p class="premium-content-section__years"></p>
                                        <div class="preview-wrap-plus">
                                            <ul class="premium-content-list">
                                                <li class="premium-content-list__item"></li>
                                            </ul>
                                            <p class="preview-parag-second"></p>
                                        </div>
                                </section>
                                <section class="premium-content-section">
                                    <h2 class="premium-content-section__title">Education</h2>

                                        <p class="premium-content-section__education"></p>
                                        <p class="premium-content-section__company"></p>
                                        <section class="free-certificate-download free-download">
                                            <a href="" class="link-blue"></a>
                                            <p class="free-download__code"></p>
                                            <p class="free-download__date"></p>
                                        </section>
                                </section>
                                <section class="premium-content-section prof-third-interests-mobile">
                                    <h2 class="premium-content-section__title">Interests</h2>
                                    <p class="premium-content-section__education">Information Technology, Software Development</p>
                                </section>
                                <section class="premium-content-section">
                                    <h2 class="premium-content-section__title">Recommendations</h2>
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

