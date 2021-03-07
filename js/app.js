let messageElement = document.querySelector(".already-in-cart");

if (messageElement) {
    messageElement.addEventListener("animationend", function() {
        setTimeout(function() {
            messageElement.classList.remove("active");
        }, 2000);
    });
}

// const quantityInput = document.querySelectorAll("#quantity");
//
// quantityInput.forEach(inputField => {
//     inputField.addEventListener("change", function(event) {
//         alert("Ander");
//     });
// })


// document.getElementById("quantity").onkeyup = function() {myFunction()};
//
// function myFunction() {
//
//     var productRow = $(quantityInput).parent().parent();
//     var price = parseFloat(productRow.children('.product-price').text());
//     var quantity = $(quantityInput).val();
//     var linePrice = price * quantity;
//
//
//     let inputField = document.querySelectorAll("#quantity");
//     let cart = document.querySelectorAll("#cart-price");
//
//     let value = parseInt(inputField.value);
//
//     alert(value);
//
//
//     let cartValue = parseFloat(cart.value);
//
//     console.log(cartValue);
//
//     let totalPrice = value * cartValue;
//
//     console.log(totalPrice);
//
//     // if (value &amp;amp;lt; 100) {
//     //     value = value + 1;
//     // } else {
//     //     value =100;
//     // }
//
// }
