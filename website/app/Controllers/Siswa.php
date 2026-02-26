<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\InputAspirasiModel;
use App\Models\KategoriModel;

class Siswa extends BaseController
{
    // TAMPIL HALAMAN SISWA
    public function index()
    {
        $model = new InputAspirasiModel();
        $katModel = new KategoriModel();

        $nis = session()->get('nis');

        // memanggil funsi model
        $data['aspirasi'] = $model->getHistoriSiswa($nis);
        $data['kategori'] = $katModel->findAll();

        return view('siswa/dashboard', $data);
    }

    // SIMPAN ASPIRASI
    public function simpan()
    {
        $modelInput = new InputAspirasiModel();
        $modelAspirasi = new \App\Models\AspirasiModel();

        $dataInput = [
            'nis'         => session()->get('nis'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'lokasi'      => $this->request->getPost('lokasi'),
            'ket'         => $this->request->getPost('ket'),
        ];

        // Simpan ke tabel input_aspirasi
        $modelInput->save($dataInput);

        $id_pelaporan = $modelInput->insertID();
        $modelAspirasi->save([
            'id_pelaporan' => $id_pelaporan,
            'id_kategori'  => $this->request->getPost('id_kategori'),
            'feedback'     => '-',        // Belum ada feedback
            'status'       => 'Menunggu' // Status default saat pertama lapor
        ]);

        return redirect()->to('/siswa/dashboard')->with('msg', 'Aspirasi berhasil dikirim!');
    }

    // EDIT ASPIRASI
    public function ubah_aspirasi($id)
    {
        $db = \Config\Database::connect();
        // 1. Cek tanggapan di tabel aspirasi
        $tanggapan = $db->table('aspirasi')->where('id_pelaporan', $id)->get()->getRowArray();

        // 2. Logika: Jika tanggapan tidak ada ATAU feedback masih '-' atau kosong
        if (!$tanggapan || $tanggapan['feedback'] == '-' || $tanggapan['feedback'] == '') {

            // Maka BOLEH diubah
            $db->table('input_aspirasi')->where('id_pelaporan', $id)->update([
                'id_kategori' => $this->request->getPost('id_kategori'),
                'ket'         => $this->request->getPost('ket'),
                'lokasi'      => $this->request->getPost('lokasi'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ]);

            return redirect()->back()->with('msg', 'Aspirasi berhasil diperbarui!');
        }
    }

    // HAPUS ASPIRASI
    public function hapus_aspirasi($id)
    {
        $db = \Config\Database::connect();

       $tanggapan = $db->table('aspirasi')->where('id_pelaporan', $id)->get()->getRowArray();

    if (!$tanggapan || $tanggapan['feedback'] == '-' || $tanggapan['feedback'] == '') {
        
        // Hapus tanggapan kosongnya dulu (jika ada)
        $db->table('aspirasi')->where('id_pelaporan', $id)->delete();
        
        // Hapus aspirasi utamanya
        $db->table('input_aspirasi')->where('id_pelaporan', $id)->delete();

        return redirect()->back()->with('msg', 'Aspirasi berhasil dihapus!');
    }
}
}
