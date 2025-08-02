<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Services\WhatsAppService;

class Auth extends BaseController
{
    protected $userModel;
    protected $whatsappService;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->whatsappService = new WhatsAppService();
    }

    public function index()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }
        return redirect()->to('/auth/login');
    }

    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            $whatsapp = $this->request->getPost('whatsapp');
            $password = $this->request->getPost('password');

            // Debug: Log the input
            log_message('debug', 'Login attempt - WhatsApp: ' . $whatsapp);

            $user = $this->userModel->findByWhatsApp($whatsapp);

            if (!$user) {
                log_message('debug', 'User not found for WhatsApp: ' . $whatsapp);
                session()->setFlashdata('error', 'Nomor WhatsApp tidak terdaftar');
                return redirect()->back()->withInput();
            }

            log_message('debug', 'User found: ' . $user['name'] . ' (ID: ' . $user['id'] . ')');

            if (!password_verify($password, $user['password'])) {
                log_message('debug', 'Password verification failed for user: ' . $user['name']);
                session()->setFlashdata('error', 'Password salah');
                return redirect()->back()->withInput();
            }

            log_message('debug', 'Password verification successful for user: ' . $user['name']);

            if (!$user['is_verified']) {
                log_message('debug', 'User not verified: ' . $user['name']);
                session()->setFlashdata('error', 'Akun belum diverifikasi. Silakan verifikasi terlebih dahulu');
                return redirect()->back()->withInput();
            }

            // Set session data
            $sessionData = [
                'user_id' => $user['id'],
                'user_name' => $user['name'],
                'user_whatsapp' => $user['whatsapp'],
                'user_role' => $user['role'],
            ];
            
            // Force session start
            if (!session()->isStarted()) {
                session()->start();
            }
            
            session()->set($sessionData);
            
            // Force session write
            session()->regenerate();
            
            log_message('debug', 'Session data set: ' . json_encode($sessionData));
            log_message('debug', 'Session ID: ' . session_id());
            log_message('debug', 'Session started: ' . (session()->isStarted() ? 'YES' : 'NO'));

            if ($user['role'] === 'admin') {
                log_message('debug', 'Redirecting admin to: /admin/dashboard');
                // Return JSON response for testing
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Login berhasil',
                    'user' => $sessionData,
                    'redirect' => '/admin/dashboard'
                ]);
            } else {
                log_message('debug', 'Redirecting customer to: /dashboard');
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Login berhasil',
                    'user' => $sessionData,
                    'redirect' => '/dashboard'
                ]);
            }
        }

        return view('auth/login');
    }

    public function register()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            $data = [
                'name' => $this->request->getPost('name'),
                'whatsapp' => $this->request->getPost('whatsapp'),
                'password' => $this->request->getPost('password'),
                'role' => 'customer',
                'is_verified' => false,
            ];

            if (!$this->userModel->validate($data)) {
                session()->setFlashdata('errors', $this->userModel->errors());
                return redirect()->back()->withInput();
            }

            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            $userId = $this->userModel->insert($data);

            if ($userId) {
                $verificationCode = $this->userModel->createVerificationCode($userId);
                
                // Send verification code via WhatsApp
                $result = $this->whatsappService->sendVerificationCode($data['whatsapp'], $verificationCode);
                
                if ($result['success']) {
                    session()->setFlashdata('success', 'Registrasi berhasil! Kode verifikasi telah dikirim ke WhatsApp Anda');
                    return redirect()->to('/auth/verify/' . $userId);
                } else {
                    session()->setFlashdata('error', 'Registrasi berhasil, tetapi gagal mengirim kode verifikasi. Silakan hubungi admin');
                    return redirect()->to('/auth/login');
                }
            } else {
                session()->setFlashdata('error', 'Gagal melakukan registrasi');
                return redirect()->back()->withInput();
            }
        }

        return view('auth/register');
    }

    public function verify($userId = null)
    {
        if (!$userId) {
            return redirect()->to('/auth/login');
        }

        $user = $this->userModel->find($userId);
        if (!$user) {
            session()->setFlashdata('error', 'User tidak ditemukan');
            return redirect()->to('/auth/login');
        }

        if ($user['is_verified']) {
            session()->setFlashdata('success', 'Akun sudah diverifikasi');
            return redirect()->to('/auth/login');
        }

        if ($this->request->getMethod() === 'post') {
            $code = $this->request->getPost('verification_code');

            if ($this->userModel->verifyCode($userId, $code)) {
                session()->setFlashdata('success', 'Verifikasi berhasil! Silakan login');
                return redirect()->to('/auth/login');
            } else {
                session()->setFlashdata('error', 'Kode verifikasi salah atau sudah kadaluarsa');
                return redirect()->back();
            }
        }

        return view('auth/verify', ['user' => $user]);
    }

    public function resendVerification($userId)
    {
        $user = $this->userModel->find($userId);
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User tidak ditemukan']);
        }

        if ($user['is_verified']) {
            return $this->response->setJSON(['success' => false, 'message' => 'Akun sudah diverifikasi']);
        }

        $verificationCode = $this->userModel->createVerificationCode($userId);
        $result = $this->whatsappService->sendVerificationCode($user['whatsapp'], $verificationCode);

        if ($result['success']) {
            return $this->response->setJSON(['success' => true, 'message' => 'Kode verifikasi telah dikirim ulang']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengirim kode verifikasi']);
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}