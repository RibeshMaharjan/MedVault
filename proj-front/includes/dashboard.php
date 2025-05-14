<div class="sidebar pt-3" id="side_nav">
    <div class="row">
        <div class="col">
            <!-- Logo at the top of sidebar -->
            <div class="text-center mb-3">
                <img src="image/logo.png" alt="logo" style="max-height: 120px;">
            </div>
            
            <div class="d-flex justify-content-between ms-3">
                <button class="btn d-md-none d-block close-btn px-1 py-0 text-dark">
                    <i class="fal fa-stream"></i>
                </button>
            </div>
            <ul class="nav flex-column mt-2 mt-sm-0 list-unstyled px-2" id="menu">
                <?php 
                $current_page = basename($_SERVER['PHP_SELF']);
                $dashboard_active = ($current_page == 'view-inventory.php') ? 'active' : '';
                $profile_active = ($current_page == 'edit-profile.php') ? 'active' : '';
                $medicine_active = (strpos($current_page, 'medicine-') !== false) ? 'active' : '';
                $category_active = ($current_page == 'category.php') ? 'active' : '';
                $order_active = (strpos($current_page, 'order-') !== false) ? 'active' : '';
                $sales_active = (strpos($current_page, 'sales-') !== false) ? 'active' : '';
                $analysis_sales_active = ($current_page == 'analysis-sales.php') ? 'active' : '';
                $analysis_order_active = ($current_page == 'analysis-order.php') ? 'active' : '';
                
                // Auto-expand section dropdowns
                $medicine_show = ($medicine_active) ? 'show' : '';
                $order_show = ($order_active) ? 'show' : '';
                $sales_show = ($sales_active) ? 'show' : '';
                ?>
                <li class="<?= $dashboard_active ?>"><a href="view-inventory.php" data-display="adminform" class="text-decoration-none px-3 py-2 d-block"><i class="fa-solid fa-list me-1 icon"></i>Dashboard</a></li>
                <hr class="">
                <li class="<?= $medicine_active ?>"><a href="#medicinemenu" data-bs-toggle="collapse"  class="text-decoration-none px-3 py-2 d-block">
                    <span class="material-symbols-outlined fs-5 icon">inventory_2</span> Medicine Management<i class="fa fa-caret-down float-end " aria-hidden="true"></i></a>
                    <ul class="nav collapse <?= $medicine_show ?> text-decoration-none px-3 py-2 flex-column" id="medicinemenu" data-bs-parent="#ordeermenu">
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'medicine-create.php') ? 'active' : '' ?>" aria-current="page" href="medicine-create.php" data-display="adminform">Add Medicine</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'medicine-display.php') ? 'active' : '' ?>" href="medicine-display.php" data-display="adminform">Display Medicine</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item <?= $category_active ?>">
                    <a class="nav-link" aria-current="page" href="category.php" data-display="adminform"><span class="material-symbols-outlined fs-6 icon">category</span>Category</a>
                </li>
                <li class="<?= $order_active ?>"><a href="#adminmenu" data-bs-toggle="collapse"  class="text-decoration-none px-3 py-2 d-block">
                <i class="fa-solid fa-truck-fast icon"></i> Orders Management<i class="fa fa-caret-down float-end " aria-hidden="true"></i></a>
                    <ul class="nav collapse <?= $order_show ?> text-decoration-none px-3 py-2 flex-column" id="adminmenu" data-bs-parent="#adminmenu">
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'order-create.php') ? 'active' : '' ?>" aria-current="page" href="order-create.php" data-display="adminform">Add Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'order-display.php') ? 'active' : '' ?>" href="order-display.php" data-display="adminform">Display Orders</a>
                        </li>
                    </ul>
                </li>
                <li class="<?= $sales_active ?>"><a href="#customermenu" data-bs-toggle="collapse"  class="text-decoration-none px-3 py-2 d-block">
                    <span class="material-symbols-outlined fs-6 icon">sell</span> Sales Management<i class="fa fa-caret-down float-end " aria-hidden="true"></i></a>
                    <ul class="nav collapse <?= $sales_show ?> text-decoration-none px-3 py-2 flex-column" id="customermenu" data-bs-parent="#customermenu">
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'sales-create.php') ? 'active' : '' ?>" aria-current="page" href="sales-create.php" data-display="adminform">Add Sales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'sales-display.php') ? 'active' : '' ?>" href="sales-display.php" data-display="adminform">Display Sales</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item <?= $analysis_sales_active ?>">
                    <a class="nav-link" aria-current="page" href="analysis-sales.php" data-display="adminform"><span class="material-symbols-outlined fs-6 icon">category</span>Sales Analysis</a>
                </li>
                <!--<li class="nav-item <?php /*= $analysis_order_active */?>">
                    <a class="nav-link" aria-current="page" href="analysis-order.php" data-display="adminform"><span class="material-symbols-outlined fs-6 icon">category</span>Order Analysis</a>
                </li>-->
                <li class="nav-item <?= $profile_active ?>">
                    <a class="nav-link" aria-current="page" href="edit-profile.php" data-display="adminform"><span class="material-symbols-outlined fs-6 icon">person</span>Profile</a>
                </li>
            </ul>
            
            <!-- Logout button positioned at bottom of sidebar -->
            <div class="position-absolute bottom-0 w-100 mb-3 px-3">
                <a href="../proj-back/logout.php" class="btn btn-danger w-100 py-2 d-flex align-items-center justify-content-center shadow-sm">
                    <span class="material-symbols-outlined me-2">logout</span>
                    <span class="fw-medium">Sign Out</span>
                </a>
            </div>
        </div>
        <div class="col-1">
            <div class="d-flex justify-content-between d-md-none d-block float-end ">
                <button class="btn px-1 py-0 open-btn me-2"><i class="fal fa-stream"></i></button>
            </div>
        </div>
    </div>
</div>
