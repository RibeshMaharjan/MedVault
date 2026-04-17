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
        ], 'admin');
    }

    public function create(): void
    {
        $this->view('admin/admins/create', [
            'currentPage' => 'admin-create',
        ], 'admin');
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
            $this->redirect('/admin/admins/create', 'Please fill all fields!');
        }

        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $this->redirect('/admin/admins/create', 'Only letters and white space allowed');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirect('/admin/admins/create', 'Invalid email format');
        }
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
            $this->redirect('/admin/admins/create', 'Invalid Password');
        }
        if (!preg_match('/^[0-9]{10}$/', $phone)) {
            $this->redirect('/admin/admins/create', 'Invalid Phone Number');
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
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

        $this->redirect('/admin/admins/create', 'Admin Added Successfully');
    }
}
