<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>AL-IDRUS PAY</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="Sistem Pembayaran Pondok Pesantren AL-IDRUS" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css" rel="stylesheet">


    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?php echo base_url(); ?>assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="<?php echo base_url(); ?>admin/dashboard" class="navbar-brand mx-4 mb-3">
                    <img class="img-fluid" src="<?php echo base_url(); ?>assets/img/alipay.png" alt="" style="width: 200px; height: 150px;">
                </a>
                <div class="navbar-nav w-100">
                    <a href="<?php echo base_url(); ?>admin/dashboard" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-user me-2"></i>Siswa</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="<?php echo base_url(); ?>admin/read_siswa" class="dropdown-item">Data Siswa</a>
                            <a href="<?php echo base_url(); ?>admin/read_kelas" class="dropdown-item">Data Kelas</a>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>admin/read_user" class="nav-item nav-link"><i class="fa fa-users me-2"></i>Pengguna</a>
                    <a href="<?php echo base_url(); ?>admin/read_transaksi" class="nav-item nav-link"><i class="fa fa-money-bill me-2"></i>Transaksi</a>
                    <a href="<?php echo base_url(); ?>admin/read_pengumuman" class="nav-item nav-link"><i class="fa fa-newspaper me-2"></i>Pengumuman</a>



                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="https://img.freepik.com/free-vector/user-blue-gradient_78370-4692.jpg?t=st=1731381373~exp=1731384973~hmac=d040ab2177a91ab6fa7b10f65ca7b6c9e414b4b7a84273912222af68ea844c3b&w=1480" alt="" style="width: 40px; height: 40px; margin-top: -15px;">
                            <span class="d-none d-lg-inline-flex"><?php echo session()->get('nama'); ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="<?php echo base_url(); ?>logout" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <?= $this->renderSection('content') ?>
            <!-- Content End -->

            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">al - idrus pay</a>, All Right Reserved.
                        </div>
                    </div>
                </div>
            </div>
            <!-- Back to Top -->
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        </div>

        <!-- JavaScript Libraries -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/lib/chart/chart.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/lib/easing/easing.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/lib/waypoints/waypoints.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/lib/tempusdominus/js/moment.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Template Javascript -->
        <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
        <?php if (session()->getFlashdata('error')) : ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?= session()->getFlashdata('error') ?>'
                });
            </script>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')) : ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '<?= session()->getFlashdata('success') ?>'
                });
            </script>
        <?php endif; ?>
</body>

</html>