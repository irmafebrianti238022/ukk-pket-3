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

        $query = $model->select('input_aspirasi.*, kategori.ket_kategori, siswa.nama, siswa.kelas, aspirasi.status, aspirasi.feedback')
            ->join('kategori', 'kategori.id_kategori = input_aspirasi.id_kategori')
            ->join('siswa', 'siswa.nis = input_aspirasi.nis')
            ->join('aspirasi', 'aspirasi.id_pelaporan = input_aspirasi.id_pelaporan', 'left');

        // Ambil data dari Form Filter (Method GET)
        $filter_nis      = $this->request->getGet('nis');
        $filter_kategori = $this->request->getGet('kategori');
        $filter_status   = $this->request->getGet('status');
        $filter_tanggal  = $this->request->getGet('tanggal');


        // Tambahkan kondisi jika filter diisi
        if ($filter_nis)      $query->where('input_aspirasi.nis', $filter_nis);
        if ($filter_kategori) $query->where('input_aspirasi.id_kategori', $filter_kategori);
        if ($filter_tanggal)  $query->where('DATE(input_aspirasi.created_at)', $filter_tanggal);
        if ($filter_status) {
            if ($filter_status == 'Menunggu') {
                $query->groupStart()
                    ->where('aspirasi.status', null)
                    ->orWhere('aspirasi.status', 'Menunggu')
                    ->groupEnd();
            } else {
                $query->where('aspirasi.status', $filter_status);
            }
        }

        $data['laporan']  = $query->orderBy('input_aspirasi.created_at', 'DESC')->paginate(10, 'laporan');
        $data['pager']    = $model->pager;
        $data['kategori'] = $katModel->findAll();
        $data['title'] = "Dashboard Admin";

        $currentPage = $this->request->getVar('page_laporan') ? $this->request->getVar('page_laporan') : 1;
        $data['nomor'] = 1 + (10 * ($currentPage - 1));

        return view('admin/dashboard', $data);
    }

    // TANGGAPAN ADMIN
    public function tanggapan($id_pelaporan)
    {
        $inputModel = new InputAspirasiModel();

        // Ambil detail laporan berdasarkan ID
        $data['laporan'] = $inputModel->select('input_aspirasi.*, kategori.ket_kategori, siswa.kelas')
            ->join('kategori', 'kategori.id_kategori = input_aspirasi.id_kategori')
            ->join('siswa', 'siswa.nis = input_aspirasi.nis')
            ->where('id_pelaporan', $id_pelaporan)
            ->first();

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
