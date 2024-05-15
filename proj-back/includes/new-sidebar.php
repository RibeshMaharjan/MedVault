<div class="sidebar" id="side_nav">
    <div class="header-box px-2 pt-3 pb-4 d-flex justify-content-between">
        <h1 class="fs-2"> <span
                class="ms-3  ">MedVault</span></h1>
        <button class="btn d-md-none d-block close-btn px-1 py-0 text-dark"><i
                class="fal fa-stream"></i></button>
    </div>

    <ul class="nav navbar-light bg-light flex-column mt-2 mt-sm-0 list-unstyled px-2" id="menu">
        <li class="active"><a href="admin.php" data-display="adminform" class="text-decoration-none px-3 py-2 d-block"><i
                    class="fal fa-home"></i> Dashboard</a></li>
        <hr class="">
        <li class=""><a href="#adminmenu" data-bs-toggle="collapse"  class="text-decoration-none px-3 py-2 d-block">
            <i class="fal fa-home"></i> Admin Management<i class="fa fa-caret-down float-end " aria-hidden="true"></i></a>
            <ul class="nav collapse text-decoration-none px-3 py-2 flex-column" id="adminmenu" data-bs-parent="#adminmenu">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="admin-create.php" data-display="adminform">Add Admins</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin-display.php" data-display="adminform">Display Admins</a>
                </li>
            </ul>
        </li>
        <li class=""><a href="#customermenu" data-bs-toggle="collapse"  class="text-decoration-none px-3 py-2 d-block">
            <i class="fa fa-user"></i> Customer Management<i class="fa fa-caret-down float-end " aria-hidden="true"></i></a>
            <ul class="nav collapse text-decoration-none px-3 py-2 flex-column" id="customermenu" data-bs-parent="#customermenu">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="pharmacy-create.php" data-display="adminform">Add Customer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pharmacy-display.php" data-display="adminform">Display Customer</a>
                </li>
            </ul>
        </li>
        <li class=""><a href="#medicinemenu" data-bs-toggle="collapse"  class="text-decoration-none px-3 py-2 d-block">
        <span class="material-symbols-outlined fs-5 ">inventory_2</span> Medicine Management<i class="fa fa-caret-down float-end " aria-hidden="true"></i></a>
            <ul class="nav collapse text-decoration-none px-3 py-2 flex-column" id="medicinemenu" data-bs-parent="#ordeermenu">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="medicine-create.php" data-display="adminform">Add Medicine</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="medicine-display.php" data-display="adminform">Display Medicine</a>
                </li>
            </ul>
        </li>
        <li class=""><a href="#ordermenu" data-bs-toggle="collapse"  class="text-decoration-none px-3 py-2 d-block">
        <span class="material-symbols-outlined fs-5">orders</span> Orders Management<i class="fa fa-caret-down float-end " aria-hidden="true"></i></a>
            <ul class="nav collapse text-decoration-none px-3 py-2 flex-column" id="ordermenu" data-bs-parent="#ordermenu">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="order-display.php" data-display="adminform">Order Display</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="order-pending.php" data-display="adminform">Order Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="order-approve.php" data-display="adminform">Order Completed</a>
                </li>
            </ul>
        </li>
    </ul>

    <hr class="h-color mx-2">

    <ul class="list-unstyled px-2">
        <li class=""><a href="setting.php" class="text-decoration-none px-3 py-2 d-block"><i class="fal fa-bars"></i>
                Settings</a></li>
    </ul>

</div>