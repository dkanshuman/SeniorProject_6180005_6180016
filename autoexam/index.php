<?php  
    $title = "Home";
    session_start();

    require_once './templates/main-header.php'; 
?>

<section id="hero-section">
    <div class="container">

        <div class="hero-content">
            <h2 class="hero-subtitle">
                Fast, easy, reliable
                solution
            </h2>
            <h1 class="hero-title">Get question papers on the go!</h1>

            <p class="hero-text">All of us go through the education system, but there is no hub for preparations
                from both past paper and textbooks. Auto-Exam Generator does that for You.</p>

            <ul class="hero-list">
                <li><i class="fa-solid fa-circle-check"></i> <span>Fast</span></li>
                <li><i class="fa-solid fa-circle-check"></i> <span>Easy</span></li>
                <li><i class="fa-solid fa-circle-check"></i> <span>Realiable</span></li>
            </ul>
            <a href="./signup.php" class="btn blue-btn">Join Now</a>

        </div>
        <div class="hero-right">
            <div class="hero-img-block">
                <img src="./assets/images/banner2.png" alt="">

            </div>
        </div>
    </div>

</section>

<section id="about">
    <div class="container">

        <div class="about-left">
            <img src="./assets/images/about-2.jpg" alt="">
        </div>

        <div class="about-right">
            <span class="subtitle">WHO WE ARE</span>
            <h2 class="heading">Join the <span>
                    <?= $sitename; ?>
                </span> Now.</h2>
            <p>The purpose of this project is to build a Web Application which can randomize and generate
                examinations or manually generate examinations as well with minimal parameters.</p>
            <a href="./signup.php" class="btn blue-btn">Join Now</a>

        </div>

    </div>

</section>


<section id="testimonial-content">
    <div class="container">
        <p class="quotes"><i class="fa-solid fa-quote-left"></i></p>
        <p class="text">
            <?= $sitename; ?> is here to save your time. It helps you to generate homework tests and exams.
            It's
            easy
            to create
            exams,
            easy to correct. Clear for students. It is good that the students
            can get a response directly in self-correcting tests.
        </p>
        <p class="creator">
            <?= $sitename; ?>
            <span class="creator-heading">The Creators</span>
        </p>
    </div>

</section>


<section id="content">
    <div class="container">
        <h1 class="heading">WHAT CAN YOU DO</h1>
        <p class="subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex, repudiandae!</p>

        <div class="work-content">
            <div class="work-block">
                <img src="./assets/images/img1.jpg" alt="">
                <h2 class="work-title">EVERYTHING YOU NEED</h2>
                <p>Create comprehensive exams with powerful tools that are easy to use and quick to apply.</p>
            </div>
            <div class="work-block">
                <img src="./assets/images/img2.jpg" alt="">
                <h2 class="work-title">MAKE IT SIMPLE</h2>
                <p>Conduct exams with confidence and control thanks to our intuitive software that simplifies
                    technical complexity.</p>
            </div>
            <div class="work-block">
                <img src="./assets/images/img3.jpg" alt="">
                <h2 class="work-title">EMPOWER EVERY STUDENT</h2>
                <p>Customize exams to empower each student’s individual needs and let their knowledge shine.</p>
            </div>
        </div>

    </div>
</section>

<?php 
    require_once './templates/main-footer.php';
?>