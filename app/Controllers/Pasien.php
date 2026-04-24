<?php namespace App\Controllers;
use App\Models\PasienModel;

class Pasien extends BaseController {
    
public function cetak($id) {
    $model = new PasienModel();
    $data['row'] = $model->find($id);
    return view('cetak/kartu_pasien', $data);
}

    // 1. Tampilkan View Potongan (Fragment)
    public function index() {
        return view('pasien_view'); // Bukan layout utuh, tapi potongan
    }

    // 2. Ambil Data JSON untuk DataTables
    public function read() {
        $model = new PasienModel();
        return $this->response->setJSON(['data' => $model->findAll()]);
    }

    // 3. Simpan Data (Create/Update)
   public function save() {
        $model = new PasienModel();
        $id = $this->request->getPost('id');
        
        $data = [
            'nama'   => $this->request->getPost('nama'),
            'norm'   => $this->request->getPost('norm'),
            'alamat' => $this->request->getPost('alamat')
        ];

        // --- VALIDASI LENGKAP ---
        if(empty($data['nama'])) {
            return $this->response->setJSON(['status' => 'error', 'msg' => 'Nama wajib diisi!']);
        }
        if(empty($data['norm'])) {
            return $this->response->setJSON(['status' => 'error', 'msg' => 'No Rekam Medis wajib diisi!']);
        }
        if(empty($data['alamat'])) {
            return $this->response->setJSON(['status' => 'error', 'msg' => 'Alamat wajib diisi!']);
        }
        // ------------------------

        if(!empty($id)) {
            $model->update($id, $data);
        } else {
            $model->insert($data);
        }
        
        return $this->response->setJSON(['status' => 'success', 'msg' => 'Data berhasil disimpan']);
    }

    // 4. Hapus Data
    public function delete() {
        $model = new PasienModel();
        $model->delete($this->request->getPost('id'));
        return $this->response->setJSON(['status' => 'success']);
    }

    // 5. Import dari JSONPlaceholder
    public function import() {
        $client = \Config\Services::curlrequest();
        $response = $client->get('https://jsonplaceholder.typicode.com/users');
        $users = json_decode($response->getBody());

        $model = new PasienModel();
        foreach($users as $user) {
            $model->insert([
                'nama' => $user->name,
                'norm' => 'REG-' . rand(100,999),
                'alamat' => $user->address->street
            ]);
        }
        return $this->response->setJSON(['status' => 'success', 'msg' => 'Data berhasil diimport']);
    }
}