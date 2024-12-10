<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Data Siswa</h6>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">Tambah Siswa</button>
        </div>
        <div class="table-responsive">
            <table id="tableSiswa" class="display">
                <thead>
                    <tr>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($siswas as $siswa) : ?>
                        <tr>
                            <td><?= $siswa['nisn_siswa'] ?></td>
                            <td><?= $siswa['nama_siswa'] ?></td>
                            <td><?= $siswa['nama_kelas'] ?></td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditSiswa<?= $siswa['id_siswa'] ?>">Edit</button>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete(<?= $siswa['id_siswa'] ?>)">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahSiswa" tabindex="-1" aria-labelledby="modalTambahSiswaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahSiswaLabel">Form Tambah Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url(); ?>admin/action_tambah_siswa" id="formTambahSiswa" method="post">
                    <div class="form-group">
                        <label for="namaSiswa">Nama Siswa</label>
                        <input type="text" class="form-control" id="namaSiswa" name="nama" placeholder="Masukkan nama siswa">
                    </div>
                    <div class="form-group">
                        <label for="nisSiswa">NISN</label>
                        <input type="text" class="form-control" id="nisSiswa" name="nisn" placeholder="Masukkan NIS">
                    </div>
                    <div class="form-group">
                        <label for="kelasSiswa">Kelas</label>
                        <select class="form-control" id="kelasSiswa" name="kelas">
                            <option value="">Pilih Kelas</option>
                            <?php foreach ($kelas as $kelasi) : ?>
                                <option value="<?= $kelasi['id_kelas'] ?>"><?= $kelasi['nama_kelas'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="submitSiswa">Tambah Siswa</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($siswas as $siswa) : ?>
    <div class="modal fade" id="modalEditSiswa<?= $siswa['id_siswa'] ?>" tabindex="-1" aria-labelledby="modalEditSiswaLabel<?= $siswa['id_siswa'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditSiswaLabel<?= $siswa['id_siswa'] ?>">Edit Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url(); ?>admin/action_edit_siswa" method="post">
                        <div class="form-group">
                            <label for="namaKelasEdit">Nama Siswa</label>
                            <input type="text" class="form-control" id="namaSiswa" name="nama" value="<?= $siswa['nama_siswa'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="namaKelasEdit">NISN Siswa</label>
                            <input type="text" class="form-control" id="nisnSiswa" name="nisn" value="<?= $siswa['nisn_siswa'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="namaKelasEdit">Kelas Siswa</label>
                            <select class="form-control" id="kelasSiswa" name="kelas">
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas as $kelasItem) : ?>
                                <option value="<?= $kelasItem['id_kelas'] ?>"><?= $kelasItem['nama_kelas'] ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <input type="hidden" name="id_siswa" value="<?= $siswa['id_siswa'] ?>">
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
    function confirmDelete(idSiswa) {
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
                window.location.href = "<?php echo base_url('admin/action_delete_siswa/'); ?>" + idSiswa;
            }
        });
    }
</script>


<?= $this->endSection() ?>