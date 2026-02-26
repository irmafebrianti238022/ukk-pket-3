<?= $this->include('layout/header.php') ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark">Kelola Kategori</h3>
                <p class="text-muted">Daftar kategori aspirasi sarana sekolah.</p>
            </div>
            <button class="btn btn-primary fw-bold px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg me-2"></i>Tambah Kategori
            </button>
        </div>

        <!-- getFlashdata -->

        <?php if (session()->getFlashdata('msg')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 10px;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div><?= session()->getFlashdata('pesan') ?></div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 10px;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div><?= session()->getFlashdata('error') ?></div>
                </div>
            </div>
        <?php endif; ?>

        <!-- tabel kategori -->

        <div class="table-container border bg-white p-3 rounded-3 shadow-sm">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3 text-muted" width="5%">NO</th> <th class="py-3 text-muted" width="10%">ID</th>
                        <th class="py-3 text-muted">NAMA KATEGORI</th>
                        <th class="py-3 text-muted text-center" width="20%">AKSI</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($kategori as $k): ?>
                        <tr>
                           <td><?= $no++; ?></td> <td><strong>#<?= $k['id_kategori'] ?></strong></td>
                            <td><?= $k['ket_kategori'] ?></td>
                            <td class="text-center">
                                <button class="btn btn-light btn-sm rounded-pill px-3 border" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $k['id_kategori'] ?>">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </button>
                                <a href="<?= base_url('admin/kategori/hapus/' . $k['id_kategori']) ?>" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('Hapus kategori ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- MODAL EDIT KATEGORI -->

                        <div class="modal fade" id="modalUbah<?= $k['id_kategori'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                                    <div class="modal-header border-0 pt-4 px-4">
                                        <h5 class="fw-bold">Ubah Kategori</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="<?= base_url('admin/kategori/ubah/' . $k['id_kategori']) ?>" method="POST">
                                        <div class="modal-body px-4">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-secondary">NAMA KATEGORI</label>
                                                <input type="text" name="ket_kategori" class="form-control border-2" value="<?= $k['ket_kategori'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 px-4 pb-4">
                                            <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH KATEGORI -->

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 15px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/kategori/simpan') ?>" method="POST">
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">NAMA KATEGORI</label>
                        <input type="text" name="ket_kategori" class="form-control border-2" placeholder="Contoh: Sarana Kelas" required>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Tambah Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>