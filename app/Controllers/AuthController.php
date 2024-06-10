<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Libraries\Hash;
use App\Libraries\CiAuth;

class AuthController extends BaseController
{
    protected $helpers = ['url', 'form', 'CIMail'];
    public function loginUserForm()
    {
        $data = [
            'pageTitle' => 'Login',
            'validation' => null,
        ];

        return view('login', $data);
    }

    public function loginUserHandler()
    {
        $fieldtype = filter_var($this->request->getVar('login_id'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($fieldtype == 'email') {
            $isValid = $this->validate([
                'login_id' => [
                    'rules' => 'required|valid_email|is_not_unique[user.email]',
                    'errors' => [
                        'required' => 'Email diperlukan',
                        'valid_email' => 'Masukkan email yang valid ',
                        'is_not_unique' => 'Email tidak terdaftar di dalam sistem'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[8]|max_length[45]',
                    'errors' => [
                        'required' => 'Password diperlukan',
                        'min_length' => 'Password setidaknya harus 8 karakter',
                        'max_length' => 'Password tidak boleh lebih dari 45 karakter'
                    ]
                ]
            ]);
        } else {
            $isValid = $this->validate([
                'login_id' => [
                    'rules' => 'required|is_not_unique[user.username]',
                    'errors' => [
                        'required' => 'Username diperlukan',
                        'is_not_unique' => 'Username tidak terdaftar di dalam sistem '
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[8]|max_length[45]',
                    'errors' => [
                        'required' => 'Password diperlukan',
                        'min_length' => 'Password setidaknya harus 8 karakter',
                        'max_length' => 'Password tidak boleh lebih dari 45 karakter'
                    ]
                ]
            ]);
        }

        if (!$isValid) {
            return view('login', [
                'pageTitle' => 'Login',
                'validation' => $this->validator
            ]);
        } else {
            $user = new UserModel();
            $userInfo = $user->where($fieldtype, $this->request->getVar('login_id'))->first();
            $username = $userInfo ? $userInfo['username'] : null;


            $checkPassword = Hash::check($this->request->getVar('password'), $userInfo['password']);

            if (!$checkPassword) {
                return redirect()->route('user.login.form')->with('fail', 'Password Salah')->withInput();
            } else {
                CiAuth::setCiAuth($userInfo); // Baris Penting
                $username = $userInfo['username'];
                session()->set('username', $username);
                return redirect()->route('user.home');
            }
        }
    }
}