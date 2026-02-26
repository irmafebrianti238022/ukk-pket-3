<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SiswaModel;

class SiswaAdmin extends BaseController
{
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
    }

    // TAMPIL DAFTAR SISWA
    public function index()
    {
        // FILTER NAMA/NIS
        $cari = $this->request->getGet('cari');
        if ($cari) {
            $this->siswaModel->like('nama', $cari)
                ->orLike('nis', $cari);
        }

        $data = [
            'title' => 'Manajemen Siswa',
            'siswa' => $this->siswaModel->findAll(),
            'cari'  => $cari
        ];
        return view('admin/siswa', $data);
    }

    // SIMPAN SISWA BARU
    public function simpan()
    {
        $this->siswaModel->save([
            'nis'      => $this->request->getPost('nis'),
            'nama'     => $this->request->getPost('nama'),
            'kelas'    => $this->request->getPost('kelas'),
        ]);
        return redirect()->to('/admin/siswa')->with('pesan', 'Siswa berhasil didaftarkan.');
    }

    // EDIT DATA SISWA
    public function ubah($nis)
    {
        $data = [
            'nama'  => $this->request->getPost('nama'),
            'kelas' => $this->request->getPost('kelas'),
        ];


        $this->siswaModel->update($nis, $data);
        return redirect()->to('/admin/siswa')->with('pesan', 'Data siswa diperbarui.');
    }

    //HAPUS SISWA
    public function hapus($nis)
    {
        $db = \Config\Database::connect();
        
        // Cek apakah siswa punya riwayat laporan
        $cek = $db->table('input_aspirasi')->where('nis', $nis)->countAllResults();

        if ($cek > 0) {
            return redirect()->to('/admin/siswa')->with('error', 'Siswa tidak bisa dihapus karena sudah ada riwayat laporan!');
        }

        $this->siswaModel->delete($nis);
        return redirect()->to('/admin/siswa')->with('pesan', 'Data siswa telah dihapus.');
    }
}
