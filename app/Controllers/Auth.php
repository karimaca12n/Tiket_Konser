<?php
namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController {
    public function login() {
        return view('auth/login');
    }

    public function loginProcess()
{
    $model = new UserModel();
    $email = $this->request->getPost('email');
    $pass  = $this->request->getPost('password');

    $user = $model->where('email', $email)->first();

    if ($user && password_verify($pass, $user['password'])) {

        session()->set([
            'user_id'   => $user['id'],
            'nama'      => $user['nama'],
            'role'      => $user['role'],
            'logged_in' => true
        ]);

        // redirect berdasarkan role
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin');
        } else {
            return redirect()->to('/konser');
        }
    }

    return redirect()->back()->with('error', 'Login gagal');
}

    public function register() {
        return view('auth/register');
    }

    public function registerProcess() {
        $model = new UserModel();
        $model->insert([
            'nama_lengkap'=>$this->request->getPost('nama'),
            'username'=>$this->request->getPost('username'),
            'email'=>$this->request->getPost('email'),
            'password'=>password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ]);
        return redirect()->to('/login');
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }
}
