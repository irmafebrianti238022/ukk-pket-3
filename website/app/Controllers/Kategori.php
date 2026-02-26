<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }
    
    // TAMPIL DAFTAR KATEGORI
    public function index()
    {
        $data = [
            'title' => 'Kelola Kategori',
            'kategori' => $this->kategoriModel->findAll()
        ];
        return view('admin/kategori', $data);
    }

    // SIMPAN KATEGORI
    public function simpan()
    {
        $this->kategoriModel->save([
            'ket_kategori' => $this->request->getPost('ket_kategori')
        ]);
        return redirect()->to('/admin/kategori')->with('msg', 'Kategori berhasil ditambah!');
    }

    // UBAH/EDIT KATEGORI
    public function ubah($id)
    {
        $this->kategoriModel->update($id, [
            'ket_kategori' => $this->request->getPost('ket_kategori')
        ]);
        return redirect()->to('/admin/kategori')->with('msg', 'Kategori berhasil diubah!');
    }

    // HAPUS KATEGORI
    public function hapus($id)
    {
        $model = new KategoriModel();
        $db = \Config\Database::connect();

        // Cek apakah kategori masih dipakai di input_aspirasi
        $cek = $db->table('input_aspirasi')->where('id_kategori', $id)->countAllResults();

        if ($cek > 0) {
            session()->setFlashdata('error', 'Kategori masih digunakan di aspirasi, tidak bisa dihapus!');
            return redirect()->to('/admin/kategori');
        }

        if ($model->find($id)) {
            $model->delete($id);
            session()->setFlashdata('pesan', 'Kategori berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Kategori tidak ditemukan.');
        }

        return redirect()->to('/admin/kategori');
    }
}
