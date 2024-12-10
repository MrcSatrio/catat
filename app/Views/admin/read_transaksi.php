<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Data Transaksi</h6>
            <button type="button" class="btn btn-primary" onclick="window.location.href='<?php echo base_url('admin/input_transaksi'); ?>'">Tambah Transaksi</button>
        </div>
        <div class="table-responsive">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="minDate">Tanggal Mulai</label>
                    <input type="date" id="minDate" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label for="maxDate">Tanggal Akhir</label>
                    <input type="date" id="maxDate" class="form-control" />
                </div>
                <div class="col-md-4">
                    <button id="filterDate" class="btn btn-primary mt-4">Filter</button>
                </div>
            </div>
            <table id="tableTransaksi" class="display">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Transaksi</th>
                        <th>Nominal Transaksi</th>
                        <th>Nama</th>
                        <th>Catatan</th>
                        <th>Status</th>
                        <th>Bukti</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($transaksi as $trx) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <?php if ($trx['id_jenis_transaksi'] == 1) : ?>
                                <td><span class="badge bg-primary"><i class="fa fa-arrow-up me-2">Pemasukan</span></td>
                            <?php elseif ($trx['id_jenis_transaksi'] == 2) : ?>
                                <td><span class="badge bg-danger"><i class="fa fa-arrow-down me-2">Pengeluaran</span></td>
                            <?php endif; ?>
                            <td>Rp <?= number_format($trx['nominal_transaksi'], 0, ',', '.') ?></td>
                            <?php if (empty($trx['id_siswa'])) : ?>
                                <td>-</td>
                            <?php else : ?>
                                <td><?= $trx['nama_siswa'] ?></td>
                            <?php endif; ?>
                            <td><?= $trx['catatan_transaksi'] ?></td>
                            <?php if ($trx['id_status_transaksi'] == 1) : ?>
                                <td><span class="badge bg-warning">Pending</span></td>
                            <?php elseif ($trx['id_status_transaksi'] == 2) : ?>
                                <td><span class="badge bg-success">Completed</span></td>
                            <?php elseif ($trx['id_status_transaksi'] == 3) : ?>
                                <td><span class="badge bg-danger">Cancel</span></td>
                            <?php endif; ?>
                            <?php if (empty($trx['bukti_transaksi'])) : ?>
                                <td>-</td>
                            <?php else : ?>
                                <td><a href="<?php echo base_url('bukti/' . $trx['bukti_transaksi']) ?>" class="btn btn-primary">Lihat Bukti</a></td>
                            <?php endif; ?>
                            <td><?= date('Y-m-d H:i:s', strtotime($trx['created_at'])) ?></td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var table = $('#tableTransaksi').DataTable({
            dom: 'Bfrtip', // Mengaktifkan tombol
            buttons: [{
                    extend: 'excelHtml5',
                    title: 'Data Transaksi', // Judul file Excel
                    text: 'Export ke Excel',
                    className: 'btn btn-success' // Tambahkan gaya ke tombol
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Data Transaksi', // Judul file PDF
                    text: 'Export ke PDF',
                    className: 'btn btn-danger', // Tambahkan gaya ke tombol
                    orientation: 'landscape', // Orientasi landscape untuk PDF
                    pageSize: 'A4', // Ukuran halaman PDF
                    customize: function(doc) {
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    }
                },
                {
                    extend: 'print',
                    title: 'Data Transaksi',
                    text: 'Print',
                    className: 'btn btn-primary' // Tombol cetak
                }
            ]
        });


        // Custom filter function for date range filtering
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var minDate = $('#minDate').val();
            var maxDate = $('#maxDate').val();
            var date = data[7]; // Index kolom tanggal

            if (minDate && date < minDate) {
                return false;
            }
            if (maxDate && date > maxDate) {
                return false;
            }
            return true;
        });

        // Apply the date filter on button click
        $('#filterDate').click(function() {
            table.draw();
        });

        // Reset filter when date inputs are cleared
        $('#minDate, #maxDate').on('change', function() {
            if ($('#minDate').val() === '' && $('#maxDate').val() === '') {
                $.fn.dataTable.ext.search.pop(); // Remove custom filter
                table.draw();
            }
        });
    });
</script>

<?= $this->endSection() ?>