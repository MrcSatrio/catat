<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\UserModel;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\TransaksiModel;
use App\Models\JenisTransaksiModel;
use App\Models\PengumumanModel;

class Admin extends BaseController

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
        // Mendapatkan tanggal hari ini dengan DateTime
        $today = (new \DateTime())->format('Y-m-d'); // Format ke 'YYYY-MM-DD'

        // Mengambil pemasukan harian
        $pemasukanharian = $this->transaksiModel
            ->where('id_jenis_transaksi', 1)
            ->where('id_status_transaksi', 2)
            ->where('DATE(updated_at)', $today) // Filter berdasarkan tanggal hari ini
            ->selectSum('nominal_transaksi') // Menggunakan selectSum() untuk menghitung jumlah
            ->first(); // Ambil hasilnya dalam bentuk array, karena selectSum() mengembalikan array

        // Mengambil pengeluaran harian
        $pengeluaranharian = $this->transaksiModel
            ->where('id_jenis_transaksi', 2)
            ->where('id_status_transaksi', 2)
            ->where('DATE(updated_at)', $today) // Filter berdasarkan tanggal hari ini
            ->selectSum('nominal_transaksi') // Menggunakan selectSum() untuk menghitung jumlah
            ->first();

        // Mengambil pemasukan bulanan
        $pemasukanbulanan = $this->transaksiModel
            ->where('id_jenis_transaksi', 1)
            ->where('id_status_transaksi', 2)
            ->where('MONTH(updated_at)', date('m')) // Filter berdasarkan bulan saat ini
            ->selectSum('nominal_transaksi') // Menggunakan selectSum() untuk menghitung jumlah
            ->first();

        // Mengambil pengeluaran bulanan
        $pengeluaranbulanan = $this->transaksiModel
            ->where('id_jenis_transaksi', 2)
            ->where('id_status_transaksi', 2)
            ->where('MONTH(updated_at)', date('m')) // Filter berdasarkan bulan saat ini
            ->selectSum('nominal_transaksi') // Menggunakan selectSum() untuk menghitung jumlah
            ->first();

        $transaksipending = $this->transaksiModel
            ->select('transaksi.*, status_transaksi.*, jenis_transaksi.*, siswa.*')
            ->join('status_transaksi', 'status_transaksi.id_status_transaksi = transaksi.id_status_transaksi')
            ->join('jenis_transaksi', 'jenis_transaksi.id_jenis_transaksi = transaksi.id_jenis_transaksi')
            ->join('siswa', 'siswa.id_siswa = transaksi.id_siswa')
            ->where('transaksi.id_status_transaksi', 1)  // Memastikan menggunakan id_status_transaksi dari tabel transaksi
            ->findAll();


        // Menyediakan data ke view
        return view('admin/dashboard', [
            'pemasukanharian' => $pemasukanharian['nominal_transaksi'],
            'pengeluaranharian' => $pengeluaranharian['nominal_transaksi'],
            'pemasukanbulanan' => $pemasukanbulanan['nominal_transaksi'],
            'pengeluaranbulanan' => $pengeluaranbulanan['nominal_transaksi'],
            'transaksipending' => $transaksipending
        ]);
    }





    public function read_siswa(): string
    {
        $siswa = $this->siswaModel
            ->join('kelas', 'kelas.id_kelas = siswa.id_kelas') // Menambahkan join
            ->findAll();

        $kelas = $this->kelasModel->findAll();
        return view('admin/read_siswa', ['siswas' => $siswa, 'kelas' => $kelas]);
    }

    public function action_tambah_siswa()
    {
        // Mendefinisikan aturan validasi
        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'nisn' => 'required|numeric|min_length[5]|max_length[20]',
            'kelas' => 'required|is_not_unique[kelas.id_kelas]', // Menyesuaikan jika id_kelas adalah foreign key
        ];

        // Melakukan validasi
        if (!$this->validate($rules)) {
            // Jika validasi gagal, redirect kembali dengan pesan error
            return redirect()->to(base_url('admin/read_siswa'))
                ->withInput()
                ->with('error', implode(', ', $this->validator->getErrors())); // Menggabungkan array error menjadi string
        }

        // Menyimpan data siswa ke model jika validasi sukses
        $this->siswaModel->save([
            'nama_siswa' => $this->request->getPost('nama'),
            'nisn_siswa' => $this->request->getPost('nisn'),
            'id_kelas' => $this->request->getPost('kelas'),
        ]);

        // Redirect setelah data berhasil disimpan
        return redirect()->to(base_url('admin/read_siswa'))
            ->with('success', 'Siswa berhasil ditambahkan');
    }

    public function action_delete_siswa($id_siswa)
    {
        $this->siswaModel->delete($id_siswa);
        return redirect()->to(base_url('admin/read_siswa'))
            ->with('success', 'Siswa berhasil dihapus');
    }

    public function action_edit_siswa()
    {
        $siswa = $this->siswaModel->find($this->request->getPost('id_siswa'));

        if (!$siswa) {
            return redirect()->to(base_url('admin/read_siswa'))
                ->with('error', 'Siswa tidak ditemukan');
        }

        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'nisn' => 'required|numeric|min_length[5]|max_length[20]',
            'kelas' => 'required|is_not_unique[kelas.id_kelas]', // Menyesuaikan jika id_kelas adalah foreign key
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('admin/read_siswa'))
                ->withInput()
                ->with('error', implode(', ', $this->validator->getErrors()));
        }

        $this->siswaModel->update($this->request->getPost('id_siswa'), [
            'nama_siswa' => $this->request->getPost('nama'),
            'nisn_siswa' => $this->request->getPost('nisn'),
            'id_kelas' => $this->request->getPost('kelas'),
        ]);

        return redirect()->to(base_url('admin/read_siswa'))
            ->with('success', 'Siswa berhasil diperbarui');
    }


    public function read_kelas(): string
    {
        $kelas = $this->kelasModel->findAll();
        return view('admin/read_kelas', ['kelas' => $kelas]);
    }

    public function action_tambah_kelas()
    {
        // Mendefinisikan aturan validasi
        $rules = [
            'kelas' => 'required|min_length[2]|max_length[10]',
            'tagihan' => 'required|numeric',
        ];

        // Melakukan validasi
        if (!$this->validate($rules)) {
            // Jika validasi gagal, redirect kembali dengan pesan error
            return redirect()->to(base_url('admin/read_kelas'))
                ->withInput()
                ->with('error', implode(', ', $this->validator->getErrors())); // Menggabungkan array error menjadi string
        }

        // Menyimpan data kelas ke model jika validasi sukses        
        $this->kelasModel->save([
            'nama_kelas' => $this->request->getPost('kelas'),
            'tagihan_kelas' => $this->request->getPost('tagihan'),
        ]);

        // Redirect setelah data berhasil disimpan        
        return redirect()->to(base_url('admin/read_kelas'))
            ->with('success', 'Kelas berhasil ditambahkan');
    }

    public function action_delete_kelas($id_kelas)
    {
        // Menghapus kelas berdasarkan id
        $deleted = $this->kelasModel->delete($id_kelas);

        // Mengecek apakah penghapusan berhasil
        if ($deleted) {
            // Jika berhasil, arahkan ke halaman dengan pesan sukses
            return redirect()->to(base_url('admin/read_kelas'))
                ->with('success', 'Kelas berhasil dihapus');
        } else {
            // Jika gagal, arahkan ke halaman dengan pesan error
            return redirect()->to(base_url('admin/read_kelas'))
                ->with('error', 'Kelas gagal dihapus');
        }
    }

    public function action_edit_kelas()
    {
        $id_kelas = $this->request->getPost('id_kelas');

        // Mendapatkan data kelas berdasarkan id4
        $kelas = $this->kelasModel->find($id_kelas);

        if (!$kelas) {
            return redirect()->to(base_url('admin/read_kelas'))
                ->with('error', 'Kelas tidak ditemukan');
        }

        // Melakukan validasi
        $rules = [
            'kelas' => 'required|min_length[2]|max_length[10]',
            'tagihan' => 'required|numeric',
        ];

        if (!$this->validate($rules)) { // Melakukan validasi           
            return redirect()->to(base_url('admin/read_kelas'))
                ->withInput()
                ->with('error', implode(', ', $this->validator->getErrors())); // Menggabungkan array error menjadi string
        }

        // Memperbarui data kelas
        $this->kelasModel->update($id_kelas, [
            'nama_kelas' => $this->request->getPost('kelas'),
            'tagihan_kelas' => $this->request->getPost('tagihan'),
        ]);

        // Redirect setelah data berhasil diperbarui
        return redirect()->to(base_url('admin/read_kelas'))
            ->with('success', 'Kelas berhasil diperbarui');
    }

    public function read_user()
    {

        $users = $this->userModel
            ->join('siswa', 'siswa.id_siswa = user.id_siswa')
            ->where('id_role', '2')
            ->findAll();

        $siswa = $this->siswaModel->findAll();

        return view('admin/read_user', ['users' => $users, 'siswas' => $siswa]);
    }

    public function action_tambah_user()
    {
        // Mendefinisikan aturan validasi
        $rules = [
            'nama' => 'required|min_length[2]|max_length[30]',
            'username' => 'required|min_length[4]|max_length[30]|is_unique[user.username]',
            'siswa' => 'required|is_unique[siswa.id_siswa]',
        ];

        // Melakukan validasi
        if (!$this->validate($rules)) {
            // Jika validasi gagal, redirect kembali dengan pesan error 
            return redirect()->to(base_url('admin/read_user'))
                ->withInput()
                ->with('error', implode(', ', $this->validator->getErrors())); // Menggabungkan array error menjadi string
        }

        // Menyimpan data user ke model jika validasi sukses    
        $this->userModel->save([
            'nama_user' => $this->request->getPost('nama'),
            'username'  => $this->request->getPost('username'),
            'id_siswa'  => $this->request->getPost('siswa'),
            'id_role'   => '2',
            'password'  => md5('12345678')
        ]);

        // Redirect setelah data berhasil disimpan  
        return redirect()->to(base_url('admin/read_user'))
            ->with('success', 'User berhasil ditambahkan');
    }

    public function action_delete_user($id_user)
    {
        $this->userModel->delete($id_user);
        return redirect()->to(base_url('admin/read_user'))
            ->with('success', 'User berhasil dihapus');
    }

    public function action_edit_user()
    {
        $id_user = $this->request->getPost('id_user');

        // Mendapatkan data user berdasarkan id
        $user = $this->userModel->find($id_user);

        if (!$user) {
            return redirect()->to(base_url('admin/read_user'))
                ->with('error', 'User tidak ditemukan');
        }

        // Melakukan validasi

        $rules = [
            'nama' => 'required|min_length[2]|max_length[30]',
            'username' => 'required|min_length[4]|max_length[30]|is_unique[user.username]',
            'siswa' => 'required|is_unique[siswa.id_siswa]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('admin/read_user'))
                ->withInput()
                ->with('error', implode(', ', $this->validator->getErrors())); // Menggabungkan array error menjadi string
        }

        // Memperbarui data user
        $this->userModel->update($id_user, [
            'nama_user' => $this->request->getPost('nama'),
            'username'  => $this->request->getPost('username'),
            'id_siswa'  => $this->request->getPost('siswa'),
        ]);

        // Redirect setelah data berhasil diperbarui

        return redirect()->to(base_url('admin/read_user'))
            ->with('success', 'User berhasil diperbarui');
    }

    public function read_transaksi()
    {
        $transaksi = $this->transaksiModel
            ->join('siswa', 'siswa.id_siswa = transaksi.id_siswa', 'left')  // LEFT JOIN
            ->join('jenis_transaksi', 'jenis_transaksi.id_jenis_transaksi = transaksi.id_jenis_transaksi', 'left')  // LEFT JOIN
            ->join('status_transaksi', 'status_transaksi.id_status_transaksi = transaksi.id_status_transaksi', 'left')  // LEFT JOIN
            ->findAll();

        return view('admin/read_transaksi', ['transaksi' => $transaksi]);
    }

    public function input_transaksi()
    {
        $transaksi = $this->transaksiModel
            ->join('siswa', 'siswa.id_siswa = transaksi.id_siswa')
            ->join('jenis_transaksi', 'jenis_transaksi.id_jenis_transaksi = transaksi.id_jenis_transaksi')
            ->join('status_transaksi', 'status_transaksi.id_status_transaksi = transaksi.id_status_transaksi')
            ->findAll();

        $jenis_transaksi = $this->jenistransaksiModel->findAll();

        $siswa = $this->siswaModel->findAll();

        return view('admin/input_transaksi', ['transaksi' => $transaksi, 'jenis_transaksi' => $jenis_transaksi, 'siswa' => $siswa]);
    }

    public function action_input_transaksi()
    {
        $id_siswa = $this->request->getPost('id_siswa');
        $id_jenis_transaksi = $this->request->getPost('id_jenis_transaksi');
        $bukti_transaksi = $this->request->getFile('bukti_transaksi');

        $bukti_transaksi->move('bukti', $bukti_transaksi->getName());

        $bukti = $bukti_transaksi->getName();

        // Validasi untuk id_siswa jika kosong
        if (empty($id_siswa)) {
            // Tangani jika tidak ada siswa yang dipilih
            // Misalnya beri pesan kesalahan atau set default value
            $siswa = null;
        } else {
            $siswa = $id_siswa;
        }

        // Tambahkan aturan validasi untuk id_siswa jika id_jenis_transaksi = 1
        $rules = [
            'id_jenis_transaksi' => 'required',
            'catatan' => 'required',
            'nominal' => 'required',
        ];

        // Jika id_jenis_transaksi adalah 1, pastikan id_siswa wajib diisi
        if ($id_jenis_transaksi == 1) {
            $rules['id_siswa'] = 'required';
        }

        // Lakukan validasi
        if (!$this->validate($rules)) {
            return redirect()->to(base_url('admin/input_transaksi'))
                ->withInput()
                ->with('error', implode(', ', $this->validator->getErrors())); // Menggabungkan array error menjadi string
        }

        // Simpan data transaksi
        $this->transaksiModel->save([
            'id_jenis_transaksi' => $id_jenis_transaksi,
            'id_siswa' => $siswa,
            'nominal_transaksi' => $this->request->getPost('nominal'),
            'catatan_transaksi' => $this->request->getPost('catatan'),
            'id_status_transaksi' => 2, // Status transaksi 2
            'bukti_transaksi' => $bukti,
        ]);

        // Redirect setelah berhasil menambahkan transaksi
        return redirect()->to(base_url('admin/input_transaksi'))
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function verifiksi($id_transaksi)
    {
        $transaksi = $this->transaksiModel->find($id_transaksi);

        if (!$transaksi) {
            return redirect()->to(base_url('admin/read_transaksi'))
                ->with('error', 'Transaksi tidak ditemukan');
        }

        $this->transaksiModel->update($id_transaksi, [
            'id_status_transaksi' => 2,
        ]);

        return redirect()->to(base_url('admin/read_transaksi'))
            ->with('success', 'Transaksi berhasil diverifikasi');
    }

    public function read_pengumuman()
    {
        $pengumuman = $this->pengumumanModel->findAll();
        return view('admin/read_pengumuman', ['pengumuman' => $pengumuman]);
    }

    public function action_edit_pengumuman()
    {
        $id_pengumuman = $this->request->getPost('id_pengumuman');

        // Fetch the data for the pengumuman using the ID
        $pengumuman = $this->pengumumanModel->find($id_pengumuman);

        if (!$pengumuman) {
            // If the pengumuman not found, redirect with error message
            return redirect()->to(base_url('admin/read_pengumuman'))
                ->with('error', 'Pengumuman tidak ditemukan');
        }

        // If a new file was uploaded, handle it
        $file = $this->request->getFile('pengumuman');  // 'bukti' is the input name for file upload

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Move the file to the 'bukti' directory
            $file->move('assets/pdf', $file->getName());

            // Update the filename in the database (assuming 'pengumuman' is the column storing file name)
            $file_name = $file->getName();

            // Update pengumuman record in the database
            $this->pengumumanModel->update($id_pengumuman, [
                'nama_pengumuman' => $file_name  // Assuming the 'pengumuman' field stores the filename
            ]);
        }

        // Redirect to the list page with a success message
        return redirect()->to(base_url('admin/read_pengumuman'))
            ->with('success', 'Pengumuman berhasil diperbarui');
    }
}
