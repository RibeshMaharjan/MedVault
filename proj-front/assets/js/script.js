//Getting value from "ajax.php".

function fill(Value) {

//Assigning value to "search" div in "search.php" file.

$('#search').val(Value);

//Hiding "display" div in "search.php" file.

$('#display').hide();

}

// Search functionality
$(document).ready(function() {
    // Instant search for medicine names
    $("#search").keyup(function() {
        var name = $('#search').val();
        
        if (name === "") {
            $("#display").html("").hide();
        } else {
            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: {
                    search: name
                },
                success: function(html) {
                    $("#display").html(html).show();
                }
            });
        }
    });

    // Order suggest form
    $('#order-suggest-form').submit(function(e) {
        e.preventDefault();
        var formData = {
            'm_name': $('#search').val()
        };
        $.ajax({
            type: 'POST',
            url: 'php/ajax2.php',
            data: formData,
            success: function(html) {
                $('#product-info').html(html).show();
                updateCalculations();
            }
        });
    });

    // Sales suggest form
    $('#sales-suggest-form').submit(function(e) {
        e.preventDefault();
        var formData = {
            'm2_name': $('#search').val()
        };
        $.ajax({
            type: 'POST',
            url: 'php/ajax2.php',
            data: formData,
            success: function(html) {
                $('#product-info').html(html).show();
                updateCalculations();
            }
        });
    });

    // Auto-calculate totals when quantity changes
    $(document).on('input', '#quantity', function() {
        updateCalculations();
    });

    // Helper function to update calculations
    function updateCalculations() {
        var price = $('#price').val();
        var qty = $('#quantity').val();
        var total = qty * price;
        $('#total').val(total.toFixed(2));
    }

    // Filter form handling
    $('.filter-form').on('submit', function(e) {
        e.preventDefault();
        var queryString = $(this).serialize();
        window.location.href = window.location.pathname + '?' + queryString;
    });

    // Date range validation
    $('input[name="date_to"]').change(function() {
        var dateFrom = $('input[name="date_from"]').val();
        var dateTo = $(this).val();
        
        if (dateFrom && dateTo && dateFrom > dateTo) {
            alert('End date must be after start date');
            $(this).val('');
        }
    });

    // Amount range validation
    $('input[name="amount_max"]').change(function() {
        var minAmount = $('input[name="amount_min"]').val();
        var maxAmount = $(this).val();
        
        if (minAmount && maxAmount && parseFloat(minAmount) > parseFloat(maxAmount)) {
            alert('Maximum amount must be greater than minimum amount');
            $(this).val('');
        }
    });

    // Reset button functionality
    $('.reset-filters').click(function() {
        $(this).closest('form').find('input, select').val('');
        $(this).closest('form').submit();
    });
});

// // Sidebar toggle functionality
// $('.open-btn').on('click', function() {
//     $('.sidebar').addClass('active');
//     $('.open-btn').addClass('d-none');
// });
//
// $('.close-btn').on('click', function() {
//     $('.sidebar').removeClass('active');
//     $('.open-btn').removeClass('d-none');
// });
//



