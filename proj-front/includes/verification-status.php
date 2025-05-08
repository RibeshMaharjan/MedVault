<?php
// Check verification status
if(isset($_SESSION['loggedInUser']['user_id'])) {
    $pharmacy_id = $_SESSION['loggedInUser']['user_id'];
    $verify_check = mysqli_query($conn, "SELECT isverified, verification_request_date FROM tbl_pharmacy WHERE pharmacy_id = $pharmacy_id");
    $verify_data = mysqli_fetch_assoc($verify_check);

    if($verify_data['isverified'] == 0) {
        if(empty($verify_data['verification_request_date'])) {
            // Not verified and no request - show a persistent notification
            ?>
            <div class="verification-banner not-verified">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Your account is not verified!</strong> 
                            Please complete your verification in profile settings to access all features.
                        </div>
                        <div class="col-md-3 text-end">
                            <a href="edit-profile.php" class="btn btn-sm btn-outline-light">Complete Verification</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            // Verification pending - show a persistent notification
            ?>
            <div class="verification-banner pending">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <i class="fas fa-clock me-2"></i>
                            <strong>Verification in progress!</strong> 
                            Your verification request is under review by our team. We'll notify you once it's approved.
                        </div>
                        <div class="col-md-3 text-end">
                            <a href="edit-profile.php" class="btn btn-sm btn-outline-light">View Status</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
?>

<style>
.verification-banner {
    padding: 12px 0;
    color: white;
    position: sticky;
    top: 0;
    z-index: 1020;
    width: 100%;
    font-size: 14px;
}

.verification-banner.not-verified {
    background-color: #dc3545;
}

.verification-banner.pending {
    background-color: #ffc107;
    color: #212529;
}

.verification-banner .btn-outline-light {
    border-color: rgba(255, 255, 255, 0.5);
    font-size: 13px;
    padding: 5px 10px;
}

.verification-banner.pending .btn-outline-light {
    border-color: rgba(33, 37, 41, 0.5);
    color: #212529;
}

@media (max-width: 768px) {
    .verification-banner {
        font-size: 12px;
    }
    
    .verification-banner .btn-sm {
        font-size: 12px;
        padding: 3px 8px;
    }
}
</style> 