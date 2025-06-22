<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Formulir Tambah Siswa Baru</h3>
    </div>
    <div class="card-body">
        
        <?php
        // Menampilkan pesan error validasi
        $validation = \Config\Services::validation();
        if ($validation->getErrors()) : ?>
            <div class="alert alert-danger">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>

        <?= form_open_multipart('Admin/Siswa') ?>

            <?= csrf_field() ?>

            <div class="form-group">
                <label for="nis"><b>NIS</b></label>
                <input class="form-control" type="text" name="nis" id="nis" placeholder="Masukkan NIS" value="<?= old('nis') ?>">
            </div>

            <div class="form-group">
                <label for="nama_siswa"><b>Nama Siswa</b></label>
                <input class="form-control" type="text" name="nama_siswa" id="nama_siswa" placeholder="Masukkan Nama Siswa" value="<?= old('nama_siswa') ?>">
            </div>

            <div class="form-group">
                <label for="username"><b>Username</b></label>
                <input class="form-control" type="text" name="username" id="username" placeholder="Masukkan Username" value="<?= old('username') ?>">
            </div>

            <div class="form-group">
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

            <div class="form-group">
                <label for="password"><b>Password</b></label>
                <input class="form-control" type="password" name="password" id="password" placeholder="Masukkan Password">
                <small class="form-text text-muted">Password akan di-enkripsi. Biarkan kosong jika tidak ingin mengubah.</small>
            </div>

            <div class="form-group">
                <label for="foto_siswa"><b>Unggah Foto</b></label>
                <input type="file" name="foto_siswa" id="foto_siswa" class="form-control-file">
                <small class="form-text text-muted">Ukuran maksimal 1MB. Format: jpg, jpeg, png.</small>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('admin/siswa') ?>" class="btn btn-secondary">Batal</a>
            </div>
            
        <?= form_close() ?>

    </div>
</div>