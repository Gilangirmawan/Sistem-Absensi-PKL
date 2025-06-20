<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="<?= base_url('Home') ?>" class="headerButton goBack">
            <i class="fas fa-arrow-left fa-2x"></i>
        </a>
    </div>
    <div class="pageTitle"><?= esc($judul) ?></div>
    <div class="right"></div>
</div>
<!-- * App Header -->

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show mt-2 mx-3" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show mt-2 mx-3" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card card-primary card-outline mb-4 mt-2">

    <form action="<?= base_url('Home/updateFoto') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="card-body">
            <!-- Foto Profil -->
            <div class="mb-3 mt-5 text-center">
                <img src="<?= base_url('uploads/' . esc($siswa['foto_siswa'])) ?>" class="rounded-circle" width="120" alt="Foto Profil">
            </div>

            <!-- Nama -->
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" value="<?= esc($siswa['nama_siswa']) ?>" readonly>
            </div>

            <!-- NIS -->
            <div class="mb-3">
                <label class="form-label">NIS</label>
                <input type="text" class="form-control" value="<?= esc($siswa['nis']) ?>" readonly>
            </div>

            <!-- Kelas -->
            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" class="form-control" value="<?= esc($siswa['kelas']) ?>" readonly>
            </div>

            <!-- Upload Foto -->
            <div class="mb-1">
                <label class="form-label">Upload Foto Profil Baru</label>
                <input type="file" class="form-control" name="foto_siswa" accept="image/*" required>
            </div>
        </div>

        <div class="card-footer text-end pb-4 mb-3">
            <button type="submit" class="btn btn-primary">Simpan Foto</button>
        </div>
    </form>
</div>

