<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Setting;

class SettingController extends Controller
{
    private Setting $setting;

    public function __construct()
    {
        parent::__construct();
        $this->setting = new Setting();
    }

    public function index(): void
    {
        $settings = $this->setting->findById(1);

        $this->view('admin/settings', [
            'settings' => $settings,
            'currentPage' => 'settings',
        ], 'app');
    }

    public function update(): void
    {
        $this->setting->update(1, [
            'title' => $this->validate($_POST['title'] ?? ''),
            'small_description' => $this->validate($_POST['small-description'] ?? ''),
            'sub_title' => $this->validate($_POST['sub-title'] ?? ''),
            'sub_description' => $this->validate($_POST['sub-description'] ?? ''),
            'phone' => $this->validate($_POST['phone'] ?? ''),
            'email' => $this->validate($_POST['email'] ?? ''),
        ]);

        $this->redirect('/admin/settings', 'Settings saved successfully');
    }
}
