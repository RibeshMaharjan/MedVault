<?php $cp = $currentPage ?? ''; ?>
<div class="sidebar" id="side_nav">
    <div class="header-box px-0 px-md-2 pt-3 pb-4 d-flex justify-content-between my-0 my-md-3">
        <h1 class="fs-2"><span class="ms-3">MedVault</span></h1>
        <button class="btn d-md-none d-block close-btn px-1 py-0 text-dark"><i class="fal fa-stream"></i></button>
    </div>
    <ul class="nav flex-column mt-2 mt-sm-0 list-unstyled px-2" id="menu">
        <li><a href="/admin/dashboard" class="text-decoration-none px-3 py-2 d-block <?= $cp == 'dashboard' ? 'active' : '' ?>">
            <i class="fa-solid fa-list me-1 icon"></i>Dashboard</a>
        </li>
        <hr>
        <li><a href="#adminmenu" data-bs-toggle="collapse" class="text-decoration-none px-3 py-2 d-block">
            <i class="fal fa-home icon"></i> Admin Management<i class="fa fa-caret-down float-end"></i></a>
            <ul class="nav collapse text-decoration-none px-3 py-2 flex-column" id="adminmenu">
                <li class="nav-item"><a class="nav-link" href="/admin/admins">Display Admins</a></li>
            </ul>
        </li>
        <li><a href="#customermenu" data-bs-toggle="collapse" class="text-decoration-none px-3 py-2 d-block">
            <i class="fa fa-user icon"></i> Customer Management<i class="fa fa-caret-down float-end"></i></a>
            <ul class="nav collapse text-decoration-none px-3 py-2 flex-column" id="customermenu">
                <li class="nav-item"><a class="nav-link" href="/admin/pharmacies/create">Add Customer</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/pharmacies">Display Customer</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/pharmacies/verify">Verify Pharmacies</a></li>
            </ul>
        </li>
    </ul>
    <hr class="h-color mx-2">
    <ul class="list-unstyled px-2" id="menu">
        <li><a href="/admin/settings" class="text-decoration-none px-3 py-2 d-block"><i class="fal fa-bars icon"></i> Settings</a></li>
        <li><a href="/logout" class="text-decoration-none px-3 py-2 d-block text-danger"><i class="fas fa-sign-out-alt icon"></i> Sign Out</a></li>
    </ul>
</div>
