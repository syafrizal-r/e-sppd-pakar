<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'e-SPPD Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f4f6f9;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            min-height: 100vh;
            width: 250px;
            background-color: #198754;
            /* Hijau khas dinas */
            color: #fff;
            position: fixed;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            color: #d1e7dd;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #146c43;
            color: #fff;
            border-left: 4px solid #fff;
        }

        /* Content Area */
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }

        /* Navbar */
        .top-navbar {
            background-color: #fff;
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h4 class="fw-bold mb-0">e-SPPD DPKP</h4>
            <small>Provinsi Sumatera Utara</small>
        </div>
        <div class="mt-3">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text me-2"></i> Form Pengajuan SPJ
            </a>
            <a href="{{ route('riwayat.spj') }}" class="{{ request()->is('riwayat-spj') ? 'active' : '' }}">
                <i class="bi bi-clock-history me-2"></i> Riwayat & Kuitansi
            </a>

            <a href="{{ route('spt.index') }}" class="{{ request()->is('spt*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-check-fill me-2"></i> Dokumen SPT
            </a>

            <a href="{{ route('pegawai.index') }}" class="{{ request()->is('pegawai*') ? 'active' : '' }}">
                <i class="bi bi-people-fill me-2"></i> Master Data Pegawai
            </a>

            <a href="{{ route('sbm.index') }}" class="{{ request()->is('sbm*') ? 'active' : '' }}">
                <i class="bi bi-database-gear me-2"></i> Master Data SBM
            </a>
        </div>
    </div>

    <div class="content">
        <div class="top-navbar">
            <h5 class="mb-0 text-secondary fw-bold">@yield('title', 'Dashboard')</h5>
            <div>
                <span class="me-3 text-muted"><i class="bi bi-person-circle"></i> Admin Pengelola Keuangan</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right"></i>
                        Logout</button>
                </form>
            </div>
        </div>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
