<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Data Kelas</h6>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">Tambah Kelas</button>
        </div>
        <div class="table-responsive">
            <table id="tableSiswa" class="display">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($kelas as $kelasItem) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $kelasItem['nama_kelas'] ?></td>
                            <td>
                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditKelas<?= $kelasItem['id_kelas'] ?>">Edit</button>
                                <!-- Tombol Hapus -->
                                <button type="button" class="btn btn-danger" onclick="confirmDelete(<?= $kelasItem['id_kelas'] ?>)">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Kelas -->
<div class="modal fade" id="modalTambahKelas" tabindex="-1" aria-labelledby="modalTambahKelasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahKelasLabel">Form Tambah Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url(); ?>/admin/action_tambah_kelas" id="formTambahKelas" method="post">
                    <div class="form-group">
                        <label for="namaSiswa">Nama Kelas</label>
                        <input type="text" class="form-control" id="namaKelas" name="kelas" placeholder="Masukkan nama kelas">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="submitkelas">Tambah Kelas</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kelas (Untuk Setiap Kelas) -->
<?php foreach ($kelas as $kelasItem) : ?>
<div class="modal fade" id="modalEditKelas<?= $kelasItem['id_kelas'] ?>" tabindex="-1" aria-labelledby="modalEditKelasLabel<?= $kelasItem['id_kelas'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditKelasLabel<?= $kelasItem['id_kelas'] ?>">Edit Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url(); ?>/admin/action_edit_kelas" method="post">
                    <div class="form-group">
                        <label for="namaKelasEdit">Nama Kelas</label>
                        <input type="text" class="form-control" id="namaKelasEdit" name="kelas" value="<?= $kelasItem['nama_kelas'] ?>" required>
                        <input type="hidden" name="id_kelas" value="<?= $kelasItem['id_kelas'] ?>">
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
    function confirmDelete(idKelas) {
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
                window.location.href = "<?php echo base_url('admin/action_delete_kelas/'); ?>" + idKelas;
            }
        });
    }
</script>

<?= $this->endSection() ?>
