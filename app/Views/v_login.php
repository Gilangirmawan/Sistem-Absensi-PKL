<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>E-Absensi | Login</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="stylesheet" href="<?= base_url('front') ?>/assets/css/inc/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('front') ?>/assets/css/inc/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="<?= base_url('front') ?>/assets/css/inc/owl-carousel/owl.theme.default.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:400,500,700&display=swap" />
    <link rel="stylesheet" href="<?= base_url('front') ?>/assets/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url('front') ?>/assets/css/style.css" />

</head>

 <style>
        body {
            background: linear-gradient(135deg,rgb(60, 115, 198), #2980b9);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 10px 40px;
            width: 100%;
            max-width: 500px; /* Diperbesar di desktop */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .login-card img.form-image {
            width: 120px;
            margin-bottom: 20px;
        }

        .login-card h1 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .login-card h4 {
            font-size: 0.95rem;
            color: #777;
            margin-bottom: 25px;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
            text-align: left;
        }

        .form-control {
            border-radius: 50px;
            padding-left: 45px;
            height: 45px;
            font-size: 0.9rem;
        }

        .form-group .fa {
            position: absolute;
            left: 15px;
            top: 13px;
            color: #aaa;
        }

        .form-button-group {
            margin-top: 20px;
        }

        .form-button-group button {
            border-radius: 50px;
            width: 100%;
            height: 45px;
            font-weight: 500;
            background-color: #4d9eff;
            color: white;
            border: none;
            transition: 0.3s ease-in-out;
        }

        .form-button-group button:hover {
            background-color: #347ddc;
        }

        .form-links {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            margin-bottom: 10px;
        }

        .text-danger {
            font-size: 0.8rem;
            text-align: left;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 30px 20px;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Capsule -->
    <div id="appCapsule" class="pt-0">
        <div class="login-card">

            <img src="<?= base_url('login.png') ?>" alt="Login Image" class="form-image">

            <h1>E-Absensi</h1>
            <h4>Silahkan Login Terlebih Dahulu.</h4>

            <!-- Pesan Error -->
            <?php
            $errors = validation_errors();
            if (session()->get('pesan')) {
                echo '<div class="alert alert-danger mt-3">';
                echo session()->get('pesan');
                echo '</div>';
            }
            ?>

            <!-- Form Login -->
            <?php echo form_open('Auth/cekLoginSiswa') ?>

                <div class="form-group">
                    <i class="fa fa-user"></i>
                    <input name="username" class="form-control" placeholder="Username">
                    <p class="text text-danger"><?= isset($errors['username']) ? validation_show_error('username') : '' ?></p>
                </div>

                <div class="form-group">
                    <i class="fa fa-lock"></i>
                    <input name="password" type="password" class="form-control" placeholder="Password">
                    <p class="text text-danger"><?= isset($errors['password']) ? validation_show_error('password') : '' ?></p>
                </div>

                <div class="form-links">
                    <a href="page-register.html">Register Now</a>
                    <a href="page-forgot-password.html" class="text-muted">Forgot Password?</a>
                </div>

                <div class="form-group form-button-group">
                    <button type="submit">LOGIN</button>
                </div>

            <?php echo form_close() ?>
        </div>
    </div>
    <!-- * App Capsule -->

    <!-- JS tetap -->
    <script src="<?= base_url('front') ?>/assets/js/lib/jquery-3.4.1.min.js"></script>
    <script src="<?= base_url('front') ?>/assets/js/lib/popper.min.js"></script>
    <script src="<?= base_url('front') ?>/assets/js/lib/bootstrap.min.js"></script>
    <script src="<?= base_url('front') ?>/assets/js/plugins/owl-carousel/owl.carousel.min.js"></script>
    <script src="<?= base_url('front') ?>/assets/js/plugins/jquery-circle-progress/circle-progress.min.js"></script>
    <script src="<?= base_url('front') ?>/assets/js/base.js"></script>

</body>


</html>