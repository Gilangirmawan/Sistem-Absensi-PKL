<div class="section bg-primary" id="user-section">
<div class="px-2 "><marquee class="py-3"><h1 class="text-light">HIDUP JOKOWI !!! HIDUP JOKOWI !!! HIDUP JOKOWI !!!</h1></marquee></div>
</div>

<div class="section" id="menu-section">
    <div class="card">
        <div class="card-body d-flex align-items-center">
            <div class="avatar me-3">
                <img src="<?= base_url('foto') ?>/<?= $siswa['foto_siswa'] ?>" alt="avatar" class="imaged w64 rounded" />
            </div>
            <div id="user-info" class="mb-1">
            <h2 id="user-name" class="text-dark"><?= $siswa['nama_siswa'] ?></h2>
            <span id="user-role" class="text-dark"><?= $siswa['kelas'] ?></span>
        </div>
        </div>
    </div>
</div>

<div class="section mt-2" id="presence-section">
    

    <div class="rekappresence mt-1">
        <div class="col">
            <canvas id="myChart" style="min-height: 460px; height: 460px; max-height: 460px; max-width: 100%;"></canvas>
        </div>
    </div>

    <div class="rekappresence mt-1">

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence primary">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="presencedetail">
                                <h4 class="rekappresencetitle">Hadir</h4>
                                <span class="rekappresencedetail">0 Hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence green">
                                <i class="fas fa-info"></i>
                            </div>
                            <div class="presencedetail">
                                <h4 class="rekappresencetitle">Izin</h4>
                                <span class="rekappresencedetail">0 Hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence danger">
                                <i class="fas fa-sad-tear"></i>
                            </div>
                            <div class="presencedetail">
                                <h4 class="rekappresencetitle">Sakit</h4>
                                <span class="rekappresencedetail">0 Hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence warning">
                                <i class="fa fa-clock"></i>
                            </div>
                            <div class="presencedetail">
                                <h4 class="rekappresencetitle">Terlambat</h4>
                                <span class="rekappresencedetail">0 Hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="presencetab mt-2">
        <div class="tab-content mt-2" style="margin-bottom: 100px">
            <div class="tab-content mt-2" style="margin-bottom: 100px">
            <a href="<?= base_url('Auth/logOut') ?>" class="btn btn-danger btn-sm btn btn-block"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div> 
        </div>
    </div>
</div>