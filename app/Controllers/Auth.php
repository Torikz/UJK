<?php namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController {
    public function index() {
        return view('login_view');
    }

    public function login() {
        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        $user = $model->where('username', $username)->first();
        
        // Cek user & password dummy (di real project pakai password_verify)
        if ($user) {
            session()->set([
                'username' => $user['username'],
                'role' => $user['role'],
                'isLoggedIn' => true
            ]);
            return $this->response->setJSON(['status' => 'success']);
        }
        return $this->response->setJSON(['status' => 'error', 'msg' => 'Akun tidak ditemukan']);
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }
}