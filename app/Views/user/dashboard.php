<?= $this->extend('user/template') ?>

<?= $this->section('content') ?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <marquee behavior="alternate" direction="left">Halo, selamat datang, Bapak/Ibu orang tua dari <?php echo $userData['nama_siswa']; ?></marquee>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-money-bill fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Pembayaran Semester Ini</p>
                    <h6 class="mb-0">
                        <?php
                        $currentMonth = date('m'); // Mendapatkan bulan saat ini
                        if ($currentMonth >= 1 && $currentMonth <= 6) {
                            // Jika bulan Januari hingga Juni, tampilkan semestergenap
                            echo 'Rp ' . number_format($semestergenap, 0, ',', '.');
                        } else if ($currentMonth >= 7 && $currentMonth <= 12) {
                            // Jika bulan Juli hingga Desember, tampilkan semesterganjil
                            echo 'Rp ' . number_format($semesterganjil, 0, ',', '.');
                        }
                        ?>
                    </h6>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-file-invoice fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Sisa Tagihan Semester Ini</p>
                    <h6 class="mb-0">
                        <?php
                        $currentMonth = date('m'); // Mendapatkan bulan saat ini
                        if ($currentMonth >= 1 && $currentMonth <= 6) {
                            // Jika bulan Januari hingga Juni, tampilkan semestergenap
                            echo 'Rp ' . number_format($tagihangenap, 0, ',', '.');
                        } else if ($currentMonth >= 7 && $currentMonth <= 12) {
                            // Jika bulan Juli hingga Desember, tampilkan semesterganjil
                            echo 'Rp ' . number_format($tagihanganjil, 0, ',', '.');
                        }
                        ?>
                    </h6>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>