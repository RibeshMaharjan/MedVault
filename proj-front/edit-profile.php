<?php include 'includes/header.php'; ?>

<div class="editcontainer">
<div>
		<div class="bodycol">
			<!-- Page title -->
			<div>
				<h3 class="h1 fs-3">My Profile</h3>
			</div>
			<!-- Form START -->
			<form action="php/updateprofile.php" method="POST" class="file-upload mainrow">
			<?php
				alertmessage();
				$user_id = $_SESSION['loggedInUser']['user_id'];

				$pharmacy = getById('tbl_pharmacy','pharmacy_id', $user_id);
				$pharmacypassword = getById('role','user_id', $user_id);
				if($pharmacy['status'] == 200){
			?>
				<div class="row1">
					<!-- Contact detail -->
					<div>
						<div class="bg-secondary-soft px-4 py-5 rounded">
							<div>
								<h4>Details</h4>
								<div class="input_field">
									<label for="pan">Pan No.</label>
									<input type="text" class="input form-control" value="<?=$pharmacy['data']['pan']?>" name="pan" required>
								</div>
								<div class="input_field">
									<label>Pharmacy Name</label>
									<input type="text" class="input form-control" value="<?=$pharmacy['data']['pharmacy_name']?>" name="pharmacy_name" required>
								</div>
								<div class="input_field">
									<label for="email">Email</label>
									<input type="email" class="email form-control" value="<?=$pharmacy['data']['email']?>" name="email" placeholder="">
								</div>
								<div class="input_field">
									<label for="phone">Phone</label>
									<input type="text" class="input form-control" value="<?=$pharmacy['data']['phone']?>" maxlength="10" name="phone">
								</div>
								<div class="input_field">
									<label for="address">Address</label>
									<input type="text" class="input form-control" value="<?=$pharmacy['data']['address']?>" name="address">
								</div>
							</div> <!-- Row END -->
						</div>
					</div>
				</div> <!-- Row END -->

				<!-- Social media detail -->
				<div class="row1">
					<!-- change password -->
					<div>
						<div class="bg-secondary-soft px-4 py-5 rounded">
							<div>
								<h4>Change Password</h4>
								<!-- Old password -->
									<label for="exampleInputPassword1">Old password *</label>
									<input type="password" class="form-control" name="oldpassword">
								<!-- New password -->
									<label for="exampleInputPassword2">New password *</label>
									<input type="password" class="form-control" name="newpassword">
								<!-- Confirm password -->
									<label for="exampleInputPassword3">Confirm Password *</label>
									<input type="password" class="form-control" name="confirmnewpassword">
							</div>
						</div>
					</div>
				</div> <!-- Row END -->
				<!-- button -->
				<div class="buttonsection">
					<input type="submit" value="Update Profile" class="btn" name="update-profile">
				</div>
				<?php
				}
				else
				{
					echo "<h5>".$pharmacy['status'].'</h5>';   
				}
				?>
			</form> <!-- Form END -->
		</div>
</div>
</div>

<?php include 'includes/footer.php'; ?>