let bodybtn = document.getElementById("body");
let closebtn = document.querySelector(".close");
let listCartHTML = document.querySelector(".list-item");
let iconCartSpan = document.querySelector(".add-to-cart span:nth-child(2)")
let carts = [];
let listProducts =[];

function togglecart(){
    bodybtn.classList.toggle('showcart');
}

closebtn.addEventListener('click', () => {
    bodybtn.classList.toggle('showcart');
});

const initApp = () => {

    fetch("home.php")
        .then((response) => {
            if(!response.ok){ // Before parsing (i.e. decoding) the JSON data,
                              // check for any errors.
                // In case of an error, throw.
                throw new Error("Something went wrong!");
            }

            return response.json(); // Parse the JSON data.
        })
        .then((data) => {
            listProducts = data
            listProducts
             // This is where you handle what to do with the response.
             alert(data); // Will alert: 42
        })
        .catch((error) => {
             // This is where you handle errors.
        });
    // fetch('products.json')
    // .then(Response => Response.json())
    // .then(data => {
    //     listProducts = data;
    // })
}
initApp();

function addtocart(num, buttonElement){
    const productImage = buttonElement.getAttribute('data-image');

    let cart = carts.find((value) => value.product_id == num);
    if (cart) {
        cart.quantity = cart.quantity + 1;
    } else {
        carts.push({
            product_id: num,
            product_image: productImage,
            quantity: 1
        });
    }

    const formData = new FormData();
    formData.append('product_id', num);
    formData.append('quantity', cart ? cart.quantity : 1);

    // Send the data to the server
    fetch('add-to-cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
.then(data => {
    if (data.status === 'success') {
        console.log(data.message);
    } else {
        console.error(data.message);
    }
})

    addCartToHTML();
}

const addCartToHTML = () => {
    listCartHTML.innerHTML = '';
    let totalQuantity = 0;

    if(carts.length > 0){
        carts.forEach(cart => {
            totalQuantity = totalQuantity + cart.quantity
            let newCart = document.createElement('div');
            newCart.classList.add('item');
            newCart.dataset.id = cart.product_id;
            newCart.innerHTML = `
                <div class="image">
                    <img src="${cart.product_image}" alt="product">
                </div>
                <div class="name">
                    NAME
                </div>
                <div class="price">
                    Price
                </div>
                <div class="quantity">
                    <span class="minus"><</span>
                    <span>${cart.quantity}</span>
                    <span class="plus">></span>
                </div>
            `;
        listCartHTML.appendChild(newCart);
        })
    }
    iconCartSpan.innerHTML = totalQuantity;
}

listCartHTML.addEventListener('click', (event) => {
    let positionClick = event.target;
    if(positionClick.classList.contains('minus') || positionClick.classList.contains('plus')){
        let product_id = positionClick.parentElement.parentElement.dataset.id;
        let type = 'minus';
        if(positionClick.classList.contains('plus')){
            type ='plus';
        }
        changeQuantity(product_id, type);
    }
})

const changeQuantity = (product_id, type) => {
    let positionItemInCart = carts.findIndex((value) => value.product_id == product_id);
    if(positionItemInCart >= 0){
        switch (type) {
            case 'plus':
                carts[positionItemInCart].quantity = carts[positionItemInCart].quantity + 1;
                break;
        
            default:
                let valuechange = carts[positionItemInCart].quantity - 1;
                if(valuechange > 0){
                    carts[positionItemInCart].quantity = valuechange;
                }else{
                    carts.splice(positionItemInCart, 1);
                }
                break;
        }
    }
    addCartToHTML();
}

document.querySelectorAll('.product-card').forEach(item => {
    item.addEventListener('click', event => {
        window.location.href = item.getAttribute('data-href');
    });
});