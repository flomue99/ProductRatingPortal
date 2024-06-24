<?php $render('partial/header', $data); ?>

    <div class="container text-center pt-5">
        <div class="fw-bold text-danger">
            Not Authorized <br>
            You have to be logged in to access this page
            <br>
            <br>
            Please
            <?php $link('Login', 'User', 'LogIn', cssClass: ''); ?>
            or
            <?php $link('Register', 'User', 'Register', cssClass: ''); ?>

        </div>
    </div>

<?php $render('partial/footer', $data); ?>