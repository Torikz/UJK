<!DOCTYPE html>
<html lang="id">
<head>
    <title>Sistem Klinik SPA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .sidebar {
            width: 250px;
            min-height: 100vh;
        }
        /* Warna text menu default (putih agak redup) */
        .nav-pills .nav-link {
            color: rgba(255, 255, 255, 0.85); 
            margin-bottom: 5px;
            font-weight: 500;
        }
        /* Efek saat mouse diarahkan (hover) */
        .nav-pills .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }
        /* Efek saat menu diklik/aktif (background putih, tulisan biru) */
        .nav-pills .nav-link.active {
            background-color: #ffffff !important;
            color: var(--bs-primary) !important;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-light">

<div class="d-flex">

    <div class="sidebar bg-primary text-white p-3 d-flex flex-column shadow">
        <h4 class="text-center mb-0 mt-2 fw-bold">Klinik App</h4>
        <hr class="border-light opacity-50">
        
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a class="nav-link menu-link" href="#" data-url="<?= base_url('pasien') ?>">
                    Pasien
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link menu-link" href="#" data-url="<?= base_url('pendaftaran') ?>">
                    Pendaftaran
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link menu-link" href="#" data-url="<?= base_url('kunjungan') ?>">
                    Kunjungan (Poli)
                </a>
            </li>

            <?php if(session('role') != 'admisi'): ?>
            <li class="nav-item">
                <a class="nav-link menu-link" href="#" data-url="<?= base_url('asesmen') ?>">
                    Asesmen
                </a>
            </li>
            <?php endif; ?>
        </ul>

        <hr class="border-light opacity-50">
        <div class="text-center">
            <span class="d-block mb-2 text-white">Role: <?= strtoupper(session('role')) ?></span>
            <a href="<?= base_url('auth/logout') ?>" class="btn btn-light btn-sm w-100 text-danger fw-bold">Logout</a>
        </div>
    </div>

    <div class="flex-grow-1 p-4">
        <div class="container-fluid" id="main-content">
            <div class="alert alert-info shadow-sm">Selamat Datang! Silahkan pilih menu di samping.</div>
        </div>
    </div>

</div>

<div class="modal fade" id="globalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Logika SPA tetap sama
        $('.menu-link').click(function(e) {
            e.preventDefault();
            let url = $(this).data('url');
            
            // Atur class active untuk menu yang diklik
            $('.menu-link').removeClass('active');
            $(this).addClass('active');
            
            $('#main-content').html('<div class="text-center mt-5"><div class="spinner-border text-primary"></div><p class="mt-2">Loading...</p></div>');
            
            $('#main-content').load(url, function(response, status, xhr) {
                if (status == "error") {
                    $('#main-content').html('<div class="alert alert-danger">Gagal memuat halaman: ' + xhr.status + '</div>');
                }
            });
        });
    });
</script>

</body>
</html>