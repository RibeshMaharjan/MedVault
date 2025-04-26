<?php include './includes/header.php'; ?>

    <div class="dashboard-content px-3 pt-4">
    
    <!-- Edit Modal -->
    <div class="modal fade" id="pharmacyeditmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Pharmacy</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="code.php" class="form" method="POST" id="form" autocomplete="off" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-store-alt me-2 text-danger"></i>Basic Information</h5>
                    <input type="hidden" name="pharmacy_id" id="pharmacy_id">
                    <div class="mb-3">
                        <label for="pan" class="form-label">PAN Number</label>
                        <input type="text" class="form-control" id="pan" name="pan">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Pharmacy Name</label>
                        <input type="text" class="form-control" id="name" name="pharmacy_name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                </div>
                <div class="col-md-6">
                    <h5><i class="fas fa-check-circle me-2 text-success"></i>Verification Information</h5>
                    <div class="mb-3">
                        <label for="license_number" class="form-label">License Number</label>
                        <input type="text" class="form-control" id="license_number" name="license_number">
                    </div>
                    <div class="mb-3">
                        <label for="reg_document" class="form-label">Registration Document</label>
                        <input type="file" class="form-control" name="reg_document" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Upload new document only if you want to replace the existing one</small>
                        <div id="current_document" class="mt-2"></div>
                    </div>
                    <div class="mb-3">
                        <label for="isverified" class="form-label">Verification Status</label>
                        <select class="form-select" name="isverified" id="isverified">
                            <option value="0">Not Verified</option>
                            <option value="1">Verified</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="verification_notes" class="form-label">Verification Notes</label>
                        <textarea class="form-control" name="verification_notes" id="verification_notes" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger" name="update-pharmacy">Save changes</button>
        </div>
        </form>
        </div>
    </div>
    </div>

    <!-- View Document Modal -->
    <div class="modal fade" id="documentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Registration Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="documentViewer"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid bg-white">
        <div class="row px-3 pt-4">
            <div class="col-md-6">
                <h1 class="m-0 text-dark">Pharmacy Table</h1>
            </div>  
            <div class="col-md-6 text-end">
                <a href="pharmacy-create.php" class="btn btn-danger">
                    <i class="fas fa-plus-circle me-2"></i>Add New Pharmacy
                </a>
            </div>

            <!-- Filter Controls -->
            <div class="row my-4">
                <div class="col-md-12">
                    <form id="filterForm" method="get" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search pharmacy..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="verification_filter" name="verification_status">
                                <option value="">All Status</option>
                                <option value="1" <?php echo isset($_GET['verification_status']) && $_GET['verification_status'] == '1' ? 'selected' : ''; ?>>Verified</option>
                                <option value="0" <?php echo isset($_GET['verification_status']) && $_GET['verification_status'] == '0' ? 'selected' : ''; ?>>Not Verified</option>
                                <option value="pending" <?php echo isset($_GET['verification_status']) && $_GET['verification_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" id="date_from" name="date_from" placeholder="From Date" value="<?php echo isset($_GET['date_from']) ? htmlspecialchars($_GET['date_from']) : ''; ?>">
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" id="date_to" name="date_to" placeholder="To Date" value="<?php echo isset($_GET['date_to']) ? htmlspecialchars($_GET['date_to']) : ''; ?>">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-danger w-100">
                                Filter
                            </button>
                        </div>
                        <div class="col-md-1">
                            <a href="pharmacy-display.php" class="btn btn-secondary w-100">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
            // Build query with filters
            $query = "SELECT p.*, r.name FROM tbl_pharmacy p JOIN role r ON p.pharmacy_id = r.user_id WHERE 1=1";
            
            // Apply verification status filter
            if (isset($_GET['verification_status']) && $_GET['verification_status'] !== '') {
                if ($_GET['verification_status'] === 'pending') {
                    $query .= " AND p.verification_request_date IS NOT NULL AND p.isverified = 0";
                } else {
                    $query .= " AND p.isverified = " . $_GET['verification_status'];
                }
            }
            
            // Apply search filter
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = mysqli_real_escape_string($conn, $_GET['search']);
                $query .= " AND (p.pharmacy_name LIKE '%$search%' OR r.name LIKE '%$search%' OR p.email LIKE '%$search%' OR p.pan LIKE '%$search%')";
            }
            
            // Apply date filters if set
            if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
                $date_from = mysqli_real_escape_string($conn, $_GET['date_from']);
                $query .= " AND DATE(p.created_at) >= '$date_from'";
            }
            
            if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
                $date_to = mysqli_real_escape_string($conn, $_GET['date_to']);
                $query .= " AND DATE(p.created_at) <= '$date_to'";
            }
            
            $query .= " ORDER BY p.pharmacy_name ASC";
            $pharmacy = mysqli_query($conn, $query);
            
            // Get count of filtered results
            $filtered_count = mysqli_num_rows($pharmacy);
            
            // Get total count
            $total_count_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_pharmacy");
            $total_count = mysqli_fetch_assoc($total_count_result)['total'];
        ?>

        <div class="px-3 pt-2 mb-3">
            <p>Showing 1 to <?php echo $filtered_count; ?> of <?php echo $total_count; ?> entries</p>
        </div>

        <!-- Pharmacy Table -->
        <div class="px-3">
            <div class="table-responsive bg-white">
                <table class="table table-striped">
                    <thead class="table-danger">
                        <tr>
                            <th scope="col">PAN</th>
                            <th scope="col">PHARMACY NAME</th>
                            <th scope="col">USER NAME</th>
                            <th scope="col">EMAIL</th>
                            <th scope="col">PHONE</th>
                            <th scope="col">STATUS</th>
                            <th scope="col">LICENSE</th>
                            <th scope="col">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        if(mysqli_num_rows($pharmacy) > 0) {
                            while($result = mysqli_fetch_assoc($pharmacy)){
                                $verification_status = '';
                                $status_badge = '';
                                
                                if($result['isverified'] == 1) {
                                    $verification_status = 'Verified';
                                    $status_badge = '<span class="badge bg-success">Verified</span>';
                                } elseif(!empty($result['verification_request_date'])) {
                                    $verification_status = 'Pending';
                                    $status_badge = '<span class="badge bg-warning text-dark">Pending</span>';
                                } else {
                                    $verification_status = 'Not Verified';
                                    $status_badge = '<span class="badge bg-danger">Not Verified</span>';
                                }
                                ?>
                                <tr>
                                    <td><?=$result['pan']?></td>
                                    <td><?=$result['pharmacy_name']?></td>
                                    <td><?=$result['name']?></td>
                                    <td><?=$result['email']?></td>
                                    <td><?=$result['phone']?></td>
                                    <td><?=$status_badge?></td>
                                    <td>
                                        <?php if(!empty($result['license_number'])): ?>
                                            <?=$result['license_number']?>
                                            <?php if(!empty($result['reg_document'])): ?>
                                                <a href="javascript:void(0)" class="ms-2 text-danger view-document" data-document="../proj-front/<?=$result['reg_document']?>" title="View Document">
                                                    <i class="fas fa-file-alt"></i>
                                                </a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <small class="text-muted">Not provided</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-success pharmacyeditbtn" 
                                                data-id="<?=$result['pharmacy_id']?>"
                                                data-pan="<?=$result['pan']?>"
                                                data-name="<?=$result['pharmacy_name']?>"
                                                data-email="<?=$result['email']?>"
                                                data-phone="<?=$result['phone']?>"
                                                data-address="<?=$result['address']?>"
                                                data-isverified="<?=$result['isverified']?>"
                                                data-license="<?=$result['license_number']?>"
                                                data-document="<?=$result['reg_document']?>"
                                                data-notes="<?=$result['verification_notes']?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a class="btn btn-sm btn-danger ms-1" href="pharmacy-delete.php?email=<?=$result["email"]?>" onclick="return confirm('Are you sure you want to delete this pharmacy?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan='8' class="text-center py-4">
                                    <div class="alert alert-info mb-0">
                                        <i class="fas fa-info-circle me-2"></i> No Data Found!
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4 mb-4">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">Previous</span>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    
    </div>

<?php include './includes/footer.php'; ?>