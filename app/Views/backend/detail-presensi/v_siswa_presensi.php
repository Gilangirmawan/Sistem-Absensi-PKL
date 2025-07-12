<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="card card-primary card-outline" style="min-height: 600px; width: 100%;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar Siswa</h3>
    </div>

    <div class="card-body">
        <!-- Filter kelas -->
        <form action="<?= base_url('Admin/presensiSiswa') ?>" method="get" class="form-inline mb-3">
            <label class="mr-2 font-weight-bold">Kelas:</label>
            <select name="kelas" class="form-control form-control-sm mr-2" onchange="this.form.submit()" style="width: 150px;">
                <option value="">-- Semua Kelas --</option>
                <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k['id_kelas'] ?>" <?= $filterKelas == $k['id_kelas'] ? 'selected' : '' ?>>
                        <?= esc($k['kelas']) ?>
                    </option>
                <?php endforeach ?>
            </select>
        </form>

        <!-- Tabel siswa -->
        <table class="table table-bordered table-striped" id="tabelSiswa" style="width: 100%;">
            <thead>
                <tr class="bg-primary text-white text-center">
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">NIS</th>
                    <th>Nama Siswa</th>
                    <th style="width: 20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($siswa)): ?>
                    <?php $no = 1; foreach ($siswa as $s): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= esc($s['nis']) ?></td>
                            <td><?= esc($s['nama_siswa']) ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('Admin/detailPresensi/' . $s['id_siswa']) ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-calendar-alt"></i> Lihat Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">Tidak ada data siswa.</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tabelSiswa').DataTable({
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ditemukan data.",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(difilter dari total _MAX_ data)",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>
