<?php include 'includes/header.php'; ?>

<div class="main-container">
	<?php include 'includes/dashboard.php'; ?>
	<div class="container-fluid p-5 bg-body-tertiary">
		<div class="row mb-4">
			<div class="col">
				<h2>My Profile</h2>
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="view-inventory.php">Dashboard</a></li>
						<li class="breadcrumb-item active">Profile</li>
					</ol>
				</nav>
			</div>
		</div>
		
		<!-- Form START -->
		<div class="row">
			<div class="col-12">
				<form action="php/updateprofile.php" method="POST" class="file-upload">
					<?php
					$user_id = $_SESSION['loggedInUser']['user_id'];

					$pharmacy = getById('tbl_pharmacy', 'pharmacy_id', $user_id);
					$pharmacypassword = getById('role', 'user_id', $user_id);
					if ($pharmacy['status'] == 200) {
					?>
						<div class="row">
							<!-- Contact detail -->
							<div class="col-md-6 mb-4">
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Pharmacy Details</h4>
										<div class="mb-3">
											<label class="form-label">Pharmacy Name</label>
											<input type="text" class="form-control" value="<?= $pharmacy['data']['pharmacy_name'] ?>" name="pharmacy_name" required>
										</div>
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input type="email" class="form-control" value="<?= $pharmacy['data']['email'] ?>" name="email">
										</div>
										<div class="mb-3">
											<label class="form-label">Phone</label>
											<input type="text" class="form-control" value="<?= $pharmacy['data']['phone'] ?>" maxlength="10" name="phone">
										</div>
										<div class="mb-3">
											<label class="form-label">Address</label>
											<input type="text" class="form-control" value="<?= $pharmacy['data']['address'] ?>" name="address">
										</div>
									</div>
								</div>
							</div>

							<!-- Change password -->
							<div class="col-md-6 mb-4">
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Change Password</h4>
										<div class="mb-3">
											<label class="form-label">Old password *</label>
											<input type="password" class="form-control" name="oldpassword">
										</div>
										<div class="mb-3">
											<label class="form-label">New password *</label>
											<input type="password" class="form-control" name="newpassword">
										</div>
										<div class="mb-3">
											<label class="form-label">Confirm Password *</label>
											<input type="password" class="form-control" name="confirmnewpassword">
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Submit button -->
						<div class="row">
							<div class="col-12">
								<button type="submit" class="btn btn-danger px-4" name="update-profile">Update Profile</button>
							</div>
						</div>
					<?php
					} else {
						echo "<div class='alert alert-danger'>Error: " . $pharmacy['status'] . '</div>';
					}
					?>
				</form> <!-- Form END -->
			</div>
		</div>
	</div>
</div>

<script>
    // Toggle sidebar for mobile view
    document.addEventListener('DOMContentLoaded', function() {
        const openBtn = document.querySelector('.open-btn');
        const closeBtn = document.querySelector('.close-btn');
        const sidebar = document.querySelector('.sidebar');
        
        if (openBtn) {
            openBtn.addEventListener('click', function() {
                sidebar.classList.add('active');
            });
        }
        
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                sidebar.classList.remove('active');
            });
        }
    });
</script>