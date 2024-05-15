<div class="container bg-white " style="height: 22rem;">
<footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 my-5 border-top" >
    <div class="col mb-3">
        <a class="navbar-brand" href="home.php"><img class="logo img-fluid " src="image/logo.png" alt="logo" ></a>
        <p class="text-body-secondary ms-4">&copy; 2024</p>
        </div>

        <div class="col mb-3">

        </div>
        <div class="col mb-3">

        </div>

        <div class="col mb-3">
        <h5>Contact</h5>
        <ul class="nav flex-column mt-4">
            <li class="nav-item">Call Us</li>
            <li class="nav-item h2 fw-semibold  my-3"><a href="#" class="nav-link p-0 text-danger"><img src="image/icons/contact.png" class="pe-2 " alt="contact"><?= webSetting('phone') ?? ''; ?></a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary"><img src="image/icons/email.png" class="pe-2 " alt="email"><?= webSetting('email') ?? ''; ?></a></li>
            <li class="nav-item mt-2">Visit Us</li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Paknajol, Kathmandu <br>Lagan, Kathmandu</a></li>
        </ul>
        </div>

        <div class="col mb-3">
        <h5>Menu</h5>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="home.php" class="nav-link p-0 text-body-secondary">Home</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">About Us</a></li>
            <li class="nav-item mb-2"><a href="view-inventory.php" class="nav-link p-0 text-body-secondary">Inventory</a></li>
        </ul>
        </div>
    </footer>
</div>
<script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/dropmenu.js"></script>
    <script src="assets/js/subtotal.js"></script>
    </body>
</html>