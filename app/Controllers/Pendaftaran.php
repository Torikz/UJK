<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PendaftaranModel;
use App\Models\PasienModel;

class Pendaftaran extends BaseController
{

    
    public function index()
    {
        return view('pendaftaran_view');
    }

    // Mengambil data untuk DataTables (JOIN dengan Tabel Pasien)
    public function read()
    {
        $model = new PendaftaranModel();
        // Kita pakai fungsi getLengkap() yg sudah dibuat di Model
        $data = $model->getLengkap(); 
        return $this->response->setJSON(['data' => $data]);
    }

    // Mengambil list pasien untuk Dropdown di Modal
    public function listPasien()
    {
        $pasienModel = new PasienModel();
        $data = $pasienModel->findAll();
        return $this->response->setJSON($data);
    }

    public function save()
    {
        // CEK HAK AKSES: Perawat tidak boleh simpan data
        if(session('role') == 'perawat') {
            return $this->response->setJSON(['status'=>'error', 'msg'=>'Anda tidak punya akses!']);
        }

        $model = new PendaftaranModel();
        $id = $this->request->getPost('id');
        
        $data = [
            'pasienid'      => $this->request->getPost('pasienid'),
            'noregistrasi'  => $this->request->getPost('noregistrasi'),
            'tglregistrasi' => $this->request->getPost('tglregistrasi'),
        ];

        if(empty($data['noregistrasi']) || empty($data['pasienid'])) {
            return $this->response->setJSON(['status'=>'error', 'msg'=>'Data tidak lengkap!']);
        }

        if($id) {
            $model->update($id, $data);
        } else {
            $model->insert($data);
        }
        return $this->response->setJSON(['status'=>'success', 'msg'=>'Pendaftaran berhasil disimpan']);
    }

    public function delete()
    {
        if(session('role') == 'perawat') return; // Security Guard

        $model = new PendaftaranModel();
        $model->delete($this->request->getPost('id'));
        return $this->response->setJSON(['status'=>'success']);
    }
    
    // Fitur Cetak Detail (Window Print khusus Pendaftaran)
    public function cetak($id) {
    $model = new PendaftaranModel();
    // Join ke Pasien untuk dapat nama
    $data['row'] = $model->select('pendaftaran.*, pasien.nama, pasien.norm, pasien.alamat')
                         ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                         ->find($id);
    return view('cetak/struk_pendaftaran', $data);
}
}