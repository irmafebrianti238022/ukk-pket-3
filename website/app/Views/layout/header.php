<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - SuaraSekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { width: 260px; min-height: 100vh; background: #ffffff; border-right: 1px solid #dee2e6; position: fixed; }
        .main-content { margin-left: 260px; width: calc(100% - 260px); }
        .nav-link { color: #495057; border-radius: 8px; margin: 4px 15px; font-weight: 500; transition: 0.3s; }
        .nav-link.active { background-color: #0d6efd !important; color: white !important; }
        .nav-link:hover:not(.active) { background-color: #f8f9fa; color: #0e60db; transform: translateX(5px);} */
        .nav-link.text-danger:hover {background-color: #fdfdfd;}
        .table-container { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05); }
        .card-filter { border: none; border-radius: 15px; background: white; }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column flex-shrink-0 p-3 shadow-sm">
    <a href="" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none px-3">
        <i class="bi bi-shield-lock-fill text-primary fs-3 me-2"></i>
        <span class="fs-4 fw-bold text-primary">AdminPanel</span>
    </a>
    <hr>

    <ul class="nav nav-pills flex-column mb-4">
        <li class="nav-item">
            <small class="text-muted ms-3 mb-2 d-block fw-bold text-uppercase" style="font-size: 11px;">Menu Utama</small>
            <a href="dashboard" class="nav-link mb-1"><i class="bi bi-chat-left-dots me-2"></i> Kelola Aspirasi</a>
        </li>
    </ul>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <small class="text-muted ms-3 mb-2 d-block fw-bold text-uppercase" style="font-size: 11px;">Data Master</small>
            <a href="siswa" class="nav-link mb-1"><i class="bi bi-people me-2"></i> Kelola Siswa</a>
            <a href="kategori" class="nav-link mb-1"><i class="bi bi-tags me-2"></i> Kelola Kategori</a>
        </li>
    </ul>
    
    <hr>
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a href="<?= base_url('logout') ?>" class="nav-link text-danger fw-bold" onclick="return confirm('Apakah anda yakin ingin keluar?')">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </li>
    </ul>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<!-- getfalsdata -->
<script>
    window.setTimeout(function() {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 2000); 
</script>
</html>