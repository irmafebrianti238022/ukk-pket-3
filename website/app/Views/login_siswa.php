<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SuaraSekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: #f0f4f9; height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
        .card-login { border: none; border-radius: 20px; width: 400px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .icon-box { background: #0d6efd; color: white; width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; margin: -30px auto 20px; box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4); }
        .form-control { border-radius: 10px; padding: 12px; border: 1px solid #e0e0e0; }
        .btn-primary { border-radius: 10px; padding: 12px; font-weight: 600; background: #0d6efd; border: none; }
    </style>
</head>
<body>
    <div class="card card-login">
        <div class="card-body p-4">
            <div class="icon-box"><i class="bi bi-person-fill fs-3"></i></div>
            <div class="text-center mb-4">
                <h4 class="fw-bold m-0">Login Siswa</h4>
                <p class="text-muted small">Sampaikan aspirasimu sekarang</p>
            </div>
            <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger small"><?= session()->getFlashdata('error') ?></div>
             <?php endif; ?>
             <form action="<?= base_url('auth/proses_login_siswa') ?>" method="post">
                <div class="mb-3">
                    <label class="form-label small fw-bold">NIS (Nomor Induk Siswa)</label>
                     <input type="text" name="nis" class="form-control" placeholder="Masukkan NIS" required>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Kelas</label>
                    <input type="text" name="kelas" class="form-control" placeholder="Contoh: 12RPL" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 shadow-sm">Masuk Sekarang</button>
            </form>
              <div class="text-center mt-4">
                <a href="<?= base_url('/') ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3 border-0">
                    <i class="bi bi-arrow-right me-1"></i> Kembali ke Dashboard admin
                </a>
            </div>
        </div>
    </div>
</body>
</html>