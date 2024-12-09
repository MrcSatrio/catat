<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->post('/action_login', 'Auth::action_login');
$routes->get('/logout', 'Auth::logout');

$routes->group('admin', ['filter' => 'roleFilter'], function ($routes) {
    $routes->get('dashboard', 'Admin::dashboard');

    $routes->get('read_siswa', 'Admin::read_siswa');
    $routes->get('read_kelas', 'Admin::read_kelas');
    $routes->get('read_user', 'Admin::read_user');
    $routes->get('read_transaksi', 'Admin::read_transaksi');
    $routes->get('input_transaksi', 'Admin::input_transaksi');
    $routes->get('verifikasi/(:num)', 'Admin::verifikasi/$1');


    $routes->post('action_tambah_siswa', 'Admin::action_tambah_siswa');
    $routes->post('action_tambah_kelas', 'Admin::action_tambah_kelas');

    $routes->post('action_tambah_user', 'Admin::action_tambah_user');
    $routes->post('action_input_transaksi', 'Admin::action_input_transaksi');



    $routes->post('action_edit_siswa', 'Admin::action_edit_siswa');
    $routes->post('action_edit_kelas', 'Admin::action_edit_kelas');
    $routes->post('action_edit_user', 'Admin::action_edit_user');

    $routes->get('action_delete_siswa/(:num)', 'Admin::action_delete_siswa/$1');
    $routes->get('action_delete_kelas/(:num)', 'Admin::action_delete_kelas/$1');
    $routes->get('action_delete_user/(:num)', 'Admin::action_delete_user/$1');


    $routes->get('read_pengumuman', 'Admin::read_pengumuman');
    $routes->post('action_edit_pengumuman', 'Admin::action_edit_pengumuman');
});

$routes->group('user', ['filter' => 'roleFilter'], function ($routes) {
    $routes->get('dashboard', 'User::dashboard');

    $routes->get('read_transaksi', 'User::read_transaksi');
    $routes->get('create_transaksi', 'User::create_transaksi');

    $routes->post('upload_bukti', 'User::upload_bukti');
    $routes->get('pengumuman', 'User::pengumuman');

});
