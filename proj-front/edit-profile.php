<?php include 'includes/header.php'; 

if (!isset($_SESSION['loggedInUser']['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

$pharmacy_id = $_SESSION['loggedInUser']['user_id'];

// Get pharmacy details
$pharmacy_query = "SELECT * FROM tbl_pharmacy WHERE pharmacy_id = $pharmacy_id";
$pharmacy_result = mysqli_query($conn, $pharmacy_query);
$pharmacy_data = mysqli_fetch_assoc($pharmacy_result);

// Handle form submission
if(isset($_POST['update_profile'])) {
    $pharmacy_name = mysqli_real_escape_string($conn, $_POST['pharmacy_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    // Update profile information
    $update_query = "UPDATE tbl_pharmacy SET 
                    pharmacy_name = '$pharmacy_name',
                    email = '$email',
                    phone = '$phone',
                    address = '$address'
                    WHERE pharmacy_id = $pharmacy_id";
    
    if(mysqli_query($conn, $update_query)) {
        // Also update the role table for consistency
        $update_role_query = "UPDATE role SET 
                            name = '$pharmacy_name',
                            email = '$email'
                            WHERE user_id = $pharmacy_id";
        mysqli_query($conn, $update_role_query);
        
        // Set success message in session for toast
        $_SESSION['status'] = "Profile updated successfully!";
        echo "<script>window.location.href='edit-profile.php';</script>";
        exit;
    } else {
        $_SESSION['status'] = "Error updating profile. Please try again.";
        echo "<script>window.location.href='edit-profile.php';</script>";
        exit;
    }
}

// Handle verification form submission
if(isset($_POST['submit_verification'])) {
    $pan = mysqli_real_escape_string($conn, $_POST['pan']);
    
    // File upload for registration document
    $reg_document = '';
    if(isset($_FILES['reg_document']) && $_FILES['reg_document']['error'] == 0) {
        $target_dir = "uploads/verification/";
        
        // Create directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES["reg_document"]["name"], PATHINFO_EXTENSION);
        $new_filename = $pharmacy_id . "_" . time() . "." . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        if(move_uploaded_file($_FILES["reg_document"]["tmp_name"], $target_file)) {
            $reg_document = $target_file;
        } else {
            $upload_error = true;
        }
    }
    
    // Update verification information
    $verification_query = "UPDATE tbl_pharmacy SET 
                          pan = '$pan',
                          verification_request_date = NOW()";
    
    if(!empty($reg_document)) {
        $verification_query .= ", reg_document = '$reg_document'";
    }
    
    $verification_query .= " WHERE pharmacy_id = $pharmacy_id";
    
    if(mysqli_query($conn, $verification_query)) {
        // Set a session alert for toast message
        $_SESSION['status'] = "Verification request submitted successfully! Your request is now under review.";
        echo "<script>window.location.href='edit-profile.php';</script>";
        exit;
    } else {
        $verification_error = true;
    }
}
?>

<div class="main-container d-flex">
	<?php include 'includes/dashboard.php'; ?>
  <div class="container-fluid p-2 p-md-3 p-lg-5 max-vh-100 overflow-auto" style="max-height: 100vh; !important;">
      <?php include 'includes/navbar.php'; ?>
		<?php if(isset($verification_success)): ?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Verification request submitted successfully!</strong> Your verification request has been submitted and is under review by our team.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php endif; ?>
		
		<?php if(isset($verification_error)): ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Error!</strong> There was a problem submitting your verification request. Please try again.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php endif; ?>
		
		<?php if(isset($upload_error)): ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Error!</strong> There was a problem uploading your document. Please try again.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php endif; ?>
		
		<div class="row pt-4 mb-5">
			<div class="col-lg-6 mb-4">
				<div class="card border-0 shadow">
					<div class="card-header bg-danger text-white">
						<p class="fw-semibold fs-4 mb-0">Edit Profile</p>
					</div>
					<div class="card-body">
						<form action="" method="post">
							<div class="mb-3">
								<label for="pharmacy_name" class="form-label">Pharmacy Name</label>
								<input type="text" class="form-control" id="pharmacy_name" name="pharmacy_name" value="<?php echo $pharmacy_data['pharmacy_name']; ?>" required>
							</div>
							<div class="mb-3">
								<label for="email" class="form-label">Email</label>
								<input type="email" class="form-control" id="email" name="email" value="<?php echo $pharmacy_data['email']; ?>" required>
							</div>
							<div class="mb-3">
								<label for="phone" class="form-label">Phone</label>
								<input type="text" class="form-control" id="phone" name="phone" value="<?php echo $pharmacy_data['phone']; ?>" required>
							</div>
							<div class="mb-3">
								<label for="address" class="form-label">Address</label>
								<input type="text" class="form-control" id="address" name="address" value="<?php echo $pharmacy_data['address']; ?>" required>
							</div>
							<button type="submit" name="update_profile" class="btn btn-danger">Update Profile</button>
						</form>
					</div>
				</div>
			</div>
			
			<div class="col-lg-6 mb-4">
				<div class="card border-0 shadow">
					<div class="card-header bg-danger text-white">
						<p class="fw-semibold fs-4 mb-0">Verification Status</p>

					</div>
					<div class="card-body">
						<?php if($pharmacy_data['isverified'] == 1): ?>
							<!-- Verified Status -->
							<div class="verification-status verified">
								<div class="status-icon mb-3">
									<i class="fas fa-check-circle fa-3x text-success"></i>
								</div>
								<h5 class="text-success mb-3">Your pharmacy is verified!</h5>
								<div class="verification-details">
									<div class="detail-item d-flex justify-content-between mb-2">
										<span class="fw-bold">Status:</span>
										<span class="badge bg-success rounded-pill p-2">Verified</span>
									</div>
									<div class="detail-item d-flex justify-content-between mb-2">
										<span class="fw-bold">Verification Date:</span>
										<span><?php echo date('F j, Y', strtotime($pharmacy_data['verification_date'])); ?></span>
									</div>
									<div class="detail-item d-flex justify-content-between mb-2">
										<span class="fw-bold">Pan Number:</span>
										<span><?php echo $pharmacy_data['pan']; ?></span>
									</div>
									<?php if(!empty($pharmacy_data['verification_notes'])): ?>
									<div class="detail-item mb-2">
										<span class="fw-bold d-block mb-1">Notes:</span>
										<div class="bg-light p-2 rounded"><?php echo $pharmacy_data['verification_notes']; ?></div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						<?php elseif(!empty($pharmacy_data['verification_request_date'])): ?>
							<!-- Pending Verification Status -->
							<div class="verification-status pending">
								<div class="status-icon mb-3">
									<i class="fas fa-clock fa-3x text-warning"></i>
								</div>
								<h5 class="text-warning mb-3">Verification in progress!</h5>
								<div class="verification-details">
									<div class="detail-item d-flex justify-content-between mb-2">
										<span class="fw-bold">Status:</span>
										<span class="badge bg-warning text-dark rounded-pill p-2">Pending</span>
									</div>
									<div class="detail-item d-flex justify-content-between mb-2">
										<span class="fw-bold">Request Date:</span>
										<span><?php echo date('F j, Y', strtotime($pharmacy_data['verification_request_date'])); ?></span>
									</div>
									<div class="detail-item d-flex justify-content-between mb-2">
										<span class="fw-bold">Pan Number:</span>
										<span><?php echo $pharmacy_data['pan']; ?></span>
									</div>
									<?php if(!empty($pharmacy_data['reg_document'])): ?>
									<div class="detail-item d-flex justify-content-between mb-2">
										<span class="fw-bold">Document:</span>
										<a href="<?php echo $pharmacy_data['reg_document']; ?>" target="_blank" class="btn btn-sm btn-outline-secondary">View</a>
									</div>
									<?php endif; ?>
									<?php if(!empty($pharmacy_data['verification_notes'])): ?>
									<div class="detail-item mb-2">
										<span class="fw-bold d-block mb-1">Notes:</span>
										<div class="bg-light p-2 rounded"><?php echo $pharmacy_data['verification_notes']; ?></div>
									</div>
									<?php endif; ?>
								</div>
								<div class="alert alert-info mt-3">
									<i class="fas fa-info-circle"></i> Your verification request is under review by our team. We'll notify you once it's approved.
								</div>
							</div>
						<?php else: ?>
							<!-- Not Verified Status -->
							<div class="verification-status not-verified">
								<div class="status-icon mb-3">
									<i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
								</div>
								<h5 class="text-danger mb-3">Not Verified!</h5>
								<div class="alert alert-warning mb-3">
									<i class="fas fa-info-circle"></i> Verification is required to access all features of the platform. Please submit your pharmacy's pan details for verification.
								</div>
								
								<form action="" method="post" enctype="multipart/form-data">
									<div class="mb-3">
										<label for="pan" class="form-label">Pharmacy Pan Number</label>
										<input type="text" class="form-control" id="pan" name="pan" required>
									</div>
									<div class="mb-3">
										<label for="reg_document" class="form-label">Registration Document (PDF/Image)</label>
										<input type="file" class="form-control" id="reg_document" name="reg_document" accept=".pdf,.jpg,.jpeg,.png" required>
										<small class="text-muted">Upload your pharmacy registration certificate or pan document.</small>
									</div>
									<button type="submit" name="submit_verification" class="btn btn-danger">Submit for Verification</button>
								</form>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'includes/footer.php'; ?>