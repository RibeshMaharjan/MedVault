<div class="sidebar pt-3" id="side_nav">
    <div class="row">
        <div class="col">
            <div class="d-flex justify-content-between ms-3">
                <button class="btn d-md-none d-block close-btn px-1 py-0 text-dark">
                    <i class="fal fa-stream"></i>
                </button>
            </div>
            <ul class="nav flex-column mt-2 mt-sm-0 list-unstyled px-2" id="menu">
                <li class=""><a href="view-inventory.php" data-display="adminform" class="text-decoration-none px-3 py-2 d-block"><i class="fa-solid fa-list me-1 icon"></i>Dashboard</a></li>
                <hr class="">
                <li class=""><a href="#medicinemenu" data-bs-toggle="collapse"  class="text-decoration-none px-3 py-2 d-block">
                    <span class="material-symbols-outlined fs-5 icon">inventory_2</span> Medicine Management<i class="fa fa-caret-down float-end " aria-hidden="true"></i></a>
                    <ul class="nav collapse text-decoration-none px-3 py-2 flex-column" id="medicinemenu" data-bs-parent="#ordeermenu">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="medicine-create.php" data-display="adminform">Add Medicine</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="medicine-display.php" data-display="adminform">Display Medicine</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="category.php" data-display="adminform"><span class="material-symbols-outlined fs-6 icon">category</span>Category</a>
                </li>
                <li class=""><a href="#adminmenu" data-bs-toggle="collapse"  class="text-decoration-none px-3 py-2 d-block">
                <i class="fa-solid fa-truck-fast icon"></i> Orders Management<i class="fa fa-caret-down float-end " aria-hidden="true"></i></a>
                    <ul class="nav collapse text-decoration-none px-3 py-2 flex-column" id="adminmenu" data-bs-parent="#adminmenu">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="order-create.php" data-display="adminform">Add Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="order-display.php" data-display="adminform">Display Orders</a>
                        </li>
                    </ul>
                </li>
                <li class=""><a href="#customermenu" data-bs-toggle="collapse"  class="text-decoration-none px-3 py-2 d-block">
                    <span class="material-symbols-outlined fs-6 icon">sell</span> Sales Management<i class="fa fa-caret-down float-end " aria-hidden="true"></i></a>
                    <ul class="nav collapse text-decoration-none px-3 py-2 flex-column" id="customermenu" data-bs-parent="#customermenu">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="sales-create.php" data-display="adminform">Add Sales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="sales-display.php" data-display="adminform">Display Sales</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="col-1">
            <div class="d-flex justify-content-between d-md-none d-block float-end ">
                <button class="btn px-1 py-0 open-btn me-2"><i class="fal fa-stream"></i></button>
            </div>
        </div>
    </div>
</div>
