<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Libraries\Hash;
use App\Libraries\CiAuth;
use App\Models\PasswordResetToken;
use Carbon\Carbon;

class AuthController extends BaseController
{
    protected $helpers = ['url', 'form', 'CIMail', 'CIFunctions'];
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
                $name = $userInfo['name'];
                $picture = $userInfo['picture'];
                session()->set('username', $username);
                session()->set('name', $name);
                session()->set('picture', $picture);
                return redirect()->route('user.home')->with('success', "Selamat Datang {$userInfo['name']}");
            }
        }
    }

    public function forgotForm()
    {
        $data = [
            'pageTitle' => 'Forgot Password',
            'validation' => null
        ];

        return view('forgot', $data);
    }

    public function sendPasswordResetLink()
    {
        $isValid = $this->validate([
            'email' => [
                'rules' => 'required|valid_email|is_not_unique[user.email]',
                'errors' => [
                    'required' => 'Email perlu diisi',
                    'valid_email' => 'Masukkan email yang valid',
                    'is_not_unique' => 'Email tidak terdaftar di dalam sistem'
                ]
            ]
        ]);

        if (!$isValid) {
            return view('forgot', [
                'pageTitle' => 'Forgot Password',
                'validation' => $this->validator
            ]);
        } else {
            $user = new UserModel();
            $user_info = $user->asObject()->where('email', $this->request->getVar('email'))->first();

            $token = bin2hex(openssl_random_pseudo_bytes(65));

            $password_reset_token = new PasswordResetToken();
            $isOldTokenExists = $password_reset_token->asObject()->where('email', $user_info->email)->first();

            if ($isOldTokenExists) {
                $password_reset_token->where('email', $user_info->email)
                    ->set(['token' => $token, 'created_at' => Carbon::now()])
                    ->update();
            } else {
                $password_reset_token->insert([
                    'email' => $user_info->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
            }

            $actionLink = base_url(route_to('user.reset-password', $token));

            $mail_data = [
                'actionLink' => $actionLink,
                'user' => $user_info
            ];

            $view = \Config\Services::renderer();
            $mail_body = $view->setVar('email_data', $mail_data)->render('email-templates/forgot-email-template');

            $mailConfig = [
                'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                'mail_from_name' => env('EMAIL_FROM_NAME'),
                'mail_recipient_email' => $user_info->email,
                'mail_recipient_name' => $user_info->username,
                'mail_subject' => 'Reset Password',
                'mail_body' => $mail_body
            ];

            if (sendEmail($mailConfig)) {
                return redirect()->route('user.forgot.password')->with('success', 'Kami sudah mengirimkan password ke emailmu');
            } else {
                return redirect()->route('user.forgot.password')->with('fail', 'Ada sesuatu yang salah');
            }
        }
    }

    public function resetPassword($token)
    {
        $passwordResetPassword = new PasswordResetToken();
        $check_token = $passwordResetPassword->asObject()->where('token', $token)->first();

        if (!$check_token) {
            return redirect()->route('user.forgot.password')->with('fail', 'Invalid token, Mintalah Reset Token Password Yang lain');
        } else {

            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $check_token->created_at)->diffInMinutes(Carbon::now());

            if ($diffMins > 15) {
                return redirect()->route('user.forgot.password')->with('fail', 'Token telah kadaluarsa, silahkan minta password reset link yang baru !');
            } else {
                return view('reset', [
                    'pageTitle' => 'Reset Password',
                    'validation' => null,
                    'token' => $token
                ]);
            }
        }
    }

    public function resetPasswordHandler($token)
    {
        $isValid = $this->validate([
            'new_password' => [
                'rules' => 'required|min_length[8]|max_length[30]',
                'errors' => [
                    'required' => 'Masukkan password baru!',
                    'min_length' => 'Password minimal 8 karakter',
                    'max_length' => 'maksimal password adalah 30 karakter'
                ]
            ],
            'confirm_new_password' => [
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Konfirmasi password baru',
                    'matches' => 'Password tidak sama !'
                ]
            ]
        ]);

        if (!$isValid) {
            return view('reset', [
                'pageTitle' => 'Reset Password',
                'validation' => null,
                'token' => $token,
            ]);
        } else {
            // Dapatkan detail tokens
            $passwordResetPassword = new PasswordResetToken();
            $get_token = $passwordResetPassword->asObject()->where('token', $token)->first();

            //Dapatlan admin detail
            $user = new UserModel();
            $user_info = $user->asObject()->where('email', $get_token->email)->first();

            if (!$get_token) {
                return redirect()->back()->with('fail', 'Token tidak Valid')->withInput();
            } else {
                //update admin password di database
                $user->where('email', $user_info->email)
                    ->set(['password' => Hash::make($this->request->getVar('new_password'))])
                    ->update();

                $mail_data = array(
                    'user' => $user_info,
                    'new_password' => $this->request->getVar('new_password')
                );

                $view = \Config\Services::renderer();
                $mail_body = $view->setVar('mail_data', $mail_data)->render('email-templates/password-changed-email-template');

                $mailConfig = array(
                    'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                    'mail_from_name' => env('EMAI_FROM_NAME'),
                    'mail_recipient_email' => $user_info->email,
                    'mail_recipient_name' => $user_info->username,
                    'mail_subject' => 'Changed Password',
                    'mail_body' => $mail_body
                );

                if (sendEmail($mailConfig)) {
                    //Hapus Token
                    $passwordResetPassword->where('email', $user_info->email)->delete();

                    //Redirect dan tampilkan pesan pada laman login
                    return redirect()->route('user.login.form')->with('success', 'Berhasil, Password anda telah berhasil diubah, gunakan password baru untuk login ke sistem');
                } else {
                    return redirect()->back()->with('fail', 'Ada Sesuatu yang salah!');
                }
            }
        }
    }
}
