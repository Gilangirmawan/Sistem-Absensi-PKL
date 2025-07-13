<div class="card card-primary card-outline mt-3" style="min-height:600px; width: 100%;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Rekap Presensi Siswa</h3>
    </div>
    <div class="card-body">

        <!-- Form Filter -->
        <form method="get" action="<?= base_url('Admin/rekapPresensi') ?>" class="form-inline mb-3">
            <label for="kelas" class="mr-2">Kelas:</label>
            <select name="kelas" id="kelas" class="form-control mr-3" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k['id_kelas'] ?>" <?= ($filterKelas == $k['id_kelas']) ? 'selected' : '' ?>>
                        <?= $k['kelas'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="tanggal_akhir" class="mr-2">Tanggal Akhir:</label>
            <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="<?= esc($tanggalAkhir) ?>" class="form-control mr-3" required>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Filter
            </button>
        </form>

        <?php if (!empty($rekap)): ?>

            <?php if (!empty($filterKelas) && !empty($tanggalAkhir)): ?>
    <a href="<?= base_url('Admin/exportRekapXLSX?kelas=' . $filterKelas . '&tanggal_akhir=' . $tanggalAkhir) ?>" class="btn btn-success mb-3">
    <i class="fas fa-file-excel"></i> Export XLSX
    </a>

        <?php endif; ?>


            <!-- Tabel Rekap -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Hadir</th>
                            <th>Izin/Sakit</th>
                            <th>Alfa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($rekap as $r): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($r['nis']) ?></td>
                                <td><?= esc($r['nama']) ?></td>
                                <td><?= esc($r['kelas']) ?></td>
                                <td><?= $r['hadir'] ?></td>
                                <td><?= $r['izin'] ?></td>
                                <td><?= $r['alfa'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>
            <div class="alert alert-info mt-4">
                Silakan pilih kelas dan tanggal akhir untuk melihat rekap presensi.
            </div>
        <?php endif; ?>

    </div>
</div>
