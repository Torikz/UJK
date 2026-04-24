<?php namespace App\Controllers;

use App\Models\KunjunganModel;
use App\Models\PendaftaranModel;

class Kunjungan extends BaseController
{

    public function cetak($id) {
    $model = new KunjunganModel();
    // Join lengkap: Kunjungan -> Pendaftaran -> Pasien
    $data['row'] = $model->select('kunjungan.*, pendaftaran.noregistrasi, pasien.nama, pasien.norm, pasien.alamat')
                         ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                         ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                         ->find($id);
    return view('cetak/surat_kontrol', $data);
}
    public function index()
    {
        return view('kunjungan_view');
    }

    public function read()
    {
        $model = new KunjunganModel();
        // Menggunakan method getKunjunganLengkap() dari Model yang sudah dibuat sebelumnya
        $data = $model->getKunjunganLengkap(); 
        return $this->response->setJSON(['data' => $data]);
    }

    // Mengambil Data Pendaftaran untuk Dropdown
    public function listPendaftaran()
    {
        $pendModel = new PendaftaranModel();
        // Ambil pendaftaran hari ini saja agar tidak menumpuk, atau semua juga boleh
        // Di sini kita ambil yang belum ada di kunjungan (opsional logic), tapi untuk simpel ambil semua
        $data = $pendModel->select('pendaftaran.id, pendaftaran.noregistrasi, pasien.nama')
                          ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                          ->orderBy('pendaftaran.id', 'DESC')
                          ->findAll();
        return $this->response->setJSON($data);
    }

    public function save()
    {
        // Perawat Cuma Boleh Lihat
        if(session('role') == 'perawat') {
            return $this->response->setJSON(['status'=>'error', 'msg'=>'Akses Ditolak']);
        }

        $model = new KunjunganModel();
        $id = $this->request->getPost('id');
        $data = [
            'pendaftaranpasienid' => $this->request->getPost('pendaftaranpasienid'),
            'jeniskunjungan'      => $this->request->getPost('jeniskunjungan'), // misal: Poli Umum, Gigi, dll
            'tglkunjungan'        => $this->request->getPost('tglkunjungan'),
        ];

        if($id) {
            $model->update($id, $data);
        } else {
            $model->insert($data);
        }
        return $this->response->setJSON(['status'=>'success', 'msg'=>'Kunjungan tersimpan']);
    }

    public function delete()
    {
        if(session('role') == 'perawat') return;

        $model = new KunjunganModel();
        $model->delete($this->request->getPost('id'));
        return $this->response->setJSON(['status'=>'success']);
    }
}