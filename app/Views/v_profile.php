  <!-- App Header -->
  <div class="appHeader bg-primary text-light">
      <div class="left">
          <a href="javascript:;" class="headerButton goBack">
              <i class="fas fa-arrow-left fa-2x"></i>
          </a>
      </div>
      <div class="pageTitle"><?= $judul ?></div>
      <div class="right"></div>
  </div>
  <!-- * App Header -->


<div class="card card-primary card-outline mb-4">
                  <!--begin::Header-->
                  <div class="card-header"><div class="card-title">Biodata Siswa</div></div>
                  <!--end::Header-->
                  <!--begin::Form-->
                  <form>
                    <!--begin::Body-->
                    <div class="card-body">
                      <div class="mb-3">
                        <label for="exampleInputName" class="form-label">Nama</label>
                        <input
                          type="text"
                          class="form-control"
                          id="exampleInputName"
                          aria-describedby="namaHelp"
                          placeholder="Masukkan nama lengkap"
                        />
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputNis" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="exampleInputNis" placeholder="Masukkan NIS" />
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputKelas" class="form-label">Kelas</label>
                        <input type="text" class="form-control" id="exampleInputKelas" placeholder="Masukkan Kelas" />
                      </div>
                      <div class="input-group mb-3">
                        <input type="file" class="form-control" id="inputGroupFile02" />
                        <label class="input-group-text" for="inputGroupFile02">Upload Foto Profil</label>
                      </div>