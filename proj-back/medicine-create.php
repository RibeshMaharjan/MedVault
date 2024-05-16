<?php include './includes/header.php'; ?>
        <div class="dashboard-content px-3 pt-4 ">
            <div class="container-fluid bg-white">
                <div class="row px-3 p-4">
                    <div class="col"><h1 class="fw-normal mb-3">Append Medicine From</h1></div>
                </div>
                <div class="row px-3 pb-4">
                    <form action="code.php" class="form" method="POST" id="form" autocomplete="off" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Medicine Name</label>
                            <input class="form-control" type="text" placeholder="Medicine Name" aria-label="default input example" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="manufacturername" class="form-label">Manufacturere</label>
                            <input type="text" class="form-control" placeholder="Manufacturere" name="manufacturername">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control" placeholder="Price" name="price">
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" placeholder="Quantity" name="quantity">
                        </div>
                        <div class="mb-3">
                            <label for="dosage" class="form-label">Dosage</label>
                            <select class="form-select" id="floatingSelect" name="dosage">
                                <option selected value="Not Selected">Dosage</option>
                                <option value="tablet">Tablet</option>
                                <option value="capsule">Capsule</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exp_date" class="form-label">Expiration Date</label>
                            <input type="date" class="form-control" name="exp_date">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Upload Image</label>
                            <input class="form-control" type="file" name="images" id="inputTag">
                        </div>
                        <input type="submit" value="Add" class="btn btn-danger" name="add-medicine">
                    </form>
                </div>
            </div>
        </div>
<?php include './includes/footer.php'; ?>