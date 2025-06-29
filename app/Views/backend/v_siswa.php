
<?php
$validation = \Config\Services::validation();
?>


<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="card card-primary card-outline" style="min-height: 600px; width: 100%;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="card-title text">Data Siswa</h1>
    </div>

    <div class="card-body">
        <!-- Filter dan Tombol -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <form action="<?= base_url('Admin/siswa') ?>" method="get" class="form-inline">
                <label class="mr-2 font-weight-bold">Kelas:</label>
                <select name="kelas" class="form-control form-control-sm mr-2" onchange="this.form.submit()" style="width: 150px;">
                    <option value="">Semua Kelas</option>
                    <?php foreach ($kelas as $k): ?>
                        <option value="<?= $k['id_kelas'] ?>" <?= $filterKelas == $k['id_kelas'] ? 'selected' : '' ?>>
                            <?= $k['kelas'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahSiswa"> <i class="fas fa-plus"></i>
            Tambah Siswa
            </button>
        </div>

        <!-- Tabel Siswa -->
        <table class="table table-bordered table-striped" id="tabelSiswa">
            <thead>
                <tr class="bg-primary text-white text-center">
                    <th>No</th>
                    <th>Foto</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Username</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($siswa as $s): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center">
                            <?php if ($s['foto_siswa']): ?>
                                <img src="<?= base_url('uploads/' . $s['foto_siswa']) ?>" width="50" class="img-thumbnail">
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $s['nis'] ?></td>
                        <td><?= $s['nama_siswa'] ?></td>
                        <td><?= $s['kelas'] ?></td>
                        <td><?= $s['username'] ?></td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $s['id_siswa'] ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?= $s['id_siswa'] ?>">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal<?= $s['id_siswa'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <form action="<?= base_url('Admin/editSiswa/' . $s['id_siswa']) ?>" method="post" enctype="multipart/form-data">
                                    <div class="modal-header bg-primary">
                                        <h5 class="modal-title text-white">Edit Siswa</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" name="nama_siswa" class="form-control" value="<?= $s['nama_siswa'] ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>NIS</label>
                                            <input type="text" name="nis" class="form-control" value="<?= $s['nis'] ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Kelas</label>
                                            <select name="id_kelas" class="form-control" required>
                                                <?php foreach ($kelas as $k): ?>
                                                    <option value="<?= $k['id_kelas'] ?>" <?= $s['id_kelas'] == $k['id_kelas'] ? 'selected' : '' ?>>
                                                        <?= $k['kelas'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" name="username" class="form-control" value="<?= $s['username'] ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Password (kosongkan jika tidak diganti)</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Foto Baru</label>
                                            <input type="file" name="foto_siswa" class="form-control-file">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Delete -->
                    <div class="modal fade" id="deleteModal<?= $s['id_siswa'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="<?= base_url('Admin/hapusSiswa/' . $s['id_siswa']) ?>" method="post">
                                    <div class="modal-header bg-danger">
                                        <h5 class="modal-title text-white">Hapus Siswa</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Yakin ingin menghapus <strong><?= $s['nama_siswa'] ?></strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-danger" type="submit">Hapus</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Siswa -->
<div class="modal fade" id="tambahSiswa" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                                        <h5 class="modal-title text-white">Tambah Siswa</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                    </div>
            <form action="<?= base_url('admin/tambahSiswa') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input type="text" name="nis" id="nis" class="form-control <?= $validation?->hasError('nis') ? 'is-invalid' : ''; ?>" value="<?= old('nis') ?>">
                                <?php if ($validation?->hasError('nis')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nis') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_siswa">Nama Siswa</label>
                                <input type="text" name="nama_siswa" id="nama_siswa" class="form-control <?= $validation?->hasError('nama_siswa') ? 'is-invalid' : ''; ?>" value="<?= old('nama_siswa') ?>">
                                <?php if ($validation?->hasError('nama_siswa')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama_siswa') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control <?= $validation?->hasError('username') ? 'is-invalid' : ''; ?>" value="<?= old('username') ?>">
                                <?php if ($validation?->hasError('username')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('username') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control <?= $validation?->hasError('password') ? 'is-invalid' : ''; ?>">
                                <?php if ($validation?->hasError('password')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('password') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                     <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_kelas">Kelas</label>
                                <select name="id_kelas" id="id_kelas" class="form-control <?= $validation?->hasError('id_kelas') ? 'is-invalid' : ''; ?>">
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php foreach ($kelas as $k): ?>
                                        <option value="<?= $k['id_kelas'] ?>" <?= old('id_kelas') == $k['id_kelas'] ? 'selected' : '' ?>><?= $k['kelas'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if ($validation?->hasError('id_kelas')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('id_kelas') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="foto_siswa">Foto Siswa</label>
                                <input type="file" name="foto_siswa" id="foto_siswa" class="form-control <?= $validation?->hasError('foto_siswa') ? 'is-invalid' : ''; ?>">
                                <?php if ($validation?->hasError('foto_siswa')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('foto_siswa') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button> -->
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
  // Cek jika session validation ada (artinya terjadi error)
  <?php if(session()->has('validation')): ?>
    // Buka modal tambah secara otomatis
    var myModal = new bootstrap.Modal(document.getElementById('tambahSiswa'), {
      keyboard: false
    });
    myModal.show();
  <?php endif; ?>
});
</script>

