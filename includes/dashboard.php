<div class="sidebar pt-3 " id="side_nav">

    <ul class="nav navbar-light bg-light flex-column mt-2 mt-sm-0 list-unstyled px-2" id="menu">
        <li class="active"><a href="view-inventory.php" data-display="adminform" class="text-decoration-none px-3 py-2 d-block"><i
                    class="fal fa-home"></i> Dashboard</a></li>
        <hr class="">
        <li class=""><a href="#medicinemenu" data-bs-toggle="collapse"  class="text-decoration-none px-3 py-2 d-block">
            <i class="fal fa-home"></i> Medicine Management<i class="fa fa-caret-down float-end " aria-hidden="true"></i></a>
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
            <a class="nav-link text-black " aria-current="page" href="category.php" data-display="adminform"><span class="material-symbols-outlined fs-6 ">category</span>Category</a>
        </li>
        <li class=""><a href="#adminmenu" data-bs-toggle="collapse"  class="text-decoration-none px-3 py-2 d-block">
        <span class="material-symbols-outlined fs-6">orders</span> Orders Management<i class="fa fa-caret-down float-end " aria-hidden="true"></i></a>
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
            <span class="material-symbols-outlined fs-6 ">sell</span> Sales Management<i class="fa fa-caret-down float-end " aria-hidden="true"></i></a>
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
