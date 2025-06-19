<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="theme-color" content="#000000" />
    <title><?= $judul ?></title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit" />
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="<?= base_url('front') ?>/assets/img/favicon.png" sizes="32x32" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png" />
    <link rel="stylesheet" href="<?= base_url('front') ?>/assets/css/inc/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('front') ?>/assets/css/inc/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="<?= base_url('front') ?>/assets/css/inc/owl-carousel/owl.theme.default.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:400,500,700&display=swap" />
    <link rel="stylesheet" href="<?= base_url('front') ?>/assets/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url('front') ?>/assets/css/style.css" />
    <!--webcam-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.js" integrity="sha512-AQMSn1qO6KN85GOfvH6BWJk46LhlvepblftLHzAv1cdIyTWPBKHX+r+NOXVVw6+XQpeW4LJk/GTmoP48FLvblQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--leaflet-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body style="background-color: #e9ecef">
    
    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <?php
        if ($page) {
            echo view($page);
        }

        ?>
    </div>
    <!-- * App Capsule -->

    <!-- App Bottom Menu -->
    <div class="appBottomMenu">
        <a href="<?= base_url('Home/index') ?>" class="item <?= $menu == 'home' ? 'active' : '' ?>">
            <div class="col">
                <i class="fas fa-home fa-3x <?= $menu == 'home' ?  '' : 'text-dark' ?>"></i>
                <strong>Home</strong>
            </div>
        </a>
        <a href="<?= base_url('Home/kalender') ?>" class="item <?= $menu == 'kalender' ? 'active' : '' ?>">
            <div class="col">
                <i class="fas fa-calendar-alt fa-3x <?= $menu == 'kalender' ?  '' : 'text-dark' ?>"></i>
                <strong>Calendar</strong>
            </div>
        </a>
        <a href="<?= base_url('Presensi') ?>" class="item">
            <div class="col">
                <div class="action-button large">
                    <i class="fas fa-camera text-white fa-3x <?= $menu == 'presensi' ?  'text-danger' : '' ?>"></i>
                </div>
            </div>
        </a>
        <a href="#" class="item">
            <div class="col">
                <i class="fas fa-file-alt fa-3x text-dark"></i>
                <strong>Docs</strong>
            </div>
        </a>
        <a href="<?= base_url('Home/profile') ?>" class="item <?= $menu == 'profile' ? 'active' : '' ?>">
            <div class="col">
                <i class="fas fa-user-tie fa-3x <?= $menu == 'profile' ? '' : 'text-dark' ?>"></i>
                <strong>Profile</strong>
            </div>
        </a>
    </div>
    <!-- * App Bottom Menu -->

    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="<?= base_url('front') ?>/assets/js/lib/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap-->
    <script src="<?= base_url('front') ?>/assets/js/lib/popper.min.js"></script>
    <script src="<?= base_url('front') ?>/assets/js/lib/bootstrap.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <!-- Owl Carousel -->
    <script src="<?= base_url('front') ?>/assets/js/plugins/owl-carousel/owl.carousel.min.js"></script>
    <!-- jQuery Circle Progress -->
    <script src="<?= base_url('front') ?>/assets/js/plugins/jquery-circle-progress/circle-progress.min.js"></script>

    <!-- Base Js File -->
    <script src="<?= base_url('front') ?>/assets/js/base.js"></script>

</body>

</html>