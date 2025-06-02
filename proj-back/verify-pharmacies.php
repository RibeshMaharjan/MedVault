<?php
include 'includes/header.php'; 

// Check if admin is logged in
if (!isset($_SESSION['loggedInUser']) || $_SESSION['loggedInUserRole'] !== 'admin') {
    echo "<script>window.location.href='../proj-front/login.php';</script>";
    exit();
}

// Handle verification action
if(isset($_POST['verify_pharmacy'])) {
    $pharmacy_id = $_POST['pharmacy_id'];
    $verification_notes = mysqli_real_escape_string($conn, $_POST['verification_notes']);
    
    $verify_query = "UPDATE tbl_pharmacy SET 
                    isverified = 1,
                    verification_date = NOW(),
                    verification_notes = '$verification_notes'
                    WHERE pharmacy_id = $pharmacy_id";
    
    if(mysqli_query($conn, $verify_query)) {
        $_SESSION['success'] = "Pharmacy verified successfully!";
        echo "<script>window.location.href='verify-pharmacies.php';</script>";
    } else {
        $_SESSION['error'] = "Error verifying pharmacy: " . mysqli_error($conn);
    }
}

// Handle rejection action
if(isset($_POST['reject_pharmacy'])) {
    $pharmacy_id = $_POST['pharmacy_id'];
    $verification_notes = mysqli_real_escape_string($conn, $_POST['verification_notes']);
    
    $reject_query = "UPDATE tbl_pharmacy SET 
                    verification_request_date = NULL,
                    verification_notes = '$verification_notes'
                    WHERE pharmacy_id = $pharmacy_id";
    
    if(mysqli_query($conn, $reject_query)) {
        $_SESSION['success'] = "Pharmacy verification request rejected!";
        echo "<script>window.location.href='verify-pharmacies.php';</script>";
    } else {
        $_SESSION['error'] = "Error rejecting verification: " . mysqli_error($conn);
    }
}

// Get pharmacies pending verification
$pending_query = "SELECT p.*, r.name, r.email as user_email 
                 FROM tbl_pharmacy p 
                 JOIN role r ON p.pharmacy_id = r.user_id 
                 WHERE p.verification_request_date IS NOT NULL 
                 AND p.isverified = 0 
                 ORDER BY p.verification_request_date DESC";
$pending_result = mysqli_query($conn, $pending_query);

// Get verified pharmacies
$verified_query = "SELECT p.*, r.name, r.email as user_email 
                  FROM tbl_pharmacy p 
                  JOIN role r ON p.pharmacy_id = r.user_id 
                  WHERE p.isverified = 1 
                  ORDER BY p.verification_date DESC";
$verified_result = mysqli_query($conn, $verified_query);

// Count pending and verified pharmacies
$pending_count = mysqli_num_rows($pending_result);
$verified_result_count = mysqli_query($conn, "SELECT COUNT(*) as count FROM tbl_pharmacy WHERE isverified = 1");
$verified_count = mysqli_fetch_assoc($verified_result_count)['count'];

// Get unverified pharmacies (no request submitted)
$unverified_query = "SELECT COUNT(*) as count FROM tbl_pharmacy 
                     WHERE verification_request_date IS NULL AND isverified = 0";
$unverified_result = mysqli_query($conn, $unverified_query);
$unverified_count = mysqli_fetch_assoc($unverified_result)['count'];

// Get total pharmacies count
$total_query = "SELECT COUNT(*) as total FROM tbl_pharmacy";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_count = $total_row['total'];

// Calculate verification rate
$verification_rate = ($total_count > 0) ? round(($verified_count / $total_count) * 100) : 0;
?>

<div class="dashboard-content bg-white py-3">
  <div class="container-fluid bg-white">
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <div class="row pt-3 ps-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pharmacy Verification</h1>
                <p class="text-muted">Manage verification requests</p>
            </div>
        </div>

    <section class="content px-2 pt-3 mb-5">
        <!-- Summary Stats -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="border-start border-warning border-4 px-3 py-2 bg-light rounded shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-25 p-2 me-3">
                            <i class="fas fa-clock text-warning fa-lg"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fs-4"><?php echo $pending_count; ?></h3>
                            <p class="text-muted mb-0 small">Pending Requests</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="border-start border-success border-4 px-3 py-2 bg-light rounded shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-25 p-2 me-3">
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fs-4"><?php echo $verified_count; ?></h3>
                            <p class="text-muted mb-0 small">Verified Pharmacies</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="border-start border-danger border-4 px-3 py-2 bg-light rounded shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-danger bg-opacity-25 p-2 me-3">
                            <i class="fas fa-exclamation-triangle text-danger fa-lg"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fs-4"><?php echo $unverified_count; ?></h3>
                            <p class="text-muted mb-0 small">Unverified Pharmacies</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="border-start border-primary border-4 px-3 py-2 bg-light rounded shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-25 p-2 me-3">
                            <i class="fas fa-percentage text-primary fa-lg"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fs-4"><?php echo $verification_rate; ?>%</h3>
                            <p class="text-muted mb-0 small">Verification Rate</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="row">
            <!-- Pending Verifications -->
            <div class="col-12 mb-4">
                <h5 class="mb-3"><i class="fas fa-clock text-warning me-2"></i>Pending Verification Requests</h5>
                <div class="table-responsive bg-white">
                    <?php if(mysqli_num_rows($pending_result) > 0): ?>
                        <table class="table table-striped">
                            <thead class="table-warning">
                                <tr>
                                    <th>ID</th>
                                    <th>NAME</th>
                                    <th>PHARMACY NAME</th>
                                    <th>PAN NUMBER</th>
                                    <th>REQUEST DATE</th>
                                    <th>DOCUMENT</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($pending_result)): ?>
                                    <tr>
                                        <td><?php echo $row['pharmacy_id']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['pharmacy_name']; ?></td>
                                        <td><?php echo $row['pan']; ?></td>
                                        <td><?php echo date('M d, Y', strtotime($row['verification_request_date'])); ?></td>
                                        <td>
                                            <?php if(!empty($row['reg_document'])): ?>
                                                <a href="../proj-front/<?php echo $row['reg_document']; ?>" target="_blank" class="btn btn-sm btn-secondary">
                                                    <i class="fas fa-file-alt me-1"></i> View
                                                </a>
                                            <?php else: ?>
                                                <span class="badge bg-secondary rounded-pill p-2">No Document</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#verifyModal<?php echo $row['pharmacy_id']; ?>">
                                                    <i class="fas fa-check me-1"></i> Verify
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger ms-1" data-bs-toggle="modal" data-bs-target="#rejectModal<?php echo $row['pharmacy_id']; ?>">
                                                    <i class="fas fa-times me-1"></i> Reject
                                                </button>
                                            </div>
                                            
                                            <!-- Verify Modal -->
                                            <div class="modal fade" id="verifyModal<?php echo $row['pharmacy_id']; ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><i class="fas fa-check-circle text-success me-2"></i>Verify Pharmacy</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="" method="post">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="pharmacy_id" value="<?php echo $row['pharmacy_id']; ?>">
                                                                <p>Are you sure you want to verify <strong><?php echo $row['pharmacy_name']; ?></strong>?</p>
                                                                <div class="mb-3">
                                                                    <label for="verification_notes" class="form-label">Verification Notes</label>
                                                                    <textarea class="form-control" name="verification_notes" rows="3"></textarea>
                                                                    <small class="text-muted">These notes will be visible to the pharmacy.</small>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" name="verify_pharmacy" class="btn btn-success">Verify</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Reject Modal -->
                                            <div class="modal fade" id="rejectModal<?php echo $row['pharmacy_id']; ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><i class="fas fa-times-circle text-danger me-2"></i>Reject Verification</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="" method="post">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="pharmacy_id" value="<?php echo $row['pharmacy_id']; ?>">
                                                                <p>Are you sure you want to reject the verification request for <strong><?php echo $row['pharmacy_name']; ?></strong>?</p>
                                                                <div class="mb-3">
                                                                    <label for="verification_notes" class="form-label">Rejection Reason</label>
                                                                    <textarea class="form-control" name="verification_notes" rows="3" required></textarea>
                                                                    <small class="text-muted">Please provide a reason for rejection. This will be visible to the pharmacy.</small>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" name="reject_pharmacy" class="btn btn-danger">Reject</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> No pending verification requests.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Verified Pharmacies -->
            <div class="col-12 mb-4">
                <h5 class="mb-3"><i class="fas fa-check-circle text-success me-2"></i>Verified Pharmacies</h5>
                <div class="table-responsive bg-white">
                    <?php if(mysqli_num_rows($verified_result) > 0): ?>
                        <table class="table table-striped">
                            <thead class="table-success">
                                <tr>
                                    <th>ID</th>
                                    <th>NAME</th>
                                    <th>PHARMACY NAME</th>
                                    <th>PAN NUMBER</th>
                                    <th>VERIFICATION DATE</th>
                                    <th>DOCUMENT</th>
                                    <th>NOTES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($verified_result)): ?>
                                    <tr>
                                        <td><?php echo $row['pharmacy_id']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['pharmacy_name']; ?></td>
                                        <td><?php echo $row['pan']; ?></td>
                                        <td><?php echo date('M d, Y', strtotime($row['verification_date'])); ?></td>
                                        <td>
                                            <?php if(!empty($row['reg_document'])): ?>
                                                <a href="../proj-front/<?php echo $row['reg_document']; ?>" target="_blank" class="btn btn-sm btn-secondary">
                                                    <i class="fas fa-file-alt me-1"></i> View
                                                </a>
                                            <?php else: ?>
                                                <span class="badge bg-secondary rounded-pill p-2">No Document</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $row['verification_notes']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> No verified pharmacies.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 