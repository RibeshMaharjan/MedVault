<?php
// Check verification status
if(isset($_SESSION['loggedInUser']['user_id'])) {
    $pharmacy_id = $_SESSION['loggedInUser']['user_id'];
    $verify_check = mysqli_query($conn, "SELECT isverified, verification_request_date FROM tbl_pharmacy WHERE pharmacy_id = $pharmacy_id");
    $verify_data = mysqli_fetch_assoc($verify_check);
    
    if($verify_data['isverified'] == 0) {
        if(empty($verify_data['verification_request_date'])) {
            // Not verified and no request
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Your account is not verified!</strong> Please complete your verification in <a href="edit-profile.php" class="alert-link">Profile Settings</a>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            // Verification pending
            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Verification pending!</strong> Your verification request is under review.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
}
?> 