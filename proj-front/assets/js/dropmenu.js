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


const admin = document.querySelector("#admin");
const user = document.querySelector("#user");
const meds = document.querySelector("#meds");
const order = document.querySelector("#order");

admin.addEventListener('click', () => {
    let down = admin.querySelector("#down");
    let up = admin.querySelector("#up");

    if(down.style.display == 'inline'){
        down.style.display = 'none'
        up.style.display = 'inline';
    }else{
        down.style.display = 'inline'
        up.style.display = 'none';
    }
});

user.addEventListener('click', () => {
    let down = user.querySelector("#down");
    let up = user.querySelector("#up");

    if(down.style.display == 'inline'){
        down.style.display = 'none'
        up.style.display = 'inline';
    }else{
        down.style.display = 'inline'
        up.style.display = 'none';
    }
});

meds.addEventListener('click', () => {
    let down = meds.querySelector("#down");
    let up = meds.querySelector("#up");

    if(down.style.display == 'inline'){
        down.style.display = 'none'
        up.style.display = 'inline';
    }else{
        down.style.display = 'inline'
        up.style.display = 'none';
    }
});

order.addEventListener('click', () => {
    let down = order.querySelector("#down");
    let up = order.querySelector("#up");

    if(down.style.display == 'inline'){
        down.style.display = 'none'
        up.style.display = 'inline';
    }else{
        down.style.display = 'inline'
        up.style.display = 'none';
    }
});
function showList(id) {
    // Get the list element and its list items
    var list = document.getElementById(id);
    var listItems = list.getElementsByTagName('li');
    list.classList.toggle("show");
    // Initialize the total height variable
    var totalHeight = 0;

    // Loop through the list items and calculate their heights
    for (var i = 0; i < listItems.length; i++) {
        totalHeight += listItems[i].offsetHeight;
    }

    // Set the height of the list element to the total height of its list items
    list.style.height = list.classList.contains('show') ? totalHeight + 'px' : '50px';
}

