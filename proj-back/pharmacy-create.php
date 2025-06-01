<?php
    include_once('../config/function.php');

    $formData = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'address' => '',
        'pan' => '',
        'verification_notes' => ''
    ];

    // ADD PHARMACY
    if(isset($_POST['add-user'])) {
        $_SESSION['form_data'] = $_POST;

        $pharmacy_name = validate($_POST['name']);
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $isverified = $_POST['isverified'];
        $verification_notes = $_POST['verification_notes'];
        $pan = isset($_POST['pan']) ? $_POST['pan'] : '';

        if (empty($pharmacy_name) && empty($email) && empty($password)){
            $pharmacy_name = preg_replace('/\s+/', ' ', $pharmacy_name);

            // Check if empty
            if (empty($pharmacy_name)) {
                redirect('pharmacy-create.php','Only letters and white space allowed');
            }

            // Check length
            if (strlen($pharmacy_name) < 3) {
                redirect('pharmacy-create.php', 'Full name must be at least 3 characters');
            }

            // Check format: only letters, spaces, hyphens, apostrophes
            if (!preg_match("/^[a-zA-Z\s]+$/", $pharmacy_name)) {
                redirect('pharmacy-create.php', 'Full name can only contain letters, spaces');
            }

            if (empty($email)) {
                redirect('pharmacy-create.php', 'Email is required');
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                redirect('pharmacy-create.php', 'Invalid email');
            }

            $query = "SELECT * FROM tbl_pharmacy WHERE email = '$email'";
            $emailExistResult = $conn->query(($query));
            if(mysqli_num_rows($emailExistResult)) {
               redirect('pharmacy-create.php', 'Email already exist');
            }

            // Passowrd validation
            $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';

            if (!preg_match($pattern, $password)) {
               redirect('pharmacy-create.php', 'Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters');
            }

            if(!empty($phone) && !preg_match('/^[0-9]{10}+$/', $phone)) {
                redirect('pharmacy-create.php','Invalid Phone Number');
            }

            // PAN validation
            if(!empty($pan) && !preg_match('/^[0-9]{9}+$/', $pan)) {
                redirect('pharmacy-create.php','Invalid PAN Number');
            }

            if(isset($_POST['pan'])) {
                // check if pan already exists
                $query = "SELECT * FROM tbl_pharmacy WHERE pan = '$pan'";
                $panExistResult = $conn->query($query);

                if(mysqli_num_rows($panExistResult)) {
                    redirect('pharmacy-create.php', 'Pan already exist');
                }
            }

            // Set verification dates based on status
            $verification_request_date = 'NULL';
            $verification_date = 'NULL';
            $reg_document = '';

            // Handle file upload for a registration document
            if(isset($_FILES['reg_document']) && $_FILES['reg_document']['error'] == 0) {
               $upload_dir = '../uploads/verification/';
               $fileExt = explode('.', $_FILES['reg_document']['name']);
               $fileActualExt = strtolower(end($fileExt));
               $allowedExts = array("jpg", "jpeg", "png", "pdf");;

               if(!in_array($fileActualExt, $allowedExts)) {
                   redirect('pharmacy-create.php', "You can only upload files with the following extensions: jpg, jpeg, png, pdf.");
               }

               if($_FILES['reg_document']['size'] > 5000000) {
                   redirect('pharmacy-create.php', "File size must be less than 5 MB.");
               }

               // Create the directory if it doesn't exist
               if (!file_exists($upload_dir)) {
                   mkdir($upload_dir, 0777, true);
               }

               $filename = time() . '_' . $_FILES['reg_document']['name'];
               $file_tmp = $_FILES['reg_document']['tmp_name'];
               $fileDestination = $upload_dir . $filename;

               // Move the uploaded file
               if(!move_uploaded_file($file_tmp, $fileDestination)) {
                   redirect('pharmacy-create.php', "There was an error uploading your file.");
               }

               $reg_document = 'uploads/verification/' . $filename;
            }

            if(isset($_FILES['reg_document']) && isset($_POST['pan'])) {
                $verification_request_date = "'" . date('Y-m-d H:i:s') . "'";
            }

            if($isverified == 1) {
                $verification_date = "'" . date('Y-m-d H:i:s') . "'";

                if(empty($pan) || empty($_FILES['reg_document']['name'])) {
                    redirect('pharmacy-create.php','PAN Number or Registration Document is required for verification');;
                }
            }

            try {
                $conn->begin_transaction();

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO role (`name`,`email`,`password`,`role`) VALUES('$pharmacy_name','$email','$passwordHash','user')";

                if ($conn->query($query) === TRUE) {
                    // Retrieve the user_id generated for the newly inserted row
                    $pharmacy_id = $conn->insert_id;

                    // Insert data into the tbl_pharmacy table with verification details
                   $sql_insert = "INSERT INTO tbl_pharmacy (pharmacy_id, pan, pharmacy_name, email, phone, address, 
                   isverified, reg_document, verification_request_date, verification_date, verification_notes) 
                   VALUES('$pharmacy_id', '$pan', '$pharmacy_name', '$email', '$phone', '$address', 
                   '$isverified', '$reg_document', $verification_request_date, $verification_date, '$verification_notes')";

                    if ($conn->query($sql_insert) === TRUE) {
                        $conn->commit();
                        unset($_SESSION['form_data']);
                        redirect('pharmacy-display.php', "Pharmacy Added successfully");
                    } else {
                        $conn->rollback();
                        redirect('pharmacy-create.php', 'Failed to add pharmacy!');
                    }
                } else {
                    $conn->rollback();
                    redirect('pharmacy-create.php', 'Failed to add pharmacy!');
                }
            } catch (Exception $e) {
                redirect('pharmacy-create.php', 'Failed to add pharmacy!');
            }

        } else {
            redirect('pharmacy-create.php', 'Please fill all required fields!');
        }
    }

    // If redirected and form data is stored
    if (isset($_SESSION['form_data'])) {
        $formData = $_SESSION['form_data'];
        unset($_SESSION['form_data']); // Clear after use
    }
?>

<?php include './includes/header.php'; ?>
        <div class="dashboard-content pt-3">
            <div class="container-fluid bg-white">
                <div class="row pt-3 ps-2">
                    <div class="col-sm-6 mb-2">
                        <h1 class="m-0">Add New Pharmacy</h1>
                        <p class="text-muted">Create a new pharmacy account with verification details</p>
                    </div>
                </div>
                <div class="row px-2 pt-2">
                    <form action="" class="form" method="POST" id="form" autocomplete="off" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <div class="mb-4">
                                        <h5 class="card-title mb-0"><i class="fas fa-store-alt me-2 text-danger"></i>Basic Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Pharmacy Name *</label>
                                            <input type="text" class="form-control" aria-describedby="" name="name" value="<?= htmlspecialchars($formData['name'] ?? '') ?>" placeholder="Pharmacy Name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email *</label>
                                            <input type="email" class="form-control" placeholder="@gmail.com" name="email" value="<?= htmlspecialchars($formData['email'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password *</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="text" class="form-control" name="phone" min="10" max="10" value="<?= htmlspecialchars($formData['phone'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($formData['address'] ?? '') ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <div class="mb-4">
                                        <h5 class="card-title mb-0"><i class="fas fa-check-circle me-2 text-success"></i>Verification Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="pan" class="form-label">Pan Number</label>
                                            <input type="text" class="form-control" name="pan" value="<?= htmlspecialchars($formData['pan'] ?? '') ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="reg_document" class="form-label">Registration Document</label>
                                            <input type="file" class="form-control" name="reg_document" accept=".pdf,.jpg,.jpeg,.png">
                                            <small class="text-muted">Upload pharmacy registration document (PDF or Image)</small>
                                        </div>
                                        <div class="mb-3">
                                            <label for="isverified" class="form-label">Verification Status</label>
                                            <select class="form-select" name="isverified">
                                                <option value="0">Not Verified</option>
                                                <option value="1">Verified</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="verification_notes" class="form-label">Verification Notes</label>
                                            <textarea class="form-control" name="verification_notes" rows="3" value="<?= htmlspecialchars($formData['verification_notes'] ?? '') ?>"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                            <button type="reset" class="btn btn-secondary me-md-2">
                                Reset
                            </button>
                            <button type="submit" class="btn btn-danger" name="add-user">
                                Add Pharmacy
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?php include './includes/footer.php'; ?>