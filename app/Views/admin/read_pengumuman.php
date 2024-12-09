<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Data Pengumuman</h6>
        </div>
        <div class="table-responsive">
            <table id="tableSiswa" class="display">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pengumuman</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pengumuman as $pm) : ?>
                        <tr>
                            <td><?= $pm['id_pengumuman'] ?></td>
                            <td><a href="<?php echo base_url('/assets/pdf/' . $pm['nama_pengumuman']); ?>" class="btn btn-primary">Download</a></td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditSiswa<?= $pm['id_pengumuman'] ?>">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach ($pengumuman as $pm) : ?>
    <div class="modal fade" id="modalEditSiswa<?= $pm['id_pengumuman'] ?>" tabindex="-1" aria-labelledby="modalEditSiswaLabel<?= $pm['id_pengumuman'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditSiswaLabel<?= $pm['id_pengumuman'] ?>">Edit Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url(); ?>/admin/action_edit_pengumuman" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="namaKelasEdit">Pengumuman</label>
                            <input type="file" class="form-control" id="pengumuman" name="pengumuman" value="<?= $pm['id_pengumuman'] ?>" accept="application/pdf" required>
                        </div>
                        <input type="hidden" name="id_pengumuman" value="<?= $pm['id_pengumuman'] ?>">
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