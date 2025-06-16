<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="<?= base_url('Home') ?>" class="headerButton goBack">
            <i class="fas fa-arrow-left fa-2x"></i>
        </a>
    </div>
    <div class="pageTitle"><?= $judul ?></div>
    <div class="right"></div>
</div>
<!-- * App Header -->

<div class="row" style="margin-top: 100px;">
    <div class="col text-center">
        <i class="fas fa-check-circle fa-5x text-success"></i>
        <h3 class="mt-3">Anda sudah melakukan presensi masuk hari ini.</h3>
        <a href="<?= base_url('Home') ?>" class="btn btn-primary mt-4">Kembali ke Beranda</a>
    </div>
</div>
