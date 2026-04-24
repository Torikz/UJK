<?php namespace App\Controllers;

use App\Models\AsesmenModel;
use App\Models\KunjunganModel;

class Asesmen extends BaseController
{

    public function cetak($id) {
    $model = new AsesmenModel();
    // Join sangat lengkap: Asesmen -> Kunjungan -> Pendaftaran -> Pasien
    $data['row'] = $model->select('asesmen.*, kunjungan.tglkunjungan, kunjungan.jeniskunjungan, pasien.nama, pasien.norm, pasien.alamat')
                         ->join('kunjungan', 'kunjungan.id = asesmen.kunjunganid')
                         ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                         ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                         ->find($id);
    return view('cetak/resume_medis', $data);
}
    // Constructor-like check: Blokir Admisi sebelum masuk method apapun
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        if (session('role') == 'admisi') {
            // Lempar error 403 Forbidden atau redirect
            echo view('errors/html/error_403', ['message' => 'Admisi tidak memiliki akses ke halaman Medis!']);
            exit;
        }
    }

    public function index()
    {
        return view('asesmen_view');
    }

    public function read()
    {
        $model = new AsesmenModel();
        // Menggunakan join lengkap (Pasien & Kunjungan)
        $data = $model->getAsesmenLengkap(); 
        return $this->response->setJSON(['data' => $data]);
    }

    // List Kunjungan untuk dipilih saat Perawat input Asesmen
    public function listKunjungan()
    {
        $kunjModel = new KunjunganModel();
        // Ambil kunjungan yang ada nama pasiennya
        $data = $kunjModel->getKunjunganLengkap();
        return $this->response->setJSON($data);
    }

    public function save()
    {
        $model = new AsesmenModel();
        $id = $this->request->getPost('id');
        $data = [
            'kunjunganid' => $this->request->getPost('kunjunganid'),
            'keluhan_utama' => $this->request->getPost('keluhan_utama'),
            'keluhan_tambahan' => $this->request->getPost('keluhan_tambahan'),
        ];

        if($id) {
            $model->update($id, $data);
        } else {
            $model->insert($data);
        }
        return $this->response->setJSON(['status'=>'success', 'msg'=>'Asesmen Medis Disimpan']);
    }

    public function delete()
    {
        $model = new AsesmenModel();
        $model->delete($this->request->getPost('id'));
        return $this->response->setJSON(['status'=>'success']);
    }
}