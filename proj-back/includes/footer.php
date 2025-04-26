        </div>
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
    <script>
            $(document).ready(function () {
                $('.admineditbtn').on('click', function() {
                    $('#admineditmodal').modal('show');
                    $tr =$(this).closest('tr');

                    var data = $tr.children("td").map(function() {
                        return $(this).text();
                    }).get();

                    console.log(data);

                    $('#update_id').val(data[0]);
                    $('#name').val(data[1]);
                    $('#email').val(data[2]);
                    $('#phone').val(data[3]);
                    $('#gender').val(data [4]); 
                    $('#birth').val(data[5]);
                    $('#address').val(data[6]);
                });
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
                    $('#manufacturer').val(data[2]);
                    $('#price').val(data[3]);
                    $('#quantity').val(data [4]); 
                    $('#exp_date').val(data[5]);
                    $('#dosage').val(data[6]);
                });
            });
    </script>
    <script>
            $(document).ready(function () {
                $('.pharmacyeditbtn').on('click', function() {
                    $('#pharmacyeditmodal').modal('show');
                    
                    // Get data from data attributes
                    var id = $(this).data('id');
                    var pan = $(this).data('pan');
                    var name = $(this).data('name');
                    var email = $(this).data('email');
                    var phone = $(this).data('phone');
                    var address = $(this).data('address');
                    var isverified = $(this).data('isverified');
                    var license = $(this).data('license');
                    var document = $(this).data('document');
                    var notes = $(this).data('notes');
                    
                    // Set values in form
                    $('#pharmacy_id').val(id);
                    $('#pan').val(pan);
                    $('#name').val(name);
                    $('#email').val(email);
                    $('#phone').val(phone);
                    $('#address').val(address);
                    $('#isverified').val(isverified);
                    $('#license_number').val(license);
                    $('#verification_notes').val(notes);
                    
                    // Show current document if exists
                    if(document) {
                        $('#current_document').html('<a href="../proj-front/' + document + '" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-file-alt me-1"></i> View Current Document</a>');
                    } else {
                        $('#current_document').html('<span class="text-muted">No document uploaded</span>');
                    }
                });
                
                // View document
                $('.view-document').on('click', function() {
                    var documentPath = $(this).data('document');
                    var fileExt = documentPath.split('.').pop().toLowerCase();
                    
                    if(fileExt == 'pdf') {
                        $('#documentViewer').html('<embed src="' + documentPath + '" width="100%" height="500px" type="application/pdf">');
                    } else if(['jpg', 'jpeg', 'png'].includes(fileExt)) {
                        $('#documentViewer').html('<img src="' + documentPath + '" class="img-fluid" alt="Registration Document">');
                    } else {
                        $('#documentViewer').html('<div class="alert alert-warning">Cannot preview this file type. <a href="' + documentPath + '" target="_blank">Download</a> instead.</div>');
                    }
                    
                    $('#documentModal').modal('show');
                });
            });
    </script>
</body>
</html>