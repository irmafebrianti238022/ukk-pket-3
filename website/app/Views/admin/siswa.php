<?= $this->include('layout/header') ?>

<div class="main-content p-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark">Manajemen Data Siswa</h3>
                <p class="text-muted">Kelola akses dan data profil siswa pelapor.</p>
            </div>
            <button class="btn btn-primary fw-bold px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
                <i class="bi bi-person-plus me-2"></i>Tambah Siswa
            </button>
        </div>

         <!-- FILTER SISWA -->
        <div class="row mb-3">
            <div class="col-md-4">
                <form action="<?= base_url('admin/siswa') ?>" method="GET">
                    <div class="input-group">
                        <input type="text" name="cari" class="form-control border-secondary-subtle shadow-sm"
                            placeholder="Cari Nama atau NIS Siswa..."
                            value="<?= request()->getGet('cari') ?>">
                        <button class="btn btn-dark px-3" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                        <?php if (request()->getGet('cari')) : ?>
                            <a href="<?= base_url('admin/siswa') ?>" class="btn btn-outline-danger">
                                <i class="bi bi-x-circle"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- getFlashdata -->

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
                    <div><?= session()->getFlashdata('error') ?></div>
                </div>
            </div>
        <?php endif; ?>

        <!-- TABEL Kelola SISWA -->

        <div class="table-container border bg-white p-3 rounded-3 shadow-sm">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>NO</th>
                        <th>NIS</th>
                        <th>NAMA LENGKAP</th>
                        <th>KELAS</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($siswa as $s) : ?>
                        <tr>
                            <td class="fw-bold"><?= $no++; ?></td>
                            <td class="fw-bold"><?= $s['nis'] ?></td>
                            <td><?= $s['nama'] ?></td>
                            <td><span class="badge bg-info-subtle text-info px-4"><?= $s['kelas'] ?></span></td>
                            <td class="text-center">
                                <button class="btn btn-light btn-sm rounded-pill px-3 border" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $s['nis'] ?>"><i class="bi bi-pencil-square me-1"></i>Edit</button>
                                <a href="<?= base_url('admin/siswa/hapus/' . $s['nis']) ?>" class="btn btn-outline-danger btn-sm rounded-pill" onclick="return confirm('Hapus siswa ini?')"><i class="bi bi-trash me-1"></i>Hapus</a>
                            </td>
                        </tr>

                        <!-- MODAL EDIT SISWA -->

                        <div class="modal fade" id="modalUbah<?= $s['nis'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header">
                                        <h5 class="fw-bold">Ubah Data Siswa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="<?= base_url('admin/siswa/ubah/' . $s['nis']) ?>" method="POST">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="small fw-bold">NAMA LENGKAP</label>
                                                <input type="text" name="nama" class="form-control" value="<?= $s['nama'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="small fw-bold">KELAS</label>
                                                <input type="text" name="kelas" class="form-control" value="<?= $s['kelas'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
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

<!-- MODAL TAMBAH SISWA -->

<div class="modal fade" id="modalTambahSiswa" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="fw-bold">Registrasi Siswa Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/siswa/simpan') ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="small fw-bold">NIS</label>
                        <input type="text" name="nis" class="form-control" placeholder="Masukkan NIS" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">NAMA LENGKAP</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama Siswa" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">KELAS</label>
                        <input type="text" name="kelas" class="form-control" placeholder="Contoh: XI RPL 1" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary w-100">Tambah Siswa</button>
                </div>
            </form>
        </div>
    </div>
</div>