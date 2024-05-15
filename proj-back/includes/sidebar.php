<div class="sidebar">
    <h1>Pharma</h1>
    <div class="list">
        <h3><a href="admin.php" id="dashboard">Dashboard</a></h3>
        <div class="list-item">
                <ul class="main-list" onclick="showList('admin')" id="admin">
                    <li><a>Admin Management</a><span class="material-symbols-outlined" id="down" style="display: inline;">
                        expand_more
                        </span><span class="material-symbols-outlined" id="up" style="display: none;">expand_less</span>
                        <ul class="sub-list" id="admin">
                            <li href="admin-create.php" data-display="adminform"><a href="admin-create.php" data-display="adminform">Add Admins</a></li>
                            <li href="admin-display.php" data-display="admins"><a href="admin-display.php" data-display="admins">Display Admins</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="main-list" onclick="showList('user')" id="user">
                    <li><a>Customer Management</a><span class="material-symbols-outlined" id="down" style="display: inline;">
                        expand_more
                        </span><span class="material-symbols-outlined" id="up" style="display: none;">expand_less</span>
                        <ul class="sub-list" id="user">
                            <li href="pharmacy-create.php" data-display="userform"><a href="pharmacy-create.php" data-display="userform">Add Customers</a></li>
                            <li href="pharmacy-display.php" data-display="users"><a href="pharmacy-display.php" data-display="users">Display Customers</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="main-list" onclick="showList('meds')" id="meds">
                    <li><a>Medicines Management</a><span class="material-symbols-outlined" id="down" style="display: inline;">
                        expand_more
                    </span><span class="material-symbols-outlined" id="up" style="display: none;">expand_less</span>
                    <ul class="sub-list" id="medicine">
                            <li href="medicine-create.php" data-display="medicineform"><a href="medicine-create.php" data-display="medicineform">Add Medicines</a></li>
                            <li href="medicine-display.php" data-display="medicines"><a href="medicine-display.php" data-display="medicines">Display Medicines</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="main-list" onclick="showList('order')" id="order">
                    <li><a>Orders Management</a><span class="material-symbols-outlined" id="down" style="display: inline;">
                        expand_more
                    </span><span class="material-symbols-outlined" id="up" style="display: none;">expand_less</span>
                    <ul class="sub-list" id="order">
                            <li href="order-display.php" data-display="orderdisplay"><a href="order-display.php" data-display="orderdisplay">Order Display</a></li>
                            <li href="order-pending.php" data-display="orderdisplay"><a href="order-pending.php" data-display="orderdisplay">Order Pending</a></li>
                            <li href="order-approve.php" data-display="orderdisplay"><a href="order-approve.php" data-display="orderdisplay">Order Completed</a></li>
                            <!-- <li data-display="orders"><a data-display="orders">Display Order</a></li> -->
                        </ul>
                    </li>
                </ul>
                <ul class="main-list" id="setting" onclick="handleDisplay(event)">
                    <li href="setting.php" data-display="set"><a href="setting.php" data-display="set">Settings</a></li>
                </ul>    
        </div>
    </div>
</div>