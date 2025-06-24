<div class="card card-primary card-outline" style="min-height: 85vh; display: flex; flex-direction: column;">
    <div class="card-header">
        <h3 class="card-title">Formulir Tambah Siswa Baru</h3>
    </div>

    <?php
    $validation = \Config\Services::validation();
    if ($validation->getErrors()) : ?>
        <div class="alert alert-danger m-3">
            <h5><i class="icon fas fa-ban"></i> Terjadi Kesalahan</h5>
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <?= form_open_multipart('Admin/prosesTambahSiswa') ?>
    <?= csrf_field() ?>

    <div class="card-body flex-grow-1" style="overflow-y: auto; max-height: calc(100vh - 240px);">
        <div class="container-fluid">
            <div class="row">
                <!-- NIS -->
                <div class="col-md-6 mb-3">
                    <label for="nis"><b>NIS</b></label>
                    <input type="text" class="form-control" name="nis" id="nis" placeholder="Masukkan NIS" value="<?= old('nis') ?>" required maxlength="20">
                </div>

                <!-- Nama Siswa -->
                <div class="col-md-6 mb-3">
                    <label for="nama_siswa"><b>Nama Siswa</b></label>
                    <input type="text" class="form-control" name="nama_siswa" id="nama_siswa" placeholder="Masukkan Nama Siswa" value="<?= old('nama_siswa') ?>" required>
                </div>

                <!-- Username -->
                <div class="col-md-6 mb-3">
                    <label for="username"><b>Username</b></label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan Username" value="<?= old('username') ?>" required>
                </div>

                <!-- Kelas -->
                <div class="col-md-6 mb-3">
                    <label for="id_kelas"><b>Kelas</b></label>
                    <select name="id_kelas" id="id_kelas" class="form-control" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach ($kelas as $k): ?>
                            <option value="<?= $k['id_kelas'] ?>" <?= old('id_kelas') == $k['id_kelas'] ? 'selected' : '' ?>>
                                <?= $k['kelas'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <!-- Password -->
                <div class="col-md-6 mb-3">
                    <label for="password"><b>Password</b></label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password" required>
                </div>

                <!-- Foto -->
                <div class="col-md-6 mb-3">
                    <label for="foto_siswa"><b>Unggah Foto (opsional)</b></label>
                    <input type="file" name="foto_siswa" id="foto_siswa" class="form-control-file" accept=".jpg,.jpeg,.png">
                    <small class="form-text text-muted">Ukuran maksimal 1MB. Format: JPG, JPEG, PNG.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer text-right bg-light">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan
        </button>
        <a href="<?= base_url('Admin/siswa') ?>" class="btn btn-danger">
            <i class="fas fa-arrow-left"></i> Batal
        </a>
    </div>
 
    <?= form_close() ?>
</div>
