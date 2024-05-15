<?php include './includes/header.php'; ?>
        <div class="dashboard-content px-3 pt-4 ">
            <div class="container-fluid bg-white">
                <div class="row px-3 p-4">
                    <div class="col"><h1 class="fw-normal mb-3">Append Admin From</h1></div>
                </div>
                <div class="row px-3 pb-4">
                    <form action="code.php" class="form" method="POST" id="form" autocomplete="off">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input class="form-control" type="text" placeholder="Full Name" aria-label="default input example" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Gender</label>
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="gender">
                                <option selected value="Not Selected">Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Birth-Date</label>
                            <input type="date" class="form-control" name="birth" required name="birth">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Address</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="address">
                        </div>
                        <input type="submit" value="Add" class="btn btn-danger" name="add-admin">
                    </form>
                </div>
            </div>
        </div>
<?php include './includes/footer.php'; ?>
