<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\UserModel;

class Auth extends BaseController

{
    protected $userModel;

    public function __construct()
    {
        // Memuat model user
        $this->userModel = new UserModel();
    }

    public function login(): string
    {
        return view('login');
    }

    public function action_login()
{
    // Mendapatkan username dan password dari form input
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    // Mencari user berdasarkan username
    $user = $this->userModel->where('username', $username)->first();

    // Cek apakah user ditemukan
    if ($user) {
        // Verifikasi password dengan md5
        if (md5($password) === $user['password']) {
            // Membuat session untuk login
            $session = session();
            $sessionData = [
                'id_user' => $user['id_user'],
                'nama' => $user['nama_user'],
                'id_role' => $user['id_role']
            ];
            $session->set($sessionData);

            // Redirect berdasarkan peran user
            switch ($user['id_role']) {
                case 1:
                    return redirect()->to(base_url('admin/dashboard'));
                case 2:
                    return redirect()->to(base_url('user/dashboard'));
            }
        } else {
            // Jika password tidak valid
            return redirect()->to(base_url('/'))->withInput()->with('error', 'Password Salah');
        }
    } else {
        // Jika user tidak ditemukan
        return redirect()->to(base_url('/'))->withInput()->with('error', 'User Tidak Ditemukan');
    }
}

public function logout()
{
    // Menghapus session login
    session()->destroy();
    return redirect()->to(base_url('/'));
}   




    
}
