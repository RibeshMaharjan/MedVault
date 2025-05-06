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
                    <form action="code.php" class="form" method="POST" id="form" autocomplete="off" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <div class="mb-4">
                                        <h5 class="card-title mb-0"><i class="fas fa-store-alt me-2 text-danger"></i>Basic Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="pan" class="form-label">PAN Number *</label>
                                            <input class="form-control" type="text" aria-label="default input example" name="pan" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Pharmacy Name *</label>
                                            <input type="text" class="form-control" aria-describedby="" name="name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email *</label>
                                            <input type="email" class="form-control" placeholder="@gmail.com" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password *</label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="text" class="form-control" name="phone">
                                        </div>
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" class="form-control" name="address">
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
                                            <input type="text" class="form-control" name="pan">
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
                                            <textarea class="form-control" name="verification_notes" rows="3"></textarea>
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