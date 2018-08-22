<?php

$q= 1;
//var_dump($user);
//var_dump($templateRelation);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,900" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <header class="header">

    </header>

    <main class="free-tmpl">
        <div class="share-dwnl create-cv">
            <ul class="create-list steps-registration">
                <li class="create-list__link steps-registration__link"><a href="" class="create-link steps-link">create cv</a></li>
                <li class="create-list__link steps-registration__link"><a href="" class="create-link steps-link">choose template</a></li>
                <li class="create-list__link steps-registration__link"><a href="" class="create-link steps-link active-link">share & download</a></li>
            </ul>
            <section class="choose-tmpl reg-step">
                <a href="/account" class="link-blue choose-back">Back</a>
                <p class="reg-step__item">STEP 4:  download & share</p>
            </section>
            <div class="btns-wrap">
                <button class="button-simple send">send as application</button>
                <button class="button-simple download">download as pdf</button>
                <button class="button-simple share">share</button>
            </div>
            <a href="" class="free-link link-blue">You use a free template. try professional!</a>
        </div>
        <section class="free-cv">
            <figure class="free-person">
                <img src="img/free-photo.png" alt="photo-person" class="free-photo circle">
                <figcaption class="data-descr">
                    <div class="person-data-name">
                        <div class="person-data">
                            <div class="h-wrap">
                                <h1 class="person-data__name"><?= $user->first_name . $user->last_name?></h1>
                            </div>
                            <p class="person-data__profession">Quality Assurance, Product Manager, Business Analyst</p>
                            <div class="person-data-wrap">
                                <p class="person-data__years"><label><?= gmdate("Y-m-d", $user->date_of_birth); ?></label> years old</p>
                                <p class="person-data__leave"><?= $user->country_of_birth ?></p>
                            </div>
                        </div>
                        <div class="person-exp">
                            <p class="person-exp__quant">10<small>years experience</small></p>
                        </div>    
                    </div>
                </figcaption>
            </figure>
            <div class="template-container">
                <section class="contact-details free-sections">
                    <h2 class="free-sections__title">Contact details</h2>
                    <div class="contact-wrap">
                        <div class="contact-phone">
                            <a href="" class="link-blue contact-phone__item"><?= $user->phone ?></a>
                            <a href="" class="link-blue">+ 2 (123) 234 - 34 - 23</a>
                        </div>
                        <div class="contact-addr">
                            <a href="" class="link-blue"><?= $user->email ?></a>
                            <p class="contact-addr__address"><?= $user->address ?></p>
                        </div>
                    </div>
                </section>
                <section class="sum-experience free-sections">
                    <h2 class="free-sections__title">Summary of experience</h2>
                    <p class="free-sections__descr">Product Manager and Curator. Curate digital design resources to be included in multipurpose design bundles, as well as managing products and liaising with designers. Other tasks include design work and website maintenance. Combined customer supplied documents with new InDesign content, and using data merges, Photoshop and Quark software, created the artwork, layout and print work for school print orders including diaries.</p>
                </section>
                <section class="skills-free free-sections">
                    <h2 class="free-sections__title">Skills:</h2>
                    <p class="free-sections__descr"><?= $user->skills ?></p>
                </section>
                <section class="experience-free free-sections">
                    <h2 class="free-sections__title">Experince</h2>
                <?php foreach ($user->exp as $experience) : ?>
                    <h4 class="free-sections__name"><?= $experience->job_title  ?></h4>
                    <p class="free-sections__company"><?= $experience->employer  .''.$experience->location ?></p>
                    <p class="free-sections__years"><?= $experience->from_year  .' '.  $experience->from_month   .'-'. $experience->to_month ?></p>
                    <ul class="list-exp">
                        <li class="list-exp__item"><?= $experience->achievements  ?> </li>
                    </ul>
                </section>
                 <?php endforeach; ?>
                <section class="education-free free-sections">
                    <h2 class="free-sections__title">Education</h2>
                <?php foreach ($user->education as $education): ?>
                        <p class="free-sections__descr"><?= $education->school_name ?></p>
                        <p class="free-sections__company"><?= $education->specialization ?></p>
                        <p class="free-sections__years"><?= $education->from_year .' '. $education->from_month .'-'. $education->to_year .' '. $education->to_month ?></p>
                    </section>
                </div>
                <section class="certificate-download free-download">
                    <a href="" class="link-blue"><?= $education->document_type ?></a>
                    <p class="free-download__code"><?= $education->license_number ?></p>
                    <p class="free-download__date"><?= $education->current_place  ?></p>
                </section>

                <?php endforeach; ?>
            <div class="template-container">
                <section class="interests-free free-sections">
                    <h2 class="free-sections__title">Interests</h2>
                    <p class="free-sections__descr"><?= $user->interests ?></p>
                </section>
                <section class="recommendations-free free-sections">

                </section>
            </div>
            <section class="recommendation-download free-download">
                <a href="" class="link-blue">Recommendation.pdf</a>
                <div class="recommendation-paragraphs">
                <span class="recommendation-person">
                    <p class="recommendation-person__name">Brian Jognson</p>
                    <p class="recommendation-person__descr">Business Analyst</p>
                </span>
                <span class="recommendation-person">
                    <p class="recommendation-person__name">Company Name</p>
                    <p class="recommendation-person__descr">Berlin, Germany</p>
                </span>
            </section>
        </section>
    </main>
    <div class="created-logo">
        <p class="created-logo__descr">Created by</p>
        <img src="img/icons/logo.svg" alt="logo">
        <a href="" class="link-blue">Build your career</a>
    </div>
    <script src="js/app.js"></script>
</body>
</html>
