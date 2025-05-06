 
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
    <div class="col"></div>
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
    <div class="my_camera"></div>
    <button id="btnAbsenMasuk" class="btn btn-primary btn-block">
    <i class="fas fa-camera-retro"></i> Absen Masuk
</button>
    <input type="hidden" name="lokasi" id="lokasi"> 
    <div id="map" style="width: 100%; height: 400px;"></div>
</div>




<script>
    Webcam.set({
    width: 420,
    height: 320,
    image_format: 'jpeg',
    jpeg_quality: 90,
    });
    Webcam.attach( '.my_camera' );

    if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(showPosition);
} else {
    // Browser tidak support Geolocation
  alert("Geolocation is not supported by this browser.");
}

function showPosition(position) {
    var x = document.getElementById("lokasi");
  x.value =  position.coords.latitude + "," + position.coords.longitude;
  
  // menampilkan map dan posisi siswa
  var map = L.map('map').setView([position.coords.latitude , position.coords.longitude], 19);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

L.marker([position.coords.latitude , position.coords.longitude]).addTo(map)
// Radius Sekolah
var circle = L.circle([<?=$sekolah['lokasi_sekolah']?>], {
    color: 'red',
    fillColor: '#f03',
    fillOpacity: 0.5,
    radius: <?=$sekolah['radius']?> // radius dalam meter
}).addTo(map);

// Posisi Sekolah

var sekolahIcon = L.icon({
    iconUrl: '<?= base_url('/sekolah.png') ?>',

    iconSize:     [38, 95], // size of the icon
    shadowSize:   [50, 64], // size of the shadow
    iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});
L.marker([<?=$sekolah['lokasi_sekolah']?>],{
    icon: sekolahIcon
}).addTo(map).bindPopup('<?= $sekolah['nama_sekolah'] ?>').openPopup();


}

document.getElementById("btnAbsenMasuk").addEventListener("click", function() {
    Webcam.snap(function(data_uri) {
        var lokasi = document.getElementById("lokasi").value;

        // Kirim ke backend
        fetch("<?= base_url('presensi/absenMasuk') ?>", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "<?= csrf_hash() ?>"
            },
            body: JSON.stringify({
                foto: data_uri,
                lokasi: lokasi
            })
        })
        .then(res => res.json())
        .then(response => {
    alert(response.message);
    if (response.message === 'Absen masuk berhasil!') {
        // Redirect ke halaman index presensi (akan otomatis buka absen pulang)
        window.location.href = "<?= base_url('presensi') ?>";
    }
})

        .catch(err => console.error(err));
    });
});

</script>