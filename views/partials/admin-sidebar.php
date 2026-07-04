<?php
$cp = $currentPage ?? '';
$dashboard_active = ($cp == 'dashboard') ? 'active' : '';
$admin_active = ($cp == 'admin-display') ? 'active' : '';
$pharmacy_active = ($cp == 'pharmacy-display') ? 'active' : '';
$verify_active = ($cp == 'verify') ? 'active' : '';
?>
<div class="sidebar" id="side_nav">
    <div class="sidebar-header">
        <a href="/admin/dashboard" class="sidebar-brand">
            <img src="/image/logo.png" alt="MedVault">
            <span>MedVault</span>
        </a>
        <button class="btn d-md-none close-btn" type="button" aria-label="Close navigation">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="sidebar-scroll">
        <ul class="nav flex-column list-unstyled" id="menu">
            <li class="<?= $dashboard_active ?>">
                <a href="/admin/dashboard" class="text-decoration-none px-3 py-2 d-block"><i class="fa-solid fa-list me-1 icon"></i>Dashboard</a>
            </li>
            <hr>
            <li class="<?= $admin_active ?>">
                <a href="/admin/admins" class="text-decoration-none px-3 py-2 d-block"><i class="fal fa-home icon"></i> Admins</a>
            </li>
            <li class="<?= $pharmacy_active ?>">
                <a href="/admin/pharmacies" class="text-decoration-none px-3 py-2 d-block"><i class="fa fa-user icon"></i> Pharmacies</a>
            </li>
            <li class="<?= $verify_active ?>">
                <a href="/admin/pharmacies/verify" class="text-decoration-none px-3 py-2 d-block"><i class="fa-solid fa-circle-check icon"></i> Verify Pharmacies</a>
            </li>
        </ul>
    </div>
    <div class="sidebar-footer">
        <a href="/logout" class="btn btn-danger w-100 py-2 d-flex align-items-center justify-content-center shadow-sm">
            <span class="material-symbols-outlined me-2">logout</span>
            <span class="fw-medium">Sign Out</span>
        </a>
    </div>
</div>
