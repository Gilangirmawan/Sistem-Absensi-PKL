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

<div class="row" style="margin-top: 70px;">
    <div class="col">

        <style>
            .my_camera,
            .my_camera video {
                display: inline-block;
                width: 100% !important;
                margin: auto;
                height: auto !important;
                border-radius: 15px;
            }
        </style>

        <!-- Form untuk submit absen -->
        <form method="post" action="<?= base_url('Presensi/absenPulang') ?>">
            <div class="my_camera"></div>
            <input type="hidden" name="lokasi" id="lokasi">
            <input type="hidden" name="image" id="image">

            <button type="button" id="btnAbsenPulang" class="btn btn-primary btn-block mt-2">
                <i class="fas fa-camera-retro"></i> Absen Pulang
            </button>
        </form>

        <div id="map" style="width: 100%; height: 400px;" class="mt-3"></div>
    </div>
</div>

<!-- Webcam & Lokasi -->
<script>
    // Set webcam
    Webcam.set({
        width: 420,
        height: 320,
        image_format: 'jpeg',
        jpeg_quality: 90,
    });
    Webcam.attach('.my_camera');

    // Tangkap lokasi
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert("Geolocation is not supported by this browser.");
    }

    function showPosition(position) {
        let lokasiInput = document.getElementById("lokasi");
        lokasiInput.value = position.coords.latitude + "," + position.coords.longitude;

        // Tampilkan peta
        let map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 19);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
    }

    // Tombol absen: capture webcam + submit
    document.getElementById('btnAbsenPulang').addEventListener('click', function () {
        Webcam.snap(function (data_uri) {
            document.getElementById('image').value = data_uri;
            // Submit form
            document.querySelector('form').submit();
        });
    });
</script>
