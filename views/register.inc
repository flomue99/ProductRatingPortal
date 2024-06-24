<?php $render('partial/header', $data); ?>
<?php $beginForm('User', 'Register', method: 'post'); ?>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card register-card">
            <div class="card-body">
                <h1 class="card-title text-center">Register</h1>
                <form>
                    <div class="mb-3">
                        <label for="userName" class="form-label">Username</label>
                        <input type="text" class="form-control" id="userName" name="un" placeholder="Enter username"
                               value="<?php $htmlOut($data['userName']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="pwd"
                               placeholder="Enter password">
                    </div>
                    <div class="mb-3">
                        <label for="repeatPassword" class="form-label">Repeat Password</label>
                        <input type="password" class="form-control" id="repeatPassword" name="rPwd"
                               placeholder="Please repeat password">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Register</button>
                        <p class="text-center pt-2">Already have an Account?<br>
                            <?php $link('Login', 'User', 'LogIn', cssClass: ''); ?>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $endForm(); ?>

<?php $render('partial/footer', $data); ?>