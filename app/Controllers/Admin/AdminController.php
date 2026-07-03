<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Admin;
use App\Models\User;

class AdminController extends Controller
{
    private Admin $admin;
    private User $user;

    public function __construct()
    {
        parent::__construct();
        $this->admin = new Admin();
        $this->user = new User();
    }

    public function index(): void
    {
        $admins = $this->admin->findAll();
        $this->view('admin/admins/index', [
            'admins' => $admins,
            'currentPage' => 'admin-display',
        ], 'app');
    }

    public function create(): void
    {
        $this->redirect('/admin/admins?open=create');
    }

    public function store(): void
    {
        $name = $this->validate($_POST['name'] ?? '');
        $email = $this->validate($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $gender = $this->validate($_POST['gender'] ?? '');
        $phone = $this->validate($_POST['phone'] ?? '');
        $dob = $_POST['birth'] ?? '';
        $address = $this->validate($_POST['address'] ?? '');

        if (empty($name) || empty($email) || empty($password)) {
            $this->redirect('/admin/admins?open=create', 'Please fill all fields!', 'error');
        }

        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $this->redirect('/admin/admins?open=create', 'Only letters and white space allowed', 'error');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirect('/admin/admins?open=create', 'Invalid email format', 'error');
        }
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
            $this->redirect('/admin/admins?open=create', 'Invalid Password', 'error');
        }
        if (!preg_match('/^[0-9]{10}$/', $phone)) {
            $this->redirect('/admin/admins?open=create', 'Invalid Phone Number', 'error');
        }
        if ($this->user->findByEmail($email)) {
            $this->redirect('/admin/admins?open=create', 'Email Already Exists', 'error');
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $this->user->beginTransaction();
            $adminId = $this->user->create($name, $email, $passwordHash, 'admin');
            $this->admin->insert([
                'admin_id' => $adminId,
                'name' => $name,
                'email' => $email,
                'gender' => $gender,
                'phone' => $phone,
                'dob' => date('Y-m-d', strtotime($dob)),
                'address' => $address,
            ]);
            $this->user->commit();
        } catch (\Throwable $e) {
            $this->user->rollBack();
            error_log('Admin create failed: ' . $e->getMessage());
            $this->redirect('/admin/admins?open=create', 'Admin creation failed. Please try again.', 'error');
        }

        $this->redirect('/admin/admins', 'Admin Added Successfully');
    }
}
