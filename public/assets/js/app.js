// function handleDisplay(event) {
//     const target = event.target;
//     const mainListId = target.closest('ul').id;
//     const displayType = target.getAttribute('data-display');
//     console.log(mainListId);
//     console.log(displayType);
//     console.log(target);

//     // Hide all display-element divs
//     document.querySelectorAll('.display-element').forEach(element => {
//         element.style.display = 'none';
//     });

//     // Show the target display-element div
//     const targetElementId = `${mainListId}-${displayType}`;
//     const targetElement = document.getElementById(targetElementId);
//     if (targetElement) {
//         console.log(`Showing display-element with id ${targetElementId}`);
//         targetElement.style.display = 'block';
//     } else {
//         console.log(`No display-element found with id ${targetElementId}`);
//     }
// }

// document.querySelectorAll('.main-list .sub-list li a').forEach(a => {
//     a.addEventListener('click', handleDisplay);
// });

// document.querySelectorAll('.main-list .sub-list li').forEach(li => {
//     li.addEventListener('click', handleDisplay);
// });
// $(".sidebar ul li").on('click', function () {
//     $(".sidebar ul li.active").removeClass('active');
//     $(this).addClass('active');
// });

$(document).ready(function () {
    // Set the active class based on the current URL
    const currentUrl = window.location.pathname;
    
    // Loop through each <a> element in the sidebar
    $('#menu a').each(function () {
        const href = $(this).attr('href');

        // Check if the href matches the current URL
        if (currentUrl.includes(href)) {
            // Add 'active' class to the parent <li> element
            $(this).parent().addClass('active');

            // If the item is inside a nested menu, expand the parent menu
            $(this).closest('ul.collapse').addClass('show');
        }
    });

    // Handle click events for dynamically changing the active class
    $(".sidebar ul li").on('click', function () {
        $(".sidebar ul li.active").removeClass('active');
        $(this).addClass('active');
    });
});

$('.open-btn').on('click', function () {
    $('.sidebar').addClass('active');

});


$('.close-btn').on('click', function () {
    $('.sidebar').removeClass('active');

})