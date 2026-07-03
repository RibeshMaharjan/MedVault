<?php
$cp = $currentPage ?? '';
$dashboard_active = ($cp == 'dashboard') ? 'active' : '';
$admin_active = ($cp == 'admin-display') ? 'active' : '';
$customer_active = in_array($cp, ['pharmacy-create', 'pharmacy-display', 'verify'], true) ? 'active' : '';
$customer_show = $customer_active ? 'show' : '';
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
            <li>
                <a href="#customermenu" data-bs-toggle="collapse" class="text-decoration-none px-3 py-2 d-block <?= $customer_active ?>">
                    <i class="fa fa-user icon"></i> Customer Management<i class="fa fa-caret-down float-end"></i></a>
                <ul class="nav collapse <?= $customer_show ?> text-decoration-none px-3 py-2 flex-column" id="customermenu">
                    <li class="nav-item"><a class="nav-link <?= $cp == 'pharmacy-create' ? 'active' : '' ?>" href="/admin/pharmacies/create">Add Customer</a></li>
                    <li class="nav-item"><a class="nav-link <?= $cp == 'pharmacy-display' ? 'active' : '' ?>" href="/admin/pharmacies">Display Customer</a></li>
                    <li class="nav-item"><a class="nav-link <?= $cp == 'verify' ? 'active' : '' ?>" href="/admin/pharmacies/verify">Verify Pharmacies</a></li>
                </ul>
            </li>
        </ul>
        <hr class="h-color mx-2">
        <ul class="list-unstyled px-2" id="menu">
            <li><a href="/admin/export/orders" class="text-decoration-none px-3 py-2 d-block"><i class="fa-solid fa-file-export icon"></i> Export Orders</a></li>
            <li><a href="/admin/settings" class="text-decoration-none px-3 py-2 d-block <?= $cp == 'settings' ? 'active' : '' ?>"><i class="fal fa-bars icon"></i> Settings</a></li>
        </ul>
    </div>
    <div class="sidebar-footer">
        <a href="/logout" class="btn btn-danger w-100 py-2 d-flex align-items-center justify-content-center shadow-sm">
            <span class="material-symbols-outlined me-2">logout</span>
            <span class="fw-medium">Sign Out</span>
        </a>
    </div>
</div>
