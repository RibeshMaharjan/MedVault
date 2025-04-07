<?php include './includes/header.php'; ?>
    <div class="main-container d-flex">
        <?php include 'includes/dashboard.php'; ?>
        <div class="container-fluid p-5 bg-body-tertiary">
            <!-- Medicine Statistics -->
            <div class="row pt-4 mb-5">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Medicine Types</h5>
                            <p class="card-text text-danger h3"><?= getTotalById("user_medicine_tbl","pharmacy_id",$user_id); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Categories</h5>
                            <p class="card-text text-danger h3"><?= getTotalById("user_category_tbl","pharmacy_id",$user_id); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Low Stock Items</h5>
                            <?php
                                $lowStockQuery = "SELECT COUNT(*) as count FROM user_medicine_tbl WHERE pharmacy_id = '$user_id' AND in_stock <= 10";
                                $lowStockResult = mysqli_query($conn, $lowStockQuery);
                                $lowStockCount = mysqli_fetch_assoc($lowStockResult)['count'];
                            ?>
                            <p class="card-text text-warning h3"><?= $lowStockCount ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Out of Stock</h5>
                            <?php
                                $outStockQuery = "SELECT COUNT(*) as count FROM user_medicine_tbl WHERE pharmacy_id = '$user_id' AND in_stock = 0";
                                $outStockResult = mysqli_query($conn, $outStockQuery);
                                $outStockCount = mysqli_fetch_assoc($outStockResult)['count'];
                            ?>
                            <p class="card-text text-danger h3"><?= $outStockCount ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category-wise Medicine Distribution -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Medicine by Category</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Medicine Count</th>
                                            <th>Total Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $categoryQuery = "SELECT c.category_name, 
                                                            COUNT(m.m_id) as med_count,
                                                            SUM(m.in_stock) as total_stock
                                                            FROM user_category_tbl c
                                                            LEFT JOIN user_medicine_tbl m ON c.c_id = m.c_id
                                                            WHERE c.pharmacy_id = '$user_id'
                                                            GROUP BY c.c_id, c.category_name";
                                            $categoryResult = mysqli_query($conn, $categoryQuery);
                                            while($row = mysqli_fetch_assoc($categoryResult)) {
                                                echo "<tr>
                                                        <td>{$row['category_name']}</td>
                                                        <td>{$row['med_count']}</td>
                                                        <td>{$row['total_stock']}</td>
                                                    </tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Low Stock Alert</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Medicine Name</th>
                                            <th>Current Stock</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $lowStockDetailQuery = "SELECT medicine_name, in_stock 
                                                                FROM user_medicine_tbl 
                                                                WHERE pharmacy_id = '$user_id' 
                                                                AND in_stock <= 10
                                                                ORDER BY in_stock ASC";
                                            $lowStockDetailResult = mysqli_query($conn, $lowStockDetailQuery);
                                            while($row = mysqli_fetch_assoc($lowStockDetailResult)) {
                                                $status = $row['in_stock'] == 0 ? 
                                                    '<span class="badge bg-danger">Out of Stock</span>' : 
                                                    '<span class="badge bg-warning">Low Stock</span>';
                                                echo "<tr>
                                                        <td>{$row['medicine_name']}</td>
                                                        <td>{$row['in_stock']}</td>
                                                        <td>{$status}</td>
                                                    </tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Recent Activities</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Medicine</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Combine recent sales and orders
                                            $recentActivityQuery = "
                                                (SELECT 
                                                    sales_date as date,
                                                    'Sale' as type,
                                                    m.medicine_name,
                                                    s.quantity,
                                                    s.status
                                                FROM user_sales_tbl s
                                                JOIN user_medicine_tbl m ON s.m_id = m.m_id
                                                WHERE s.pharmacy_id = '$user_id')
                                                UNION
                                                (SELECT 
                                                    order_date as date,
                                                    'Order' as type,
                                                    m.medicine_name,
                                                    o.quantity,
                                                    o.status
                                                FROM user_order_tbl o
                                                JOIN user_medicine_tbl m ON o.m_id = m.m_id
                                                WHERE o.pharmacy_id = '$user_id')
                                                ORDER BY date DESC
                                                LIMIT 10";
                                            
                                            $recentActivityResult = mysqli_query($conn, $recentActivityQuery);
                                            while($row = mysqli_fetch_assoc($recentActivityResult)) {
                                                $statusClass = $row['status'] == 'completed' ? 'bg-success' : 'bg-warning';
                                                echo "<tr>
                                                        <td>" . date('M d, Y', strtotime($row['date'])) . "</td>
                                                        <td>{$row['type']}</td>
                                                        <td>{$row['medicine_name']}</td>
                                                        <td>{$row['quantity']}</td>
                                                        <td><span class='badge {$statusClass}'>{$row['status']}</span></td>
                                                    </tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include './includes/footer.php'; ?>