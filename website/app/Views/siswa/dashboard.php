<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa - SuaraSekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f4f7fe;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar-custom {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .card-form {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .card-history {
            border: none;
            border-radius: 20px;
            background: white;
        }

        .status-badge {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 6px 12px;
            border-radius: 8px;
        }

        .btn-send {
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->

    <nav class="navbar navbar-expand-lg navbar-custom py-3 mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 text-primary" href="#"><i class="bi bi-megaphone-fill me-2"></i>SuaraSekolah</a>
            <div class="d-flex align-items-center">
                <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('Keluar dari aplikasi?')">
                    <i class="bi bi-box-arrow-right me-1"></i> Keluar
                </a>
            </div>
        </div>
    </nav>
    <div class="container mt-4 mb-4">
        <div class="card border-0 bg-primary text-white shadow-sm" style="border-radius: 20px; background: linear-gradient(135deg, #0d6efd, #0dcaf0);">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="me-3 d-none d-md-block">
                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-person-check-fill text-primary fs-3"></i>
                    </div>
                </div>
                <div>
                    <h4 class="fw-bold m-0">Halo, Selamat Datang <?= session()->get('nama'); ?>! 👋</h4>
                    <p class="m-0 opacity-75 small">Ada aspirasi untuk sekolah kita hari ini?</p>
                </div>
            </div>
        </div>
    </div>

    <!-- INPUT ASPIRASI -->

    <div class="container pb-5">
        <?php if (session()->getFlashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif; ?>
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="card card-form p-4 h-100">
                    <div class="mb-4 text-center text-lg-start">
                        <h4 class="fw-bold">Sampaikan Aspirasimu</h4>
                        <p class="text-muted small">Suaramu membantu sekolah jadi lebih baik!</p>
                    </div>
                    <form action="<?= base_url('siswa/simpan') ?>" method="POST">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Kategori Laporan</label>
                            <select name="id_kategori" class="form-select bg-light border-0 py-2" required>
                                <option value="" selected disabled>Pilih Kategori...</option>
                                <?php foreach ($kategori as $k): ?>
                                    <option value="<?= $k['id_kategori'] ?>"><?= $k['ket_kategori'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Lokasi Kejadian</label>
                            <input type="text" name="lokasi" class="form-control bg-light border-0 py-2" placeholder="Contoh: Kantin, Kelas XI RPL 2" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Keterangan Laporan</label>
                            <textarea name="ket" class="form-control bg-light border-0" rows="5" placeholder="Ceritakan detail aspirasi atau keluhanmu..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-send shadow-sm">
                            <i class="bi bi-send-fill me-2"></i> Kirim Aspirasi
                        </button>
                    </form>
                </div>
            </div>

            <!-- RIWAYAT ASPIRASI -->

            <div class="col-lg-7">
                <div class="row g-5">
                    <div class="card card-history p-4 shadow-sm h-100">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold m-0">Riwayat Aspirasi Anda</h5>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 small text-muted">TANGGAL</th>
                                        <th class="border-0 small text-muted">KATEGORI</th>
                                        <th class="border-0 small text-muted">STATUS</th>
                                        <th class="border-0 small text-muted text-center">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($aspirasi)): foreach ($aspirasi as $row): ?>
                                            <tr>
                                                <td class="small">
                                                    <div class="fw-bold text-dark">
                                                        <?= date('d/m/Y', strtotime($row['created_at'])) ?>
                                                    </div>
                                                    <?php if ($row['updated_at'] != $row['created_at'] && !empty($row['updated_at'])): ?>
                                                        <div class="text-muted" style="font-size: 0.7rem;">
                                                             Edit: <?= date('d/m/Y H:i', strtotime($row['updated_at'])) ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td><span class="text-secondary small"><?= $row['kategori']; ?></span></td>
                                                <td>
                                                    <?php
                                                    $status = $row['status'] ?? 'Menunggu';
                                                    $warna = 'status-badge bg-danger-subtle text-danger';
                                                    if ($status == 'Proses') $warna = 'status-badge bg-warning-subtle text-warning';
                                                    if ($status == 'Selesai') $warna = 'status-badge bg-success-subtle text-success';
                                                    ?>
                                                    <span class="badge <?= $warna ?>"><?= $status ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-light btn-sm rounded-pill px-3 border" data-bs-toggle="modal" data-bs-target="#viewTanggapan<?= $row['id_pelaporan']; ?>">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-light btn-outline-secondary btn-sm rounded-pill px-3 border"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalOpsi<?= $row['id_pelaporan']; ?>">
                                                        <i class="bi bi-gear-fill"></i>
                                                    </button>
                                                    <?php
                                                    // Logika penentuan status manual
                                                    if (empty($row['feedback']) || $row['feedback'] == '-') {
                                                        $status = 'Menunggu';
                                                        $warna  = 'bg-danger-subtle text-danger';
                                                    } else {
                                                        $status = 'Selesai';
                                                        $warna  = 'bg-success-subtle text-success';
                                                    }
                                                    ?>
                                                <td>
                                                    <?php if ($status == 'Menunggu') : ?>
                                                    <?php endif; ?>
                                                </td>
                                                </td>
                                            </tr>
                                        <?php endforeach;
                                    else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted small py-4">Belum ada aspirasi.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL TANGGAPAN -->

        <?php foreach ($aspirasi as $row): ?>
            <div class="modal fade" id="viewTanggapan<?= $row['id_pelaporan']; ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                        <div class="modal-header border-0 pt-4 px-4">
                            <h5 class="fw-bold text-primary">Status Tanggapan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4 pt-0">
                            <div class="mb-4">
                                <label class="small text-muted fw-bold mb-1">LAPORAN ANDA:</label>
                                <p class="p-3 bg-light rounded-3 small">"<?= $row['ket']; ?>"</p>
                            </div>
                            <div class="mb-1">
                                <label class="small text-muted fw-bold mb-1">TANGGAPAN ADMIN:</label>
                                <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3 small">
                                    <?php if ($row['feedback'] !== '-'): ?>
                                        <strong>Admin:</strong> "<?= $row['feedback']; ?>"
                                    <?php else: ?>
                                        <em class="text-muted small">Belum ada tanggapan dari admin.</em>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pb-4 px-4">
                            <button type="button" class="btn btn-dark w-100 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL EDIT -->

            <div class="modal fade" id="modalOpsi<?= $row['id_pelaporan']; ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                        <div class="modal-header border-0 pt-4 px-4">
                            <h5 class="fw-bold"><i class="bi bi-pencil-square me-2"></i>Kelola Aspirasi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <?php if (empty($row['feedback']) || $row['feedback'] == '-') : ?>

                            <form action="<?= base_url('siswa/ubah_aspirasi/' . $row['id_pelaporan']) ?>" method="POST">
                                <div class="modal-body px-4">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">KATEGORI</label>
                                        <select name="id_kategori" class="form-select border-2" required>
                                            <?php foreach ($kategori as $kat): ?>
                                                <option value="<?= $kat['id_kategori'] ?>" <?= ($kat['id_kategori'] == $row['id_kategori']) ? 'selected' : '' ?>>
                                                    <?= $kat['ket_kategori'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">LOKASI KEJADIAN</label>
                                        <input type="text" name="lokasi" class="form-control border-2" value="<?= $row['lokasi'] ?>" placeholder="Contoh: Kantin, Lab Komputer, dll" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">DESKRIPSI ASPIRASI</label>
                                        <textarea name="ket" class="form-control border-2" rows="4" required><?= $row['ket'] ?></textarea>
                                    </div>

                                    <hr class="my-4">
                                    <p class="text-muted small">Jika Anda ingin membatalkan laporan ini, silakan klik tombol hapus di bawah.</p>
                                    <a href="<?= base_url('siswa/hapus_aspirasi/' . $row['id_pelaporan']) ?>"
                                        class="btn btn-outline-danger w-100 mb-2"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus aspirasi ini? Tindakan ini tidak dapat dibatalkan.')">
                                        <i class="bi bi-trash me-1"></i> Hapus Aspirasi Ini
                                    </a>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary py-2 fw-bold shadow">Simpan Perubahan</button>
                                    </div>
                                </div>

                            </form>

                        <?php else : ?>
                            <div class="modal-body px-4 text-center pb-5">
                                <i class="bi bi-lock-fill text-warning" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 fw-bold">Laporan Terkunci</h5>
                                <p class="text-muted">Aspirasi ini sudah ditanggapi oleh Admin sehingga tidak dapat diubah atau dihapus lagi.</p>
                                <button type="button" class="btn btn-secondary w-100 mt-3" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    // Tunggu sampai dokumen selesai dimuat
    window.setTimeout(function() {
        // Cari elemen dengan class .alert
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            // Gunakan API Bootstrap untuk menutup alert secara halus
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 2000); // 3000 milidetik = 3 detik
</script>

</html>