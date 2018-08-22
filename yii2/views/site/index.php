<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/A3/style.css">
    <link rel="stylesheet" href="/css/A3/responsive.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,900" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<header class="header-user header header-a3">
    <div class="logo-select-wrap">
            <span class="logo-wrap">
                <a href=""><img src="/templates/A3/img/logo.svg" alt="logo"></a>
            </span>

            <ul class="country_choice" name="country" id="country">
                <?php foreach ($flags as $flag): ?>
                    <li ><a href="/<?= $flag['languageRelation']->getAttributes()['language_id'] ?>" ><img src="/img/flags/<?= $flag->flag ?>" alt="flag"></a></li>
                <?php endforeach; ?>
            </ul>
    </div>
    <div class="upgrade-login-profile">
        <div class="header-links-wraper">
            <a href="" class="create-cv-link">CREATE YOUR CV</a>
            <a href="" class="create-cv-link">EMPLOYERS & RECRUITERS</a>
        </div>
        <a href="/login" class="login-btn button-simple">Login</a>
        <a href="/logout" class="login-btn button-simple">logout</a>
    </div>
</header>

<main class="main-create main">
    <div class="create-background">
        <div class="create-mask">
            <div class="container">
                <section class="registration title">
                    <h1 class="registration__title title__item">Create your cv</h1>
                    <p class="registration__chances">And rise up your chances to get a job. It´s FREE.</p>
                    <a href="" class="registration__create-cv-btn">Create Your Free CV</a>
                    <p class="registration__chances registration__three-easy-steps">3 easy steps. You can send, save and share your CV.</p>
                </section>
            </div>
            <section class="created-cvs-section">
                <div class="imgs-wrap">
                    <img src="img/A34.png" alt="CV">
                    <img src="img/A54.png" alt="CV">
                    <img src="img/A24.png" alt="CV">
                </div>
                <h3 class="created__num-created">120,579 CVs Created</h3>
            </section>
            <div class="container">
                <section class="section-cv-description">
                    <h4 class="section-cv-description__item">Beautiful and professional templates</h4>
                    <h4 class="section-cv-description__item">Save as PDF and print out</h4>
                    <h4 class="section-cv-description__item">Send CVs and Resumes directly to Employers & Recruiters</h4>
                </section>
            </div>
        </div>
    </div>
    <div class="testimonials-background">
        <div class="testimonials-mask">
            <div class="testimonials">
                <img src="img/icons/quote.svg" alt="quote" class="testimonials__quote-img">
                <h1 class="testimonials__text">We have developed Dropcv to offer professionals and job seekers a unique and simple way to send and share their CV with employers.</h1>
                <p class="testimonials__author">- Caleb, Founder of DropCV -</p>
            </div>
        </div>
    </div>
    <div class="text">
        <div class="container">
            <p class="text__item">
                DropCV is Nigeria's No 1 online professional CV builder and maker.
                No need for expensive CV writers. Get our professional CV for that job recruitment and interview today.
                We are the fastest and easiest way to build your professional CV in Nigeria.
                With DropCV, you can create your professional CV with our unique and beautiful CV templates in minutes, edit your CV as many times as possible and download your CV in PDF format.
                You can send your CV to employers through our secured email system and can also share your CV with employers, recruiters, families and friends, on Facebook, twitter and whatsapp through your short unique CV link. With your unique link, Employers and recruiters on any platform can view and download your CV at anytime and anywhere.
                DropCV is simple and easy to use. Sign up for Free Now and get the best CV templates in Nigeria.
            </p>
            <h4 class="text__title">Popular Content</h4>
            <div class="simple-links-wraper">
                <div class="simple-links-wrap">
                    <a href="" class="text__item">Free Online CV Builder and Resume Maker in Nigeria</a>
                    <a href="" href="" class="text__item">How to send my CV to Employers in Nigeria</a>
                    <a href="" class="text__item">Build Online Student CV for Internship in Nigeria</a>
                    <a href="" class="text__item">LinkedIn CV Builder in Nigeria</a>
                    <a href="" class="text__item">Sample Link</a>
                </div>
                <div class="simple-links-wrap">
                    <a href="" class="text__item">Sample Link</a>
                    <a href="" class="text__item">Sample Link</a>
                    <a href="" class="text__item">Sample Link</a>
                    <a href="" class="text__item">Sample Link</a>
                    <a href="" class="text__item">Sample Link</a>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="footer">

</footer>

<script src="js/app.js"></script>
</body>
</html>
