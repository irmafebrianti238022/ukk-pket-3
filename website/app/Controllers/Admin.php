<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\InputAspirasiModel;

class Admin extends BaseController
{
    public function index()
    {
        $model = new InputAspirasiModel();
        $katModel = new \App\Models\KategoriModel();

        // Ambil input filter
        $filters = [
            'nis'      => $this->request->getGet('nis'),
            'kategori' => $this->request->getGet('kategori'),
            'status'   => $this->request->getGet('status'),
            'tanggal'  => $this->request->getGet('tanggal'),
        ];

        // Panggil fungsi dari Model 
        $data['laporan'] = $model->getFilteredData(
            $filters['nis'],
            $filters['kategori'],
            $filters['status'],
            $filters['tanggal']
        )->paginate(10, 'laporan');

        $data['pager']    = $model->pager;
        $data['kategori'] = $katModel->findAll();
        $data['title']    = "Dashboard Admin";

        $currentPage    = $this->request->getVar('page_laporan') ?: 1;
        $data['nomor']  = 1 + (10 * ($currentPage - 1));

        return view('admin/dashboard', $data);
    }

    // TANGGAPAN ADMIN
    public function tanggapan($id_pelaporan)
    {
        $model = new InputAspirasiModel();

        $data['laporan'] = $model->getDetailLaporan($id_pelaporan);

        if (!$data['laporan']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Laporan tidak ditemukan.");
        }

        return view('admin/dashboard', $data);
    }

    // SIMPAN TANGGAPAN
    public function simpan_tanggapan()
    {

        $aspirasiModel = new \App\Models\AspirasiModel();
        $id_pelaporan = $this->request->getPost('id_pelaporan');

        $dataSimpan = [
            'id_pelaporan' => $id_pelaporan,
            'id_kategori'  => $this->request->getPost('id_kategori'),
            'feedback'     => $this->request->getPost('feedback'),
            'status'       => $this->request->getPost('status'),
        ];

        // Cek apakah ini sudah pernah ditanggapi
        $cek = $aspirasiModel->where('id_pelaporan', $id_pelaporan)->first();

        if ($cek) {

            $aspirasiModel->update($cek['id_aspirasi'], $dataSimpan);
        } else {

            $aspirasiModel->save($dataSimpan);
        }
        return redirect()->to('/admin/dashboard')->with('msg', 'Data diperbarui!');
    }

    // HAPUS TANGGAPAN
    public function hapus($id)
    {
        $db = \Config\Database::connect();
        $db->table('aspirasi')->where('id_pelaporan', $id)->delete();

        $model = new InputAspirasiModel();
        $model->delete($id);
        return redirect()->to('/admin/dashboard')->with('msg', 'Aspirasi berhasil dihapus!');
    }
}
