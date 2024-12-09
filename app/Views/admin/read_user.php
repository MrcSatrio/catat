<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Data Pengguna</h6>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahuser">Tambah user</button>
        </div>
        <div class="table-responsive">
            <table id="tableSiswa" class="display">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengguna</th>
                        <th>Username</th>
                        <th>Nama Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $user['nama_user'] ?></td>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['nama_siswa'] ?></td>
                            <td>
                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdituser<?= $user['id_user'] ?>">Edit</button>
                                <!-- Tombol Hapus -->
                                <button type="button" class="btn btn-danger" onclick="confirmDelete(<?= $user['id_user'] ?>)">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah user -->
<div class="modal fade" id="modalTambahuser" tabindex="-1" aria-labelledby="modalTambahuserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahuserLabel">Form Tambah user</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url(); ?>/admin/action_tambah_user" id="formTambahuser" method="post">
                    <div class="form-group">
                        <label for="Nama">Nama</label>
                        <input type="text" class="form-control" id="namauser" name="nama" placeholder="Masukkan Nama User">
                    </div>
                    <div class="form-group">
                        <label for="Username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username">
                    </div>
                    <div class="form-group">
                        <label for="Siswa">Nama Siswa</label>
                        <select class="form-control" id="siswa" name="siswa">
                            <option value="">Pilih Siswa</option>
                            <?php foreach ($siswas as $siswa) : ?>
                                <option value="<?= $siswa['id_siswa'] ?>"><?= $siswa['nama_siswa'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="submituser">Tambah user</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit user (Untuk Setiap user) -->
<?php foreach ($users as $userItem) : ?>
    <div class="modal fade" id="modalEdituser<?= $userItem['id_user'] ?>" tabindex="-1" aria-labelledby="modalEdituserLabel<?= $userItem['id_user'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEdituserLabel<?= $userItem['id_user'] ?>">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url(); ?>/admin/action_edit_user" method="post">
                        <div class="form-group">
                            <label for="namaEdit">Nama</label>
                            <input type="text" class="form-control" id="namaEdit" name="nama" value="<?= $userItem['nama_user'] ?>" required>
                            <input type="hidden" name="id_kelas" value="<?= $userItem['id_user'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="namaEdit">Username</label>
                            <input type="text" class="form-control" id="usernameEdit" name="username" value="<?= $userItem['username'] ?>" required>
                            <input type="hidden" name="id_user" value="<?= $userItem['id_user'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="siswaEdit">Nama Siswa</label>
                            <select class="form-control" id="siswaEdit" name="siswa">
                                <option value="">Pilih Siswa</option>
                                <?php foreach ($siswas as $siswaItem) : ?>
                                    <option value="<?= $siswaItem['id_siswa'] ?>"><?= $siswaItem['nama_siswa'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    // Inisialisasi DataTable setelah dokumen siap
    $(document).ready(function() {
        $('#tableSiswa').DataTable();
    });
</script>

<script>
    function confirmDelete(iduser) {
        // Menampilkan SweetAlert untuk konfirmasi
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user menekan 'Ya, Hapus!', lakukan proses penghapusan
                window.location.href = "<?php echo base_url('admin/action_delete_user/'); ?>" + iduser;
            }
        });
    }
</script>

<?= $this->endSection() ?>