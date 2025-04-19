<div class="col-md-12">
            <div class="card card-primary shadow-lg">
              <div class="card-header">
                <h3 class="card-title"><?= $judul ?></h3>

                <!-- <div class="card-tools">
                  <a class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-plus"></i>
                  </a>
                </div> -->
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <?= form_open('Admin/updateSetting') ?>
              <div class="card-body">

                 <!-- Pesan Error -->
             <?php
                $errors = validation_errors();

                if (session()->get('pesan')) {
                    echo '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-check"></i>';
                    echo session()->get('pesan');
                    echo '</div>';
                }
             ?>
                  <div class="form-group">
                    <label>Nama Sekolah</label>
                    <input name="nama_sekolah" value="<?= $setting['nama_sekolah'] ?>" class="form-control" placeholder="Nama Sekolah" required>
                  </div>
                  <div class="form-group">
                    <label>Alamat</label>
                    <input name="alamat" value="<?= $setting['alamat'] ?>" class="form-control" placeholder="Alamat" required>
                  </div>

                  <div class="form-group">
                    <label>Lokasi Sekolah</label>
                    <input name="lokasi_sekolah" value="<?= $setting['lokasi_sekolah'] ?>" class="form-control" placeholder="Lokasi Sekolah" required>
                  </div>

                    <div id="map" style="width: 100%; height: 300px;"></div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <?= form_close() ?>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>

        <script>
            var map = L.map('map').setView([<?= $setting['lokasi_sekolah'] ?>], 13);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
              attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([<?= $setting['lokasi_sekolah'] ?>]).addTo(map)
                .bindPopup('<?= $setting['nama_sekolah'] ?>')
                 .openPopup();

                 var circle = L.circle([<?= $setting['lokasi_sekolah'] ?>], {
                     color: 'blue',
                     fillColor: '#0000FF',
                     fillOpacity: 0.5,
                     radius: 500
                    }).addTo(map);
        </script>