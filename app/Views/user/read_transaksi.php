<?= $this->extend('user/template') ?>

<?= $this->section('content') ?>

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Data Transaksi</h6>
            <button type="button" class="btn btn-primary" onclick="window.location.href='<?php echo base_url('user/create_transaksi'); ?>'">Tambah Transaksi</button>
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
                        <th>Nominal Transaksi</th>
                        <th>Catatan</th>
                        <th>Status</th>
                        <th>Bukti</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($transaksis as $trx) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>Rp <?= number_format($trx['nominal_transaksi'], 0, ',', '.') ?></td>
                            <td><?= $trx['catatan_transaksi'] ?></td>
                            <?php if ($trx['id_status_transaksi'] == 1) : ?>
                                <td><span class="badge bg-warning">Pending</span></td>
                            <?php elseif ($trx['id_status_transaksi'] == 2) : ?>
                                <td><span class="badge bg-success">Completed</span></td>
                            <?php elseif ($trx['id_status_transaksi'] == 3) : ?>
                                <td><span class="badge bg-danger">Cancel</span></td>
                            <?php endif; ?>

                            <?php if (empty($trx['bukti_transaksi'])) : ?>
                                <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadBuktiModal" data-id="<?= $trx['id_transaksi'] ?>">Upload Bukti</button></td>
                            <?php else : ?>
                                <td>-</td>
                            <?php endif; ?>

                            <td><?= date('Y-m-d H:i:s', strtotime($trx['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<!-- Modal Upload Bukti Transaksi -->
<!-- Modal Upload Bukti Transaksi -->
<div class="modal fade" id="uploadBuktiModal" tabindex="-1" aria-labelledby="uploadBuktiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadBuktiModalLabel">Upload Bukti Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadBuktiForm" action="<?php echo base_url('user/upload_bukti'); ?>" method="POST" enctype="multipart/form-data">
                    <!-- Input hidden untuk ID transaksi -->
                    <input type="hidden" id="idTransaksi" name="id_transaksi" value="">

                    <!-- Input untuk memilih file -->
                    <div class="mb-3">
                        <label for="buktiTransaksi" class="form-label">Pilih Bukti Transaksi</label>
                        <input type="file" class="form-control" id="buktiTransaksi" name="bukti_transaksi" accept="image/*,application/pdf" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Upload Bukti Transaksi -->

<!-- End Modal Upload Bukti Transaksi -->
<script>
    // Mendengarkan event ketika modal ditampilkan
    var uploadBuktiModal = document.getElementById('uploadBuktiModal');
    uploadBuktiModal.addEventListener('show.bs.modal', function(event) {
        // Mendapatkan tombol yang memicu modal
        var button = event.relatedTarget;

        // Mendapatkan ID transaksi dari atribut data-id
        var transaksiId = button.getAttribute('data-id');

        // Menyimpan ID transaksi ke input hidden dalam modal
        var modalInput = document.getElementById('idTransaksi');
        modalInput.value = transaksiId;
    });
</script>


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