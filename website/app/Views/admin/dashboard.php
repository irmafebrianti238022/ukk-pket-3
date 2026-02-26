<?= $this->include('layout/header.php') ?>

<style>
    /* Mengunci lebar tabel agar tidak melar */
    .table-fixed {
        table-layout: fixed;
        width: 100%;
    }

    /* Mengatur lebar kolom spesifik */
    .col-no {
        width: 50px;
    }

    .col-tgl {
        width: 120px;
    }

    .col-nama {
        width: 180px;
    }

    .col-nis {
        width: 100px;
    }

    .col-kategori {
        width: 150px;
    }

    .col-lokasi {
        width: 150px;
    }

    .col-status {
        width: 130px;
    }

    .col-aksi {
        width: 80px;
    }

    /* Memotong teks yang kepanjangan */
    .text-truncate-custom {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
        max-width: 100%;
    }
</style>
<div class="main-content p-4">
    <div class="container-fluid">
        <div class="mb-4">
            <h3 class="fw-bold text-dark">Manajemen Aspirasi Siswa</h3>
            <p class="text-muted">Pantau dan berikan tanggapan pada aspirasi yang masuk.</p>
        </div>

        <!-- Filter -->

        <div class="card card-filter shadow-sm mb-4">
            <div class="card-body p-4">
                <form action="" method="get">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-secondary">Cari NIS Siswa</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search small"></i></span>
                                <input type="text" name="nis" class="form-control bg-light border-start-0" placeholder="Ketik NIS..." value="<?= request()->getGet('nis') ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold text-secondary">Kategori</label>
                            <select name="kategori" class="form-select bg-light">
                                <option value="">lainnya</option>
                                <?php foreach ($kategori as $k): ?>
                                    <option value="<?= $k['id_kategori'] ?>" <?= request()->getGet('kategori') == $k['id_kategori'] ? 'selected' : '' ?>><?= $k['ket_kategori'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold text-secondary">Status</label>
                            <select name="status" class="form-select bg-light border-0 shadow-sm">
                                <option value="">Semua Status</option>
                                <option value="Menunggu" <?= request()->getGet('status') == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                                <option value="Proses" <?= request()->getGet('status') == 'Proses' ? 'selected' : '' ?>>Proses</option>
                                <option value="Selesai" <?= request()->getGet('status') == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold text-secondary">Pilih Tanggal</label>
                            <input type="date" name="tanggal" class="form-control bg-light" value="<?= request()->getGet('tanggal') ?>">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-filter me-1"></i> Filter</button>
                            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary fw-bold">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- table aspirasi  -->

        <?php if (session()->getFlashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif; ?>

        <div class="table-container border">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="col-no border-0 py-3 text-muted">NO</th>
                            <th class="col-tgl border-0 py-3 text-muted">TANGGAL</th>
                            <th class="col-nama border-0 py-3 text-muted">NAMA</th>
                            <th class="col-nis border-0 py-3 text-muted">NIS</th>
                            <th class="col-kategori border-0 py-3 text-muted">KATEGORI</th>
                            <th class="col-lokasi border-0 py-3 text-muted">LOKASI</th>
                            <th class="col-status border-0 py-3 text-muted text-center">STATUS</th>
                            <th class="col-aksi border-0 py-3 text-muted text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php $no = $nomor; ?>
                        <?php foreach ($laporan as $l): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d/m/Y', strtotime($l['created_at'])) ?></td>
                                <td>
                                    <span class="text-truncate-custom fw-bold text-dark" title="<?= $l['nama'] ?>">
                                        <?= $l['nama'] ?>
                                    </span>
                                </td>
                                <td class="text-primary fw-bold"><?= $l['nis'] ?></td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary px-2 text-truncate-custom">
                                        <?= $l['ket_kategori'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate-custom" title="<?= $l['lokasi'] ?>">
                                        <?= $l['lokasi'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $status = $l['status'] ?? 'Menunggu';
                                    $color = ($status == 'Selesai') ? 'success' : (($status == 'Proses') ? 'warning' : 'danger');
                                    ?>
                                    <span class="badge bg-<?= $color ?>-subtle text-<?= $color ?> rounded-pill border border-<?= $color ?> px-3">
                                        <?= $status ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-light btn-outline-secondary btn-sm rounded-pill px-3" data-bs-toggle="modal"
                                        data-bs-target="#modalTanggapan<?= $l['id_pelaporan']; ?>">
                                        <i class="bi bi-chat-right-text"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center py-4">
            <nav aria-label="Page navigation">
                <div class="pagination pagination-sm shadow-sm">
                    <?= $pager->links('laporan', 'bootstrap_full') ?>
                </div>
            </nav>
        </div>
    </div>
</div>
</div>

<!-- Modal tanggapan -->

<?php foreach ($laporan as $l): ?>
    <div class="modal fade" id="modalTanggapan<?= $l['id_pelaporan']; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="fw-bold">Tanggapi Laporan </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="bg-light p-3 rounded-3 mb-4 border-start border-primary border-4" style="max-height: 200px; overflow-y: auto;">
                        <small class="text-muted d-block mb-1 fw-bold">KETERANGAN LAPORAN:</small>
                        <p class="mb-0 text-break text-dark" style="white-space: pre-line;">
                            <?= $l['ket']; ?>
                        </p>
                    </div>
                    <form action="<?= base_url('admin/simpan_tanggapan') ?>" method="POST">
                        <input type="hidden" name="id_pelaporan" value="<?= $l['id_pelaporan']; ?>">
                        <input type="hidden" name="id_kategori" value="<?= $l['id_kategori']; ?>">

                        <div class="mb-4">
                            <label class="form-label fw-bold small">PERBARUI STATUS</label>
                            <select name="status" class="form-select border-2">
                                <option value="Menunggu" <?= ($l['status'] ?? '') == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                                <option value="Proses" <?= ($l['status'] ?? '') == 'Proses' ? 'selected' : '' ?>>Proses</option>
                                <option value="Selesai" <?= ($l['status'] ?? '') == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">TANGGAPAN ADMIN</label>
                            <textarea name="feedback" class="form-control border-2" rows="4" placeholder="Ketik balasan untuk siswa..."><?= $l['feedback'] ?? '' ?></textarea>
                            <div class="form-text text-danger small">*Wajib diisi untuk memberikan kejelasan pada siswa.</div>
                        </div>
                        <hr class="my-4">
                        <p class="text-muted small">Menghapus laporan akan menghilangkan data secara permanen dari sistem.</p>
                        <a href="<?= base_url('admin/hapus/' . $l['id_pelaporan']) ?>"
                            class="btn btn-outline-danger w-100 mb-2"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini secara permanen?')">
                            <i class="bi bi-trash me-1"></i> Hapus Laporan
                        </a>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2 fw-bold shadow">Kirim Tanggapan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>