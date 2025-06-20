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

<!-- Section utama -->
<div class="section" style="margin-top: 100px; margin-bottom: 100px;">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="card-title">Kalender Kehadiran</h5>
        </div>

        <div class="card-body d-flex justify-content-center">
            <div id="calendar" style="width: 80%; height:auto;"></div>
        </div>

        <!-- Keterangan warna -->
        <div class="card-footer">
            <small class="text-muted">
                <strong>Keterangan Warna:</strong><br>
                <span style="color: green;">●</span> Hadir |
                <span style="color: orange;">●</span> Izin/Sakit |
                <span style="color: red;">●</span> Alfa (Tidak Hadir)
            </small>
        </div>
    </div>
</div>

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>


<!-- Inisialisasi kalender -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let calendarEl = document.getElementById('calendar');

        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 'auto',
            events: <?= $events ?> // ini harus di-encode dari controller
        });

        calendar.render();
    });
</script>
