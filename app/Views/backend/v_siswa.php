<div class="card card-primary card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Data Siswa</h3>

        <!-- Tombol Tambah Siswa -->
        <a href="<?= base_url('Admin/tambahSiswa') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Siswa
        </a>
    </div>
    <div class="card-body">
        <!-- Filter Kelas -->
        <form method="get" action="<?= base_url('Admin/siswa') ?>" class="mb-3">
            <div class="form-group row">
                <label for="kelas" class="col-sm-2 col-form-label">Filter Kelas</label>
                <div class="col-sm-6">
                    <select name="kelas" id="kelas" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Kelas --</option>
                        <?php foreach ($kelas as $k): ?>
                            <option value="<?= $k['id_kelas'] ?>" <?= $filterKelas == $k['id_kelas'] ? 'selected' : '' ?>>
                                <?= $k['kelas'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
        </form>

           <!-- Tabel Siswa -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover" style="min-width: 900px;">
            <thead class="thead-light">
                <tr>
                    <th width="70">Foto</th>
                    <th width="100">NIS</th>
                    <th>Nama</th>
                    <th width="120">Kelas</th>
                    <th>Username</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($siswa as $row): ?>
                    <tr>
                        <td>
                            <?php if ($row['foto_siswa']): ?>
                                <img src="<?= base_url('uploads/' . $row['foto_siswa']) ?>" alt="foto" width="40" height="40" class="img-circle">
                            <?php else: ?>
                                <span class="badge badge-secondary">Tidak Ada</span>
                            <?php endif ?>
                        </td>
                        <td><?= esc($row['nis']) ?></td>
                        <td><?= esc($row['nama_siswa']) ?></td>
                        <td><?= esc($row['kelas']) ?></td>
                        <td><?= esc($row['username']) ?></td>
                        <td>
                            <!-- Tombol Edit -->
                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEdit<?= $row['id_siswa'] ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <!-- Tombol Hapus -->
                            <a href="<?= base_url('Admin/hapusSiswa/' . $row['id_siswa']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus siswa ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="modalEdit<?= $row['id_siswa'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel<?= $row['id_siswa'] ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form method="post" action="<?= base_url('Admin/editSiswa/' . $row['id_siswa']) ?>" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Siswa</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>NIS</label>
                                            <input type="text" name="nis" class="form-control" value="<?= esc($row['nis']) ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Siswa</label>
                                            <input type="text" name="nama_siswa" class="form-control" value="<?= esc($row['nama_siswa']) ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Kelas</label>
                                            <select name="id_kelas" class="form-control" required>
                                                <?php foreach ($kelas as $k): ?>
                                                    <option value="<?= $k['id_kelas'] ?>" <?= $row['id_kelas'] == $k['id_kelas'] ? 'selected' : '' ?>>
                                                        <?= $k['kelas'] ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" name="username" class="form-control" value="<?= esc($row['username']) ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Password (Kosongkan jika tidak diubah)</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Ganti Foto</label>
                                            <input type="file" name="foto_siswa" class="form-control" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Modal Edit -->
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>


                <!-- Modal Delete -->
                <div class="modal fade" id="modalHapus<?= $row['id_siswa'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel<?= $row['id_siswa'] ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalHapusLabel<?= $row['id_siswa'] ?>">Konfirmasi Hapus</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus data siswa:</p>
                                    <p><strong><?= esc($row['nama_siswa']) ?> (NIS: <?= esc($row['nis']) ?>)</strong>?</p>
                                    <p class="text-danger">Tindakan ini tidak dapat diurungkan.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <a href="<?= base_url('Admin/hapusSiswa/' . $row['id_siswa']) ?>" class="btn btn-danger">Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             </tbody>
        </table>
    </div>
</div>

