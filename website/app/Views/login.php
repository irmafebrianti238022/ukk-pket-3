<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SuaraSekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container">
    <div class="row min-vh-100 align-items-center justify-content-center">
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            
            <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 1.5rem;">
                
                <div class="card-header bg-primary bg-gradient text-white text-center py-5 border-0 position-relative">
                    <h3 class="fw-bold mb-1">Administrator</h3>
                    <p class="small mb-0 opacity-75">Control Panel Access</p>
                    
                    <div class="position-absolute start-50 translate-middle-x bg-white text-primary rounded-4 shadow d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; bottom: -30px;">
                        <i class="bi bi-shield-lock-fill fs-3"></i>
                    </div>
                </div>

                <div class="card-body p-4 pt-5">
                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger small"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>
                    
                    <form action="<?= base_url('auth/proses_login') ?>" method="post" class="mt-2">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" name="username" class="form-control bg-light border-start-0 ps-0" placeholder="Username" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-secondary">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted">
                                    <i class="bi bi-key"></i>
                                </span>
                                <input type="password" name="password" class="form-control bg-light border-start-0 ps-0" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary py-3 fw-bold rounded-3 shadow-sm border-0 bg-gradient">
                                MASUK SEKARANG
                            </button>
                        </div>
                    </form>
                </div>
            </div>
             <div class="text-center mt-4">
                <a href="<?= base_url('login-siswa') ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3 border-0">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard Siswa
                </a>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
//echo password_hash('121212', PASSWORD_DEFAULT);
?>
