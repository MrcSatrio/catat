<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>


<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-line fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Pemasukan Hari Ini</p>
                    <h6 class="mb-0"><?= 'Rp ' . number_format($pemasukanharian, 0, ',', '.') ?>
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-bar fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Pemasukan Bulan Ini</p>
                    <h6 class="mb-0"><?= 'Rp ' . number_format($pemasukanbulanan, 0, ',', '.') ?>
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-area fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Pengeluaran Hari Ini</p>
                    <h6 class="mb-0"><?= 'Rp ' . number_format($pengeluaranharian, 0, ',', '.') ?>
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-pie fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Pengeluaran Bulan Ini</p>
                    <h6 class="mb-0"><?= 'Rp ' . number_format($pengeluaranbulanan, 0, ',', '.') ?>
                    </h6>
                </div>
            </div>
        </div>
        <h6 class="mb-0">Transaksi Pending</h6>
        <div class="table-responsive">
            <table id="tableTransaksi" class="display">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Nominal Transaksi</th>
                        <th>Catatan</th>
                        <th>Bukti</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>

                    <tr>
                        <?php foreach ($transaksipending as $transaksi) : ?>
                            <td><?= $i++ ?></td>
                            <td><?= $transaksi['nama_siswa'] ?></td>
                            <td><?= 'Rp ' . number_format($transaksi['nominal_transaksi'], 0, ',', '.') ?></td>
                            <td><?= $transaksi['catatan_transaksi'] ?></td>
                            <td>
                                <a href="<?php echo base_url('bukti/' . urlencode($transaksi['bukti_transaksi'])) ?>" target="_blank">Lihat Bukti Transaksi</a>

                            </td>
                            <td><?= $transaksi['created_at'] ?></td>
                            <td>
                                <a href="<?= base_url() ?>admin/verifikasi/<?= $transaksi['id_transaksi'] ?>" class="btn btn-primary">Verifikasi</a>
                            </td>
                        <?php endforeach; ?>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
</div>


<script>
    // Inisialisasi DataTable setelah dokumen siap
    $(document).ready(function() {
        $('#tableTransaksi').DataTable();
    });
</script>

<?= $this->endSection() ?>