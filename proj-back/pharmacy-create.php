<?php include './includes/header.php'; ?>
        <div class="dashboard-content px-3 pt-4 ">
            <div class="container-fluid bg-white">
                <div class="row px-3 p-4">
                    <div class="col"><h1 class="fw-normal mb-3">Append Pharmacy From</h1></div>
                </div>
                <div class="row px-3 pb-4">
                    <form action="code.php" class="form" method="POST" id="form" autocomplete="off">
                        <div class="mb-3">
                            <label for="pan" class="form-label">Pan No.</label>
                            <input class="form-control" type="text" aria-label="default input example" name="pan">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Pharmacy Name</label>
                            <input type="text" class="form-control" aria-describedby="" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="@gmail.com" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control"  name="password">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control"  name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control"  name="address">
                        </div>
                        <input type="submit" value="Add" class="btn btn-danger" name="add-user">
                    </form>
                </div>
            </div>
        </div>
<?php include './includes/footer.php'; ?>