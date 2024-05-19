//Getting value from "ajax.php".

function fill(Value) {

//Assigning value to "search" div in "search.php" file.

$('#search').val(Value);

//Hiding "display" div in "search.php" file.

$('#display').hide();

}

$(document).ready(function() {

    //On pressing a key on "Search box" in "search.php" file. This function will be called.

    $("#search").keyup(function() {

    //Assigning search box value to javascript variable named as "name".

    var name = $('#search').val();

    //Validating, if "name" is empty.

    if (name == "") {

        //Assigning empty value to "display" div in "search.php" file.

        $("#display").html("");

    }

    //If name is not empty.

    else {

        //AJAX is called.

        $.ajax({

            //AJAX type is "Post".

            type: "POST",

            //Data will be sent to "ajax.php".

            url: "ajax.php",

            //Data, that will be sent to "ajax.php".

            data: {

                //Assigning value of "name" into "search" variable.

                search: name

            },

            //If result found, this funtion will be called.

            success: function(html) {

                //Assigning result to "display" div in "search.php" file.

                $("#display").html(html).show();

            }

        });

    }

});

$('#order-suggest-form').submit(function(e) {
    console.log("Submitted");
    var formData = {
        'm_name' : $('#search').val()
    };
    // process the form
    $.ajax({
        type        : 'POST',
        url         : 'php/ajax2.php',
        data        : formData,

        success: function(html) {
            //Assigning result to "display" div in "search.php" file.
            $('#product-info').html(html).show();
            // total();
            // $('.datePicker').datepicker('update', new Date());
        }
    });
    e.preventDefault();
});

$('#sales-suggest-form').submit(function(e) {
    var formData = {
        'm2_name' : $('#search').val()
    };
    // process the form
    $.ajax({
        type        : 'POST',
        url         : 'php/ajax2.php',
        data        : formData,

        success: function(html) {

            //Assigning result to "display" div in "search.php" file.
            $('#product-info').html(html).show();
            // total();
            // $('.datePicker').datepicker('update', new Date());
        }
    });
    e.preventDefault();
});
    

    $(document).on('input', '#quantity', function(){
        var price = $('#price').val();
        var qty = $('#quantity').val();
        var total = qty * price ;
            $('#total').val(total.toFixed(2));
            console.log(total);
    });

    $(document).on('input', '#quantity', function(){
        var price = $('#price').val();
        var qty = $('#quantity').val();
        var total = qty * price ;
            $('#total').val(total.toFixed(2));
            console.log(total);
    });

    $('.open-btn').on('click', function () {
        $('.sidebar').addClass('active');
        $('.open-btn').addClass('d-none');
    });
    
    
    $('.close-btn').on('click', function () {
        $('.sidebar').removeClass('active');
        $('.open-btn').removeClass('d-none');
    })

});




