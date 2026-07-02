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

    public function login(): void
    {
        $email = $this->validate($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->redirect('/login', 'Fill all the Fields');
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            $this->redirect('/login', 'Invalid Email or Password');
        }

        if (!password_verify($password, $user['password'])) {
            $this->redirect('/login', 'Invalid Password');
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
            $this->redirect('/login', 'Fill all the Fields');
        }

        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $this->redirect('/login', 'Only letters and white space allowed');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirect('/login', 'Invalid email format');
        }

        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
        if (!preg_match($pattern, $password)) {
            $this->redirect('/login', 'Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters');
        }

        if ($password !== $repassword) {
            $this->redirect('/login', 'Password Does Not Match');
        }

        // Check if email exists
        $existing = $this->userModel->findByEmail($email);
        if ($existing) {
            $this->redirect('/login', 'Email Already Exists');
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
            $this->redirect('/login', 'Registration failed. Please try again.');
        }

        $this->redirect('/login', 'Registration Successful!');
    }

    public function logout(): void
    {
        $this->session->destroy();
        $this->redirect('/login', 'Logged Out Successfully');
    }
}
