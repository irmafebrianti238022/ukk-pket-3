<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdminModel;

class Auth extends BaseController
{
    // LOGIN ADMIN
    public function login()
    {
        return view('login');
    }
    
    public function proses_login()
    {
        $model = new AdminModel();
        $user  = $this->request->getPost('username');
        $pass  = $this->request->getPost('password');

        $dataAdmin = $model->where('username', $user)->first();

        if ($dataAdmin) {
            if (password_verify($pass, $dataAdmin['password'])) {
                session()->set([
                    'id_admin'  => $dataAdmin['id_admin'],
                    'username'  => $dataAdmin['username'],
                    'role'      => 'admin',
                    'logged_in' => true
                ]);
                return redirect()->to('/admin/dashboard');
            }
        }
        return redirect()->back()->with('error', 'Username atau Password salah!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    //LOGIN SISWA
    public function login_siswa()
    {
        return view('login_siswa');
    }

    public function proses_login_siswa()
    {
        $model = new \App\Models\SiswaModel();
        $nis   = $this->request->getPost('nis');
        $kelas = $this->request->getPost('kelas');

        $dataSiswa = $model->where([
            'nis'   => $nis,
            'kelas' => $kelas
        ])->first();

        if ($dataSiswa) {
            session()->set([
                'nis'       => $dataSiswa['nis'],
                'kelas'     => $dataSiswa['kelas'],
                'nama'      => $dataSiswa['nama'],
                'role'      => 'siswa',
                'logged_in' => true
            ]);
            return redirect()->to('/siswa/dashboard');
        }
        return redirect()->back()->with('error', 'Kombinasi NIS dan Kelas tidak ditemukan!');
    }
}
