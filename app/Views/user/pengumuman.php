<?= $this->extend('user/template') ?>

<?= $this->section('content') ?>
<style>
    #pdf-container {
        width: 100%;
        height: 600px;
        border: 1px solid #ccc;
        overflow: auto;
    }
</style>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div id="pdf-container"></div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>

<script>
    const url = '<?php echo base_url(); ?>assets/pdf/<?php echo $pengumuman['nama_pengumuman']; ?>'; // Ganti dengan URL file PDF Anda

    // Fungsi untuk memuat dan menampilkan PDF
    function renderPDF(url) {
        // Memuat PDF menggunakan pdf.js
        pdfjsLib.getDocument(url).promise.then(function(pdf) {
            console.log('PDF loaded');
            
            // Menentukan jumlah halaman PDF
            const totalPages = pdf.numPages;
            console.log('Total Pages: ' + totalPages);

            // Menentukan skala tampilan
            const scale = 1.5;

            // Fungsi untuk menggambar halaman pada canvas
            function renderPage(pageNumber) {
                pdf.getPage(pageNumber).then(function(page) {
                    console.log('Page ' + pageNumber + ' loaded');

                    // Menentukan ukuran tampilan
                    const viewport = page.getViewport({ scale: scale });

                    // Menyiapkan elemen canvas untuk menggambar PDF
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    // Menambahkan canvas ke container PDF
                    document.getElementById('pdf-container').appendChild(canvas);

                    // Menggambar halaman ke dalam canvas
                    page.render({
                        canvasContext: context,
                        viewport: viewport
                    });
                });
            }

            // Memuat dan menggambar semua halaman PDF
            for (let pageNum = 1; pageNum <= totalPages; pageNum++) {
                renderPage(pageNum);
            }

        }).catch(function(error) {
            console.error('Error loading PDF: ' + error);
        });
    }

    // Memanggil fungsi untuk menampilkan PDF
    renderPDF(url);
</script>

<?= $this->endSection() ?>
