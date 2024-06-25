<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Libraries\Hash;

class Register extends BaseController
{
    public function registerForm()
    {
        helper('form');  // Load the form helper

        $data = [
            'pageTitle' => 'Registrasi',
        ];

        return view('/auth/register', $data);
    }

    public function saveForm()
    {
        $rules = $this->validate([
            'name' => [
                'rules' => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'Nama diperlukan',
                    'min_length' => 'Nama minimal 2 karakter',
                    'max_length' => 'Nama maksimal 50 karakter',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[user.email]',
                'errors' => [
                    'required' => 'Email diperlukan',
                    'valid_email' => 'Email tidak valid',
                    'is_unique' => 'Email sudah digunakan !'
                ]
            ],
            'username' => [
                'rules' => 'required|min_length[4]|max_length[50]|is_unique[user.username]',
                'errors' => [
                    'required' => 'Username diperlukan',
                    'min_length' => 'Username minimal 3 karakter',
                    'max_length' => 'Username maksimal 50 karakter',
                    'is_unique' => 'Username sudah di gunakan !'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]|max_length[255]',
                'errors' => [
                    'required' => 'Password diperlukan',
                    'min_length' => 'Password minimal 8 karakter',
                    'max_length' => 'Password terlalu panjang'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi Ulang',
                    'matches' => 'Password tidak sama!'
                ]
            ]
        ]);

        if (!$rules) {
            return view('/auth/register', [
                'pageTitle' => 'Register',
                'validation' => $this->validator
            ]);
        } else {
            $user = new UserModel();
            $data = [
                'name' => $this->request->getVar('name'),
                'username' => $this->request->getVar('username'),
                'email' => $this->request->getVar('email'),
                'password' => Hash::make($this->request->getVar('password')),
            ];
            $user->save($data);

            return redirect()->route('user.login.form')->with('success', 'Anda berhasil registrasi');
        }
    }
}
