<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Pharmacy;

class AuthController extends Controller
{
    private User $userModel;
    private Pharmacy $pharmacyModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->pharmacyModel = new Pharmacy();
    }

    public function showLogin(): void
    {
        if ($this->session->isAuth()) {
            $role = $this->session->role();
            if ($role === 'admin') {
                $this->redirect('/admin/dashboard', 'Already Logged In');
            } else {
                $this->redirect('/pharmacy/dashboard', 'Already Logged In');
            }
        }

        $this->view('auth/login');
    }

    public function showRegister(): void
    {
        if ($this->session->isAuth()) {
            $role = $this->session->role();
            if ($role === 'admin') {
                $this->redirect('/admin/dashboard', 'Already Logged In');
            } else {
                $this->redirect('/pharmacy/dashboard', 'Already Logged In');
            }
        }

        $this->view('auth/register');
    }

    public function login(): void
    {
        $email = $this->validate($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->redirect('/login', 'Fill all the Fields', 'error');
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            $this->redirect('/login', 'Invalid Email or Password', 'error');
        }

        if (!password_verify($password, $user['password'])) {
            $this->redirect('/login', 'Invalid Email or Password', 'error');
        }

        $this->session->setAuth([
            'name' => $user['name'],
            'user_id' => $user['user_id'],
            'email' => $user['email'],
        ], $user['role']);

        if ($user['role'] === 'admin') {
            $this->redirect('/admin/dashboard', 'Logged In Successfully');
        } else {
            $this->redirect('/pharmacy/dashboard', 'Logged In Successfully');
        }
    }

    public function register(): void
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $repassword = $_POST['repassword'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            $this->redirect('/register', 'Fill all the Fields', 'error');
        }

        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $this->redirect('/register', 'Only letters and white space allowed', 'error');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirect('/register', 'Invalid email format', 'error');
        }

        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
        if (!preg_match($pattern, $password)) {
            $this->redirect('/register', 'Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters', 'error');
        }

        if ($password !== $repassword) {
            $this->redirect('/register', 'Password Does Not Match', 'error');
        }

        // Check if email exists
        $existing = $this->userModel->findByEmail($email);
        if ($existing) {
            $this->redirect('/register', 'Email Already Exists', 'error');
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $this->userModel->beginTransaction();
            $userId = $this->userModel->create($name, $email, $passwordHash, 'user');
            $this->pharmacyModel->createMinimal($userId, $name, $email);
            $this->userModel->commit();
        } catch (\Throwable $e) {
            $this->userModel->rollBack();
            error_log('Registration failed: ' . $e->getMessage());
            $this->redirect('/register', 'Registration failed. Please try again.', 'error');
        }

        $this->redirect('/login', 'Registration Successful!');
    }

    public function logout(): void
    {
        $this->session->destroy();
        $this->redirect('/login', 'Logged Out Successfully');
    }
}
