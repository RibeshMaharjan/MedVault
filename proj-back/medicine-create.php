<?php include './includes/header.php'; ?>
        <div class="dashboard-content px-3 pt-4 ">
            <div class="container-fluid bg-white">
                <div class="row px-3 p-4">
                    <div class="col"><h1 class="fw-normal mb-3">Append Medicine From</h1></div>
                </div>
                <div class="row px-3 pb-4">
                    <form action="code.php" class="form" method="POST" id="form" autocomplete="off">
                        <div class="mb-3">
                            <label for="name" class="form-label">Medicine Name</label>
                            <input class="form-control" type="text" placeholder="Full Name" aria-label="default input example" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="manufacturername" class="form-label">Manufacturere</label>
                            <input type="text" class="form-control" aria-describedby="emailHelp" name="manufacturername">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control"  name="price">
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control"  name="quantity">
                        </div>
                        <div class="mb-3">
                            <label for="dosage" class="form-label">Dosage</label>
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="gender">
                                <option selected value="Not Selected">Dosage</option>
                                <option value="tablet">Tablet</option>
                                <option value="capsule">Capsule</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exp_date" class="form-label">Expiration Date</label>
                            <input type="date" class="form-control" name="birth" required name="exp_date">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Default file input example</label>
                            <input class="form-control" type="file" name="images" id="inputTag">
                        </div><div class="input_field">
                        <!-- <label for="image">Upload Image</label>
                            <input type="file" name="image" multiple class="image"> -->
                    </div>
                        <input type="submit" value="Add" class="btn btn-danger" name="add-medicine">
                    </form>
                </div>
            </div>
        </div>
<?php include './includes/footer.php'; ?>