<div class="card card-primary card-outline" style="min-height: 600px;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Detail Presensi: <?= esc($siswa['nama_siswa']) ?> (<?= esc($siswa['nis']) ?>)</h3>
        <a href="<?= base_url('Admin/presensiSiswa?kelas=' . $siswa['id_kelas']) ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover" id="tabelDetailPresensi">
            <thead class="bg-primary text-white text-center">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Hari</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($presensi as $p): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= date('d-m-Y', strtotime($p['tanggal'])) ?></td>
                    <td><?= date('l', strtotime($p['tanggal'])) ?></td>
                    <td class="text-center"><?= $p['jam_in'] ?? '-' ?></td>
                    <td class="text-center"><?= $p['jam_out'] ?? '-' ?></td>
                    <td class="text-center">
                        <?php
                        switch ($p['keterangan']) {
                            case 1: echo '<span class="badge badge-success">Hadir</span>'; break;
                            case 2: echo '<span class="badge badge-warning">Izin/Sakit</span>'; break;
                            default: echo '<span class="badge badge-danger">Alfa</span>'; break;
                        }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php if ($p['keterangan'] == 0): ?>
                            <form action="<?= base_url('Admin/updateKeterangan') ?>" method="post" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="id_siswa" value="<?= $siswa['id_siswa'] ?>">
                                <input type="hidden" name="tgl_presensi" value="<?= $p['tanggal'] ?>">
                                <select name="keterangan" class="form-control form-control-sm d-inline" style="width: auto; display: inline-block;" required>
                                    <option value="">Ubah ke...</option>
                                    <option value="2">Izin/Sakit</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </form>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
