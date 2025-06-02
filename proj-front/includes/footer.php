<!-- <div class="container bg-white " style="height: 22rem;">
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
            <li class="nav-item h2 fw-semibold  my-3"><a href="#" class="nav-link p-0 text-danger"><img src="image/icons/contact.png" class="pe-2 " alt="contact"><? // echo webSetting('phone') ?? ''; ?></a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary"><img src="image/icons/email.png" class="pe-2 " alt="email"><? //echo webSetting('email') ?? ''; ?></a></li>
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
</div> -->
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
    <script src="assets/js/script.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/dropmenu.js"></script>
    <script src="assets/js/subtotal.js"></script>

    <script>
        // Toggle sidebar for mobile view
        document.addEventListener('DOMContentLoaded', function() {
            const openBtn = document.querySelector('.open-btn');
            const closeBtn = document.querySelector('.close-btn');
            const sidebar = document.querySelector('.sidebar');

            if (openBtn) {
                openBtn.addEventListener('click', function() {
                    sidebar.classList.add('active');
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                });
            }
        });
    </script>
    <script>
            $(document).ready(function () {
                $('.medicineeditbtn').on('click', function() {
                    $('#medicineeditmodal').modal('show');
                    $tr =$(this).closest('tr');

                    var data = $tr.children("td").map(function() {
                        return $(this).text();
                    }).get();

                    console.log(data);

                    $('#update_id').val(data[0]);
                    $('#name').val(data[1]);
                    $('#description').val(data[2]);
                    $('#category').val(data[3]);
                    $('#instock').val(data [5]); 
                    $('#buy_price').val(data [6]); 
                    $('#sell_price').val(data [7]); 
                    $('#exp_date').val(data[9]);
                });
                
                // Handle medicine delete button click
                $('.medicineDeleteBtn').on('click', function() {
                    // Get data from data attributes
                    var id = $(this).data('id');
                    var name = $(this).data('name');
                    var category = $(this).data('category');
                    var stock = $(this).data('stock');
                    
                    // Set values in the delete modal
                    $('#delete_medicine_id').val(id);
                    $('#delete_medicine_display_id').text(id);
                    $('#delete_medicine_name').text(name);
                    $('#delete_medicine_category').text(category);
                    $('#delete_medicine_stock').text(stock);
                    
                    // Show the delete modal
                    $('#medicineDeleteModal').modal('show');
                });
            });
    </script>
    <script>
            $(document).ready(function () {
                $('.categoryEditBtn').on('click', function() {
                    $('#categoryEditModal').modal('show');
                    $tr =$(this).closest('tr');

                    var data = $tr.children("td").map(function() {
                        return $(this).text();
                    }).get();

                    console.log(data);

                    $('#update_id').val(data[0]);
                    $('#name').val(data[1]);
                });
                
                // Handle category delete button click
                $('.categoryDeleteBtn').on('click', function() {
                    // Get data from data attributes
                    var id = $(this).data('id');
                    var name = $(this).data('name');
                    
                    // Set values in the delete modal
                    $('#delete_category_id').val(id);
                    $('#delete_category_display_id').text(id);
                    $('#delete_category_name').text(name);
                    
                    // Show the delete modal
                    $('#categoryDeleteModal').modal('show');
                });
            });
    </script>
    <script>
            $(document).ready(function () {
                $('.orderEditBtn').on('click', function() {
                    $('#orderEditModal').modal('show');
                    $tr =$(this).closest('tr');

                    var data = $tr.children("td").map(function() {
                        return $(this).text();
                    }).get();

                    console.log(data);

                    $('#update_id').val(data[0]);
                    $('#m_id').val(data[1]);
                    $('#name').val(data[2]);
                    $('#price').val(data[3]);
                    $('#quantity').val(data[4]);
                    $('#total').val(data[5]);
                    $('#status').val(data[6]);
                    $('#order_date').val(data[7]);
                });
                
                // Handle order delete button click
                $('.orderDeleteBtn').on('click', function() {
                    // Get data from data attributes
                    var id = $(this).data('id');
                    var medicine = $(this).data('medicine');
                    var quantity = $(this).data('quantity');
                    var total = $(this).data('total');
                    
                    // Set values in the delete modal
                    $('#delete_id').val(id);
                    $('#delete_order_id').text(id);
                    $('#delete_medicine').text(medicine);
                    $('#delete_quantity').text(quantity);
                    $('#delete_total').text(total);
                    
                    // Show the delete modal
                    $('#orderDeleteModal').modal('show');
                });
            });
    </script>
    <script>
            $(document).ready(function () {
                $('.salesEditBtn').on('click', function() {
                    $('#salesEditModal').modal('show');
                    $tr =$(this).closest('tr');

                    var data = $tr.children("td").map(function() {
                        return $(this).text();
                    }).get();

                    console.log(data);

                    $('#update_id').val(data[0]);
                    $('#m_id').val(data[1]);
                    $('#name').val(data[2]);
                    $('#price').val(data[3]);
                    $('#quantity').val(data[4]);
                    $('#total').val(data[5]);
                    $('#status').val(data[6]);
                    $('#sales_date').val(data[7]);
                });
                
                // Handle sales delete button click
                $('.salesDeleteBtn').on('click', function() {
                    // Get data from data attributes
                    var id = $(this).data('id');
                    var medicine = $(this).data('medicine');
                    var quantity = $(this).data('quantity');
                    var total = $(this).data('total');
                    
                    // Set values in the delete modal
                    $('#delete_sales_id').val(id);
                    $('#delete_sales_display_id').text(id);
                    $('#delete_sales_medicine').text(medicine);
                    $('#delete_sales_quantity').text(quantity);
                    $('#delete_sales_total').text(total);
                    
                    // Show the delete modal
                    $('#salesDeleteModal').modal('show');
                });
            });
    </script>
    <script>
        $(document).ready(function() {
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Allow users to manually close alerts
            $('.alert').click(function() {
                $(this).fadeOut('slow');
            });
        });
    </script>
    </body>
</html>