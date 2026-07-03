<?php
$cp = $currentPage ?? '';
$dashboard_active = ($cp == 'dashboard') ? 'active' : '';
$profile_active = ($cp == 'profile') ? 'active' : '';
$medicine_active = (strpos($cp, 'medicine') !== false) ? 'active' : '';
$category_active = ($cp == 'category') ? 'active' : '';
$order_active = (strpos($cp, 'order') !== false) ? 'active' : '';
$sales_active = (strpos($cp, 'sales') !== false && strpos($cp, 'analysis') === false) ? 'active' : '';
$analysis_sales_active = ($cp == 'analysis-sales') ? 'active' : '';
$analysis_order_active = ($cp == 'analysis-order') ? 'active' : '';

$order_show = ($order_active) ? 'show' : '';
$sales_show = ($sales_active) ? 'show' : '';
?>
<div class="sidebar" id="side_nav">
    <div class="sidebar-header">
        <a href="/pharmacy/dashboard" class="sidebar-brand">
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
                    <a href="/pharmacy/dashboard" class="text-decoration-none px-3 py-2 d-block"><i class="fa-solid fa-list me-1 icon"></i>Dashboard</a>
                </li>
                <hr>
                <li class="<?= $medicine_active ?>">
                    <a href="/pharmacy/medicines" class="text-decoration-none px-3 py-2 d-block">
                        <span class="material-symbols-outlined fs-5 icon">inventory_2</span> Medicine
                    </a>
                </li>
                <li class="nav-item <?= $category_active ?>">
                    <a class="nav-link" href="/pharmacy/categories"><span class="material-symbols-outlined fs-6 icon">category</span>Category</a>
                </li>
                <li class="<?= $order_active ?>">
                    <a href="#adminmenu" data-bs-toggle="collapse" class="text-decoration-none px-3 py-2 d-block">
                        <i class="fa-solid fa-truck-fast icon"></i> Orders Management
                        <i class="fa fa-caret-down float-end" aria-hidden="true"></i>
                    </a>
                    <ul class="nav collapse <?= $order_show ?> text-decoration-none px-3 py-2 flex-column" id="adminmenu">
                        <li class="nav-item">
                            <a class="nav-link <?= ($cp == 'order-create') ? 'active' : '' ?>" href="/pharmacy/orders/create">Add Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($cp == 'order-display') ? 'active' : '' ?>" href="/pharmacy/orders">Display Orders</a>
                        </li>
                    </ul>
                </li>
                <li class="<?= $sales_active ?>">
                    <a href="#customermenu" data-bs-toggle="collapse" class="text-decoration-none px-3 py-2 d-block">
                        <span class="material-symbols-outlined fs-6 icon">sell</span> Sales Management
                        <i class="fa fa-caret-down float-end" aria-hidden="true"></i>
                    </a>
                    <ul class="nav collapse <?= $sales_show ?> text-decoration-none px-3 py-2 flex-column" id="customermenu">
                        <li class="nav-item">
                            <a class="nav-link <?= ($cp == 'sales-create') ? 'active' : '' ?>" href="/pharmacy/sales/create">Add Sales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($cp == 'sales-display') ? 'active' : '' ?>" href="/pharmacy/sales">Display Sales</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item <?= $analysis_sales_active ?>">
                    <a class="nav-link" href="/pharmacy/analytics/sales"><span class="material-symbols-outlined fs-6 icon">category</span>Sales Analysis</a>
                </li>
                <li class="nav-item <?= $analysis_order_active ?>">
                    <a class="nav-link" href="/pharmacy/analytics/orders"><span class="material-symbols-outlined fs-6 icon">category</span>Order Analysis</a>
                </li>
                <li class="nav-item <?= $profile_active ?>">
                    <a class="nav-link" href="/pharmacy/profile"><span class="material-symbols-outlined fs-6 icon">person</span>Profile</a>
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
