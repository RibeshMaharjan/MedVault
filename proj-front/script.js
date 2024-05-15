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
    var formData = {
        'm_name' : $('input[name=medicine_name]').val()
    };
    // process the form
    $.ajax({
        type        : 'POST',
        url         : 'ajax2.php',
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
        'm2_name' : $('input[name=medicine_name]').val()
    };
    // process the form
    $.ajax({
        type        : 'POST',
        url         : 'ajax2.php',
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

});
// function total(){
//     $('#product_info input').change(function(e)  {
//             var price = +$('input[name=price]').val() || 0;
//             var qty   = +$('input[name=quantity]').val() || 0;
//             var total = qty * price ;
//                 $('input[name=total]').val(total.toFixed(2));
//     });
// }
