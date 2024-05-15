var quantityInput = document.getElementById("quantity");
        var priceSpan = document.getElementById("price");
        var subtotalInput = document.getElementById("subtotal");
        var subtotalParagraph = document.getElementById("sub-total");

        function updateSubtotal() {
            // Get the quantity value and price value
            var quantity = parseFloat(quantityInput.value);
            var price = parseFloat(priceSpan.innerText);

            // Calculate the subtotal
            var subtotal = quantity * price;

            // Update the value of the hidden input field
            subtotalInput.value = subtotal.toFixed(2); //toFixed(2) for two decimal places

            // Update the content of the subtotal paragraph (optional)
            subtotalParagraph.innerText = "Subtotal: " + subtotal.toFixed(2); //toFixed(2) for two decimal places
        }
        // Add event listener to the quantity input for the "input" event
        quantityInput.addEventListener("input", updateSubtotal);

        // Calculate initial subtotal
        updateSubtotal();