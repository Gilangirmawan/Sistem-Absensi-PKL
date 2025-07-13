<?php

namespace App\Controllers;

use App\Models\ModelAdmin;
use App\Controllers\BaseController;
use App\Models\ModelSiswa;
use App\Models\ModelKelas;
use App\Models\ModelPresensi;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\ResponseInterface;

class Admin extends BaseController
{
    protected ModelAdmin $ModelAdmin;
    protected ModelSiswa $ModelSiswa;
    protected ModelKelas $ModelKelas;
    protected ModelPresensi $ModelPresensi;

    public function __construct() {
        $this->ModelAdmin = new ModelAdmin();
        $this->ModelSiswa = new ModelSiswa();
        $this->ModelKelas = new ModelKelas();
        $this->ModelPresensi = new ModelPresensi();
        helper(['form', 'url']);
    }
    

    public function index(): string
    {
        $data = [
            'judul' => 'Dashboard',
            'menu' => 'dashboard',
            'page' => 'backend/v_dashboard',
        ];
        return view('v_template_back', $data);
    }

public function siswa()
{
    // Ambil nilai filter dari URL (GET request)
    $filterKelasId = $this->request->getGet('kelas');
    
    // Gunakan fungsi baru untuk mengambil data siswa dengan join dan filter
    $dataSiswa = $this->ModelSiswa->getSiswaWithKelas($filterKelasId);

    $data = [
        'judul'       => 'Data Siswa',
        'menu'        => 'siswa',
        'page'        => 'backend/v_siswa',
        'siswa'       => $dataSiswa, // Data siswa yang sudah difilter
        'kelas'       => $this->ModelKelas->findAll(),
        'filterKelas' => $filterKelasId // Kirim ID kelas yang aktif untuk filter
    ];
    return view('v_template_back', $data);
}

public function tambahSiswa()
{
    if ($this->request->getMethod() === 'POST') {
        $rules = [
            'nis' => 'required|is_unique[tbl_siswa.nis]',
            'nama_siswa' => 'required',
            'username' => 'required|is_unique[tbl_siswa.username]',
            'id_kelas' => 'required',
            'password' => 'required|min_length[4]',
            'foto_siswa' => [
                // Tambahkan 'permit_empty' untuk membuat foto opsional
                'rules' => 'permit_empty|max_size[foto_siswa,1024]|is_image[foto_siswa]|mime_in[foto_siswa,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran foto maksimal 1MB.',
                    'is_image' => 'File yang diupload harus berupa gambar.',
                    'mime_in' => 'Format foto harus JPG/JPEG/PNG.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            // Set pesan error untuk ditampilkan
            session()->setFlashdata('error', 'Gagal menambahkan data siswa. Silakan periksa kembali isian Anda.');
            return redirect()->to(base_url('Admin/siswa'))
                              ->withInput()
                              ->with('validation', $this->validator);
        }

        $fotoFile = $this->request->getFile('foto_siswa');
        $namaFoto = 'default.png'; // Nama file default jika tidak ada foto yang diunggah

        // Cek apakah ada file yang diunggah dan valid
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $namaFoto = $fotoFile->getRandomName();
            $fotoFile->move('uploads/', $namaFoto); // Pindahkan file ke folder 'public/uploads'
        }

        $data = [
            'nis' => $this->request->getPost('nis'),
            'nama_siswa' => $this->request->getPost('nama_siswa'),
            'username' => $this->request->getPost('username'),
            'id_kelas' => $this->request->getPost('id_kelas'),
            'password' => hash('sha1', $this->request->getPost('password')),
            'foto_siswa' => $namaFoto
        ];

        $this->ModelSiswa->insert($data);

        session()->setFlashdata('success', 'Data siswa berhasil ditambahkan.');
        return redirect()->to(base_url('Admin/siswa'));
    }

 
    return redirect()->to(base_url('Admin/siswa'));
}

// edit siswa
    public function editSiswa($id_siswa)
    {
        $siswa = $this->ModelSiswa->find($id_siswa);
        $fotoBaru = $this->request->getFile('foto_siswa');
        $namaFoto = $siswa['foto_siswa'];

        if ($fotoBaru && $fotoBaru->isValid() && !$fotoBaru->hasMoved()) {
            // Hapus foto lama jika ada
            if ($namaFoto && file_exists('uploads/' . $namaFoto)) {
                unlink('uploads/' . $namaFoto);
            }
            $namaFoto = $fotoBaru->getRandomName();
            $fotoBaru->move('uploads/', $namaFoto);
        }

        $passwordInput = $this->request->getPost('password');
        $password = $siswa['password'];
        if (!empty($passwordInput)) {
        $password = sha1($passwordInput);
        }

        $data = [
            'nis'         => $this->request->getPost('nis'),
            'nama_siswa'  => $this->request->getPost('nama_siswa'),
            'id_kelas'    => $this->request->getPost('id_kelas'),
            'username'    => $this->request->getPost('username'),
            'password'    => $password,
            'foto_siswa'  => $namaFoto
        ];

        $this->ModelSiswa->update($id_siswa, $data);
        session()->setFlashdata('success', 'Data siswa berhasil diupdate.');
        return redirect()->to(base_url('Admin/siswa'));
    }


    // Hapus siswa
    public function hapusSiswa($id_siswa)
{
    $siswa = $this->ModelSiswa->find($id_siswa);

    if ($siswa && $siswa['foto_siswa']) {
        $fotoPath = 'uploads/' . $siswa['foto_siswa'];
        if (file_exists($fotoPath)) {
            unlink($fotoPath);
        }
    }

    $this->ModelSiswa->delete($id_siswa);
    session()->setFlashdata('success', 'Siswa berhasil dihapus.');
    return redirect()->to(base_url('Admin/siswa'));
}

public function kelas()
{
    $data = [
        'judul' => 'Manajemen Kelas',
        'menu' => 'kelas',
        'page'  => 'backend/v_kelas',
        'kelas' => $this->ModelKelas->findAll()
    ];

    return view('v_template_back', $data);
}

// Tambah kelas
public function tambahKelas()
{
    $rules = [
        'kelas' => 'required|is_unique[tbl_kelas.kelas]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('validation', $this->validator);
    }

    $this->ModelKelas->insert([
        'kelas' => $this->request->getPost('kelas')
    ]);

    session()->setFlashdata('success', 'Data kelas berhasil ditambahkan.');
    return redirect()->to(base_url('Admin/kelas'));
}

// Edit kelas
public function editKelas($id_kelas)
{
    $kelasBaru = $this->request->getPost('kelas');

    // Cek jika nama kelas diubah dan sama dengan data lain
    $existing = $this->ModelKelas
        ->where('kelas', $kelasBaru)
        ->where('id_kelas !=', $id_kelas)
        ->first();

    if ($existing) {
        session()->setFlashdata('error', 'Nama kelas sudah digunakan.');
        return redirect()->to(base_url('Admin/kelas'));
    }

    $this->ModelKelas->update($id_kelas, [
        'kelas' => $kelasBaru
    ]);

    session()->setFlashdata('success', 'Data kelas berhasil diperbarui.');
    return redirect()->to(base_url('Admin/kelas'));
}

// Hapus kelas
public function hapusKelas($id_kelas)
{
    // Optional: Cek jika masih digunakan oleh siswa
    $siswa = $this->ModelSiswa->where('id_kelas', $id_kelas)->countAllResults();
    if ($siswa > 0) {
        session()->setFlashdata('error', 'Kelas tidak dapat dihapus karena masih digunakan oleh data siswa.');
        return redirect()->to(base_url('Admin/kelas'));
    }

    $this->ModelKelas->delete($id_kelas);
    session()->setFlashdata('success', 'Data kelas berhasil dihapus.');
    return redirect()->to(base_url('Admin/kelas'));
}

public function presensiSiswa()
{
    $filterKelas = $this->request->getGet('kelas');

    $data = [
        'judul'       => 'Presensi Siswa',
        'menu'        => 'presensi',
        'page'        => 'backend/detail-presensi/v_siswa_presensi',
        'kelas'       => $this->ModelKelas->findAll(),
        'filterKelas' => $filterKelas,
        'siswa'       => $this->ModelSiswa->getSiswaWithKelas($filterKelas)
    ];

    return view('v_template_back', $data);
}

public function detailPresensi($id_siswa)
{
    helper('date');
    $modelSiswa = $this->ModelSiswa->find($id_siswa);
    $ModelPresensi = $this->ModelPresensi->find($id_siswa);
    
    if (!$modelSiswa) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Siswa tidak ditemukan');
    }

    $tanggalMulai = new \DateTime(TGL_MULAI_PKL);
    $tanggalHariIni = new \DateTime(); // hari ini

    $interval = new \DateInterval('P1D');
    $periode = new \DatePeriod($tanggalMulai, $interval, $tanggalHariIni->modify('+1 day'));

    $presensi = [];

    foreach ($periode as $tanggal) {
        if (in_array($tanggal->format('N'), [6, 7])) {
            continue; // skip weekend
        }

        $tglStr = $tanggal->format('Y-m-d');
        $dataPresensi = $ModelPresensi
            ->where('id_siswa', $id_siswa)
            ->where('tgl_presensi', $tglStr)
            ->first();

        if ($dataPresensi) {
            $presensi[] = [
                'tanggal'    => $tglStr,
                'jam_in'     => $dataPresensi['jam_in'],
                'jam_out'    => $dataPresensi['jam_out'],
                'keterangan' => intval($dataPresensi['keterangan']),
            ];
        } else {
            $presensi[] = [
                'tanggal'    => $tglStr,
                'jam_in'     => null,
                'jam_out'    => null,
                'keterangan' => 0, // alfa
            ];
        }
    }

    $data = [
        'judul'   => 'Detail Presensi Siswa',
        'menu'    => 'presensi',
        'page'    => 'backend/detail-presensi/v_detail_presensi',
        'siswa'   => $modelSiswa,
        'presensi'=> $presensi
    ];

    return view('v_template_back', $data);
}

public function updateKeterangan()
{
    $id_siswa     = $this->request->getPost('id_siswa');
    $tgl_presensi = $this->request->getPost('tgl_presensi');
    $keterangan   = $this->request->getPost('keterangan');

    // Validasi sederhana
    if (!$id_siswa || !$tgl_presensi || !$keterangan) {
        return redirect()->back()->with('error', 'Data tidak lengkap.');
    }


    // Cek apakah presensi sudah ada untuk tanggal itu
    $dataPresensi = $this->ModelPresensi
        ->where('id_siswa', $id_siswa)
        ->where('tgl_presensi', $tgl_presensi)
        ->first();

    if ($dataPresensi) {
        // Update keterangan
        $this->ModelPresensi->update($dataPresensi['id_presensi'], [
            'keterangan' => $keterangan
        ]);
    } else {
        // Insert baru dengan hanya keterangan
        $this->ModelPresensi->insert([
            'id_siswa'     => $id_siswa,
            'tgl_presensi' => $tgl_presensi,
            'keterangan'   => $keterangan
        ]);
    }

    return redirect()->back()->with('success', 'Keterangan berhasil diperbarui.');
}

public function rekapPresensi()
{
    $kelas = $this->ModelKelas->findAll();

    $filterKelas = $this->request->getGet('kelas');
    $tanggalMulai = TGL_MULAI_PKL;
    $tanggalAkhir = $this->request->getGet('tanggal_akhir');

    $rekapData = [];

    if ($filterKelas && $tanggalAkhir) {
        $siswa = $this->ModelSiswa->getSiswaWithKelas($filterKelas);

        foreach ($siswa as $s) {
            $dataPresensi = $this->ModelPresensi
                ->where('id_siswa', $s['id_siswa'])
                ->where('tgl_presensi >=', $tanggalMulai)
                ->where('tgl_presensi <=', $tanggalAkhir)
                ->findAll();

            // Hitung total hadir, izin, alfa
            $hadir = 0; $izin = 0; $alfa = 0;

            $periode = new \DatePeriod(
                new \DateTime($tanggalMulai),
                new \DateInterval('P1D'),
                (new \DateTime($tanggalAkhir))->modify('+1 day')
            );

            foreach ($periode as $tanggal) {
                if (in_array($tanggal->format('N'), [6,7])) continue; // Skip weekend

                $presensiTanggal = array_filter($dataPresensi, function($p) use ($tanggal) {
                    return $p['tgl_presensi'] == $tanggal->format('Y-m-d');
                });

                if ($presensiTanggal) {
                    $p = array_values($presensiTanggal)[0];
                    if ($p['keterangan'] == 1) $hadir++;
                    elseif ($p['keterangan'] == 2) $izin++;
                } else {
                    $alfa++;
                }
            }

            $rekapData[] = [
                'nis' => $s['nis'],
                'nama' => $s['nama_siswa'],
                'kelas' => $s['kelas'],
                'hadir' => $hadir,
                'izin' => $izin,
                'alfa' => $alfa,
            ];
        }
    }

    $data = [
        'judul' => 'Rekap Absensi',
        'menu' => 'rekap',
        'page' => 'backend/v_rekap',
        'kelas' => $kelas,
        'filterKelas' => $filterKelas,
        'tanggalMulai' => $tanggalMulai,
        'tanggalAkhir' => $tanggalAkhir,
        'rekap' => $rekapData
    ];

    return view('v_template_back', $data);
}

public function exportRekapXLSX()
{
    $filterKelas = $this->request->getGet('kelas');
    $tanggalMulai = TGL_MULAI_PKL; // Ambil dari global constant
    $tanggalAkhir = $this->request->getGet('tanggal_akhir');

    if (!$filterKelas || !$tanggalAkhir) {
        return redirect()->back()->with('error', 'Filter kelas dan tanggal akhir wajib diisi.');
    }

    $siswa = $this->ModelSiswa->getSiswaWithKelas($filterKelas);

    // Siapkan data rekap
    $rekapData = [];
    foreach ($siswa as $s) {
        $dataPresensi = $this->ModelPresensi
            ->where('id_siswa', $s['id_siswa'])
            ->where('tgl_presensi >=', $tanggalMulai)
            ->where('tgl_presensi <=', $tanggalAkhir)
            ->findAll();

        $hadir = 0; $izin = 0; $alfa = 0;

        $periode = new \DatePeriod(
            new \DateTime($tanggalMulai),
            new \DateInterval('P1D'),
            (new \DateTime($tanggalAkhir))->modify('+1 day')
        );

        foreach ($periode as $tanggal) {
            if (in_array($tanggal->format('N'), [6,7])) continue; // Skip weekend

            $presensiTanggal = array_filter($dataPresensi, function($p) use ($tanggal) {
                return $p['tgl_presensi'] == $tanggal->format('Y-m-d');
            });

            if ($presensiTanggal) {
                $p = array_values($presensiTanggal)[0];
                if ($p['keterangan'] == 1) $hadir++;
                elseif ($p['keterangan'] == 2) $izin++;
            } else {
                $alfa++;
            }
        }

        $rekapData[] = [
            'nis' => $s['nis'],
            'nama' => $s['nama_siswa'],
            'kelas' => $s['kelas'],
            'hadir' => $hadir,
            'izin' => $izin,
            'alfa' => $alfa,
        ];
    }

    // Buat Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set judul
    $sheet->setCellValue('A1', 'REKAP PRESENSI SISWA');
    $sheet->mergeCells('A1:F1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

    // Header
    $header = ['No', 'NIS', 'Nama Siswa', 'Kelas', 'Hadir', 'Izin/Sakit', 'Alfa'];
    $col = 'A';
    foreach ($header as $h) {
        $sheet->setCellValue($col . '3', $h);
        $col++;
    }

    // Styling Header
    $styleHeader = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF']
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '4e73df']
    ],
    'alignment' => ['horizontal' => 'center'],
    'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
    ]
];


    $sheet->getStyle('A3:G3')->applyFromArray($styleHeader);

    // Isi data
    $no = 1;
    $row = 4;
    foreach ($rekapData as $r) {
        $sheet->setCellValue('A' . $row, $no++);
        $sheet->setCellValue('B' . $row, $r['nis']);
        $sheet->setCellValue('C' . $row, $r['nama']);
        $sheet->setCellValue('D' . $row, $r['kelas']);
        $sheet->setCellValue('E' . $row, $r['hadir']);
        $sheet->setCellValue('F' . $row, $r['izin']);
        $sheet->setCellValue('G' . $row, $r['alfa']);

        $row++;
    }

    // Set border seluruh tabel
    $sheet->getStyle('A3:G' . ($row-1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    // Auto-size kolom
    foreach (range('A', 'G') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Outputkan sebagai file download
    $filename = 'Rekap_Presensi_' . date('Ymd_His') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

}
