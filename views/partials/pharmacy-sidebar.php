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

$medicine_show = ($medicine_active) ? 'show' : '';
$order_show = ($order_active) ? 'show' : '';
$sales_show = ($sales_active) ? 'show' : '';
?>
<div class="sidebar pt-3" id="side_nav">
    <div class="row">
        <div class="col">
            <div class="text-center mb-3">
                <img src="/assets/images/logo.png" alt="logo" style="max-height: 60px;">
            </div>
            <div class="d-flex justify-content-between ms-3">
                <button class="btn d-md-none d-block close-btn px-1 py-0 text-dark">
                    <i class="fal fa-stream"></i>
                </button>
            </div>
            <ul class="nav flex-column mt-2 mt-sm-0 list-unstyled px-2" id="menu">
                <li class="<?= $dashboard_active ?>">
                    <a href="/pharmacy/dashboard" class="text-decoration-none px-3 py-2 d-block"><i class="fa-solid fa-list me-1 icon"></i>Dashboard</a>
                </li>
                <hr>
                <li class="<?= $medicine_active ?>">
                    <a href="#medicinemenu" data-bs-toggle="collapse" class="text-decoration-none px-3 py-2 d-block">
                        <span class="material-symbols-outlined fs-5 icon">inventory_2</span> Medicine Management
                        <i class="fa fa-caret-down float-end" aria-hidden="true"></i>
                    </a>
                    <ul class="nav collapse <?= $medicine_show ?> text-decoration-none px-3 py-2 flex-column" id="medicinemenu">
                        <li class="nav-item">
                            <a class="nav-link <?= ($cp == 'medicine-create') ? 'active' : '' ?>" href="/pharmacy/medicines/create">Add Medicine</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($cp == 'medicine-display') ? 'active' : '' ?>" href="/pharmacy/medicines">Display Medicine</a>
                        </li>
                    </ul>
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
            <div class="position-absolute bottom-0 w-100 mb-3 px-3">
                <a href="/logout" class="btn btn-danger w-100 py-2 d-flex align-items-center justify-content-center shadow-sm">
                    <span class="material-symbols-outlined me-2">logout</span>
                    <span class="fw-medium">Sign Out</span>
                </a>
            </div>
        </div>
        <div class="col-1">
            <div class="d-flex justify-content-between d-md-none d-block float-end">
                <button class="btn px-1 py-0 open-btn me-2"><i class="fal fa-stream"></i></button>
            </div>
        </div>
    </div>
</div>
