<?php
use CodeIgniter\I18n\Time;

$jumlahDataPerMinggu = 7; // 5 hari kerja + 2 weekend
$totalData = count($presensi);
$mingguSaatIni = (int) ($_GET['minggu'] ?? 1);

$startIndex = ($mingguSaatIni - 1) * $jumlahDataPerMinggu;
$endIndex = min($startIndex + $jumlahDataPerMinggu, $totalData);
?>

<div class="card card-primary card-outline" style="min-height: 600px; width: 100%;">
    <div class="card-header">
        <h3 class="card-title">Detail Presensi: <?= esc($siswa['nama_siswa']) ?> (<?= esc($siswa['nis']) ?>)</h3>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped" id="tabelDetailPresensi">
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
                <?php
                $no = $startIndex + 1;
                for ($i = $startIndex; $i < $endIndex; $i++):
                    $p = $presensi[$i];
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= date('d-m-Y', strtotime($p['tanggal'])) ?></td>
                    <td><?= Time::parse($p['tanggal'])->toLocalizedString('eeee') ?></td>
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
                <?php endfor; ?>
            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex justify-content-between align-items-center">
        <!-- Tombol Kembali -->
        <a href="<?= base_url('Admin/presensiSiswa?kelas=' . $siswa['id_kelas']) ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <!-- Navigasi Minggu -->
        <nav>
            <ul class="pagination pagination-sm mb-0">
                <?php
                $totalHalaman = ceil($totalData / $jumlahDataPerMinggu);
                for ($i = 1; $i <= $totalHalaman; $i++):
                ?>
                    <li class="page-item <?= $mingguSaatIni == $i ? 'active' : '' ?>">
                        <a class="page-link" href="<?= base_url('Admin/detailPresensi/' . $siswa['id_siswa'] . '?minggu=' . $i) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</div>
