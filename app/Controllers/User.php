<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\UserModel;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\TransaksiModel;
use App\Models\JenisTransaksiModel;
use App\Models\PengumumanModel;

class User extends BaseController

{
    protected $userModel;
    protected $siswaModel;
    protected $kelasModel;
    protected $transaksiModel;
    protected $jenistransaksiModel;
    protected $pengumumanModel;

    public function __construct()
    {
        // Memuat model user
        $this->userModel = new UserModel();
        $this->siswaModel = new SiswaModel();
        $this->kelasModel = new KelasModel();
        $this->transaksiModel = new TransaksiModel();
        $this->jenistransaksiModel = new JenisTransaksiModel();
        $this->pengumumanModel = new PengumumanModel();
    }

    public function dashboard(): string
    {
        // Mengambil data user berdasarkan session id_user
        $userData = $this->userModel
            ->where('id_user', session()->get('id_user'))  // Gunakan session() untuk CI4
            ->join('siswa', 'siswa.id_siswa = user.id_siswa')
            ->first();

        $id_siswa = $userData['id_siswa'];

        // Mengambil transaksi untuk semester ganjil (Juli - Desember) pada tahun yang sama
        $semesterganjil = $this->transaksiModel
            ->where('id_jenis_transaksi', 1)
            ->where('id_siswa', $id_siswa)  // Gunakan session() untuk CI4
            ->where('id_status_transaksi', 2)
            ->where('MONTH(created_at) >= 7') // Juli
            ->where('MONTH(created_at) <= 12') // Desember
            ->where('YEAR(created_at)', date('Y')) // Tahun yang sama dengan tahun sekarang
            ->selectSum('nominal_transaksi')  // Sum transaksi
            ->first(); // Ambil data pertama (atau null jika tidak ada)

        // Extract the sum value from the result
        $semesterganjil = $semesterganjil ? $semesterganjil['nominal_transaksi'] : 0;

        // Mengambil transaksi untuk semester genap (Januari - Juni) pada tahun yang sama
        $semestergenap = $this->transaksiModel
            ->where('id_jenis_transaksi', 1)
            ->where('id_siswa', $id_siswa)  // Gunakan session() untuk CI4
            ->where('id_status_transaksi', 2)
            ->where('MONTH(created_at) >= 1') // Januari
            ->where('MONTH(created_at) <= 6') // Juni
            ->where('YEAR(created_at)', date('Y')) // Tahun yang sama dengan tahun sekarang
            ->selectSum('nominal_transaksi')  // Sum transaksi
            ->first(); // Ambil data pertama (atau null jika tidak ada)

        // Extract the sum value from the result
        $semestergenap = $semestergenap ? $semestergenap['nominal_transaksi'] : 0;

        $kelasData = $this->kelasModel
            ->join('siswa', 'siswa.id_kelas = kelas.id_kelas')
            ->where('siswa.id_siswa', $id_siswa)
            ->first();

        if ($userData['potongan'] === null) {
            // Jika potongan null, hanya menghitung berdasarkan tagihan kelas
            $tagihanganjil = $semesterganjil - $kelasData['tagihan_kelas'];
            $tagihangenap = $semestergenap - $kelasData['tagihan_kelas'];
        } else {
            // Jika potongan ada, kurangkan potongan dari tagihan
            $tagihanganjil = $kelasData['tagihan_kelas'] - $userData['potongan'] - $semesterganjil;
            $tagihangenap = $semestergenap - $kelasData['tagihan_kelas'] - $userData['potongan'];
        }

        // Mengembalikan view dengan data yang diperlukan
        return view('user/dashboard', [
            'userData' => $userData,
            'semesterganjil' => $semesterganjil,
            'semestergenap' => $semestergenap,
            'tagihanganjil' => $tagihanganjil,
            'tagihangenap' => $tagihangenap
        ]);
    }

    public function read_transaksi()
    {
        $userData = $this->userModel
            ->where('id_user', session()->get('id_user'))  // Gunakan session() untuk CI4
            ->join('siswa', 'siswa.id_siswa = user.id_siswa')
            ->first();

        $id_siswa = $userData['id_siswa'];

        $transaksi = $this->transaksiModel
            ->join('siswa', 'siswa.id_siswa = transaksi.id_siswa', 'left')  // LEFT JOIN
            ->join('jenis_transaksi', 'jenis_transaksi.id_jenis_transaksi = transaksi.id_jenis_transaksi', 'left')  // LEFT JOIN
            ->join('status_transaksi', 'status_transaksi.id_status_transaksi = transaksi.id_status_transaksi', 'left')  // LEFT JOIN
            ->where('transaksi.id_siswa', $id_siswa)  // Filter transaksi berdasarkan id_siswa
            ->findAll();  // Mengambil semua transaksi

        return view('user/read_transaksi', ['transaksis' => $transaksi]);
    }

    public function upload_bukti()
    {
        // Mendapatkan id transaksi dari POST request
        $idTransaksi = $_POST['id_transaksi'];

        // Mencari transaksi berdasarkan ID
        $transaksi = $this->transaksiModel->find($idTransaksi);

        // Mendapatkan file bukti transaksi
        $bukti_transaksi = $_FILES['bukti_transaksi'];

        // Jika transaksi ditemukan
        if ($transaksi) {
            // Mengecek apakah tidak ada error pada file upload
            if ($bukti_transaksi['error'] === UPLOAD_ERR_OK) {
                // Mendapatkan nama file bukti transaksi
                $bukti = $bukti_transaksi['name'];

                // Memindahkan file ke folder 'bukti'
                move_uploaded_file($bukti_transaksi['tmp_name'], 'bukti/' . $bukti);

                // Menyimpan nama file bukti transaksi ke dalam array transaksi
                $transaksi['bukti_transaksi'] = $bukti;

                // Menyimpan kembali transaksi yang sudah diperbarui
                $this->transaksiModel->save($transaksi);

                return redirect()->to(base_url('user/read_transaksi'))
                    ->with('success', 'Bukti Berhasil Di Upload');
            } else {
                // Menangani kasus jika ada error saat upload file
                return redirect()->to(base_url('user/read_transaksi'))
                    ->with('error', 'Terjadi kesalahan saat mengupload bukti transaksi.');
            }
        } else {
            // Menangani kasus jika transaksi tidak ditemukan
            return redirect()->to(base_url('user/read_transaksi'))
                ->with('error', 'Transaksi tidak ditemukan.');
        }
    }

    public function create_transaksi()
    {
        $userData = $this->userModel
            ->where('id_user', session()->get('id_user'))  // Gunakan session() untuk CI4
            ->join('siswa', 'siswa.id_siswa = user.id_siswa')
            ->first();
        return view('user/create_transaksi', ['userData' => $userData]);
    }

    public function pengumuman()
    {
        $userData = $this->userModel
            ->where('id_user', session()->get('id_user'))
            ->join('siswa', 'siswa.id_siswa = user.id_siswa')
            ->first();

        // Ambil pengumuman pertama (atau sesuaikan dengan query Anda)
        $pengumuman = $this->pengumumanModel->first();

        return view('user/pengumuman', ['userData' => $userData, 'pengumuman' => $pengumuman]);
    }
}
