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

<div class="card card-primary card-outline mb-4 mt-2">
    <div class="card-header">
        <div class="card-title">Biodata Siswa</div>
    </div>
    <form action="<?= base_url('Home/updateProfil') ?>" method="post" enctype="multipart/form-data">
        <div class="card-body">
            <div class="mb-3 text-center">
                <img src="<?= base_url('foto/' . $siswa['foto_siswa']) ?>" class="rounded-circle" width="120" alt="Foto Profil">
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $siswa['nama_siswa'] ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" class="form-control" id="nis" name="nis" value="<?= $siswa['nis'] ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <input type="text" class="form-control" id="kelas" name="kelas" value="<?= $siswa['kelas'] ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Upload Foto Profil Baru</label>
                <input type="file" class="form-control" name="foto" id="foto">
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>