<?php $validation = \Config\Services::validation(); ?>

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="card card-primary card-outline" style="min-height: 600px; width: 100%;">
    <div class="card-header">
        <h1 class="card-title text">Data Kelas</h1>
    </div>

    <div class="card-body">
        <!-- Tombol tambah di dalam card-body dan rata kanan -->
        <div class="mb-3 d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahKelas">
                <i class="fas fa-plus"></i> Tambah Kelas
            </button>
        </div>

        <table class="table table-bordered table-striped" id="tabelKelas">
            <thead>
                <tr class="bg-primary text-white text-center">
                    <th>No</th>
                    <th>Nama Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($kelas as $k): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= $k['kelas'] ?></td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $k['id_kelas'] ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?= $k['id_kelas'] ?>">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal<?= $k['id_kelas'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="<?= base_url('Admin/editKelas/' . $k['id_kelas']) ?>" method="post">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Edit Kelas</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="kelas">Nama Kelas</label>
                                            <input type="text" name="kelas" class="form-control" value="<?= $k['kelas'] ?>" required>
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
                    <div class="modal fade" id="deleteModal<?= $k['id_kelas'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="<?= base_url('Admin/hapusKelas/' . $k['id_kelas']) ?>" method="post">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title">Hapus Kelas</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Yakin ingin menghapus kelas <strong><?= $k['kelas'] ?></strong>?</p>
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

<!-- Modal Tambah Kelas -->
<div class="modal fade" id="tambahKelas" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('Admin/tambahKelas') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Kelas</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kelas">Nama Kelas</label>
                        <input type="text" name="kelas" class="form-control <?= $validation?->hasError('kelas') ? 'is-invalid' : '' ?>" value="<?= old('kelas') ?>" required>
                        <?php if ($validation?->hasError('kelas')) : ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('kelas') ?>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tabelKelas').DataTable();

        <?php if (session()->has('validation')): ?>
            var myModal = new bootstrap.Modal(document.getElementById('tambahKelas'), { keyboard: false });
            myModal.show();
        <?php endif ?>
    });
</script>
