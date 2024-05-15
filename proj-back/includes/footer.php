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
                });
            });
    </script>
    <script>
            $(document).ready(function () {
                $('.pharmacyeditbtn').on('click', function() {
                    $('#pharmacyeditmodal').modal('show');
                    $tr =$(this).closest('tr');

                    var data = $tr.children("td").map(function() {
                        return $(this).text();
                    }).get();

                    console.log(data);

                    $('#pan').val(data[0]);
                    $('#name').val(data[1]);
                    $('#email').val(data[2]);
                    $('#phone').val(data[3]);
                    $('#address').val(data [4]); 
                });
            });
    </script>
</body>
</html>