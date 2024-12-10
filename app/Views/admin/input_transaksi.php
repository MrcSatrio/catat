<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-left rounded p-2">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Input Transaksi</h6>
        </div>
        <form action="<?php echo base_url(); ?>admin/action_input_transaksi" method="post" enctype="multipart/form-data">
            <div class="mb-6">
                <label for="exampleFormControlInput1" class="form-label">Jenis Transaksi</label>
                <select class="form-select" aria-label="Default select example" name="id_jenis_transaksi" id="id_jenis_transaksi">
                    <option selected>Pilih Jenis Transaksi</option>
                    <?php foreach ($jenis_transaksi as $tjenistransaksi) : ?>
                        <option value="<?= $tjenistransaksi['id_jenis_transaksi'] ?>"><?= $tjenistransaksi['nama_jenis_transaksi'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-6">
                <label for="exampleFormControlInput1" class="form-label">Nama Siswa</label>
                <select class="form-select" aria-label="Default select example" name="id_siswa" id="id_siswa">
                    <option selected value="">Pilih Siswa</option>
                    <?php foreach ($siswa as $transaksiswa) : ?>
                        <option value="<?= $transaksiswa['id_siswa'] ?>"><?= $transaksiswa['nama_siswa'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Nominal Transaksi</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="nominal" placeholder="Nominal Transaksi" oninput="formatRupiah(event)">
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">Bukti Transaksi</label>
                <input class="form-control" type="file" id="formFile" name="bukti">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Catatan</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="catatan"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
<script>
    // Fungsi untuk memformat angka menjadi format Rupiah
    function formatRupiah(event) {
        let input = event.target;
        let value = input.value;

        // Menghapus semua karakter non-numerik, kecuali angka
        let rawValue = value.replace(/[^0-9]/g, '');

        // Format menjadi Rupiah
        let formattedValue = '';
        let remaining = rawValue;

        // Mengelompokkan angka dalam ribuan
        while (remaining.length > 3) {
            formattedValue = '.' + remaining.slice(-3) + formattedValue;
            remaining = remaining.slice(0, remaining.length - 3);
        }

        // Menambahkan sisa angka di depan
        if (remaining) {
            formattedValue = remaining + formattedValue;
        }

        // Menambahkan prefix 'Rp.' jika belum ada
        input.value = formattedValue ? 'Rp ' + formattedValue : '';
    }

    // Fungsi untuk menghapus format dan mengirimkan nilai murni saat form disubmit
    document.querySelector('form').addEventListener('submit', function(event) {
        let nominalInput = document.querySelector('input[name="nominal"]');
        let formattedValue = nominalInput.value;

        // Menghapus karakter "Rp" dan titik yang digunakan untuk format Rupiah
        let rawValue = formattedValue.replace(/[^0-9]/g, '');

        // Menyimpan nilai murni (angka) kembali ke input sebelum form disubmit
        nominalInput.value = rawValue; // Menyimpan hanya angka untuk dikirimkan

        console.log("Nominal yang akan dikirim: " + rawValue); // Cek nilai yang akan dikirim
    });
</script>
<script>
    // Ambil elemen yang dibutuhkan
    const jenisTransaksiSelect = document.getElementById('id_jenis_transaksi');
    const siswaSelect = document.getElementById('id_siswa');

    // Fungsi untuk mengubah status 'required' berdasarkan jenis transaksi yang dipilih
    function toggleRequired() {
        if (jenisTransaksiSelect.value == '1') { // Jika 'id_jenis_transaksi' = 1
            siswaSelect.setAttribute('required', true); // Set 'required'
        } else if (jenisTransaksiSelect.value == '2') { // Jika 'id_jenis_transaksi' = 2
            siswaSelect.removeAttribute('required'); // Hapus 'required'
        }
    }

    // Event listener untuk menangani perubahan pada 'id_jenis_transaksi'
    jenisTransaksiSelect.addEventListener('change', toggleRequired);

    // Jalankan fungsi ketika halaman pertama kali dimuat untuk memastikan kondisi awal
    toggleRequired();
</script>










<?= $this->endSection() ?>