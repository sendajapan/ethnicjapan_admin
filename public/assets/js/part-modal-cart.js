document.addEventListener("DOMContentLoaded", () => {
    const cartTableCreator = (responseData) => {
        // console.log(responseData?.data);
        // appending to cart
        const cartContentObj = responseData.data.cartContent; // The full cart content object
        const cartContentArray = Object.values(cartContentObj); // Convert the object to an array
        const totalPrice = responseData.data.totalPrice; // The total price of all items in the cart

        // Get the table element
        let cartItemTable = document.getElementById("cartItemsTable");
        // Clear the existing table content
        cartItemTable.innerHTML = "";

        let totalPriceElement = document.getElementById("cartTotalValue");
        totalPriceElement.innerHTML = `$${totalPrice}`;

        let totalSubtotalElement = document.getElementById("cartSubTotalValue");
        totalSubtotalElement.innerHTML = `$${totalPrice}`;

        let totalItemInCart = document.getElementById("cartItemTotal");
        totalItemInCart.innerHTML = cartContentArray?.length;

        // Loop through each item in the cartContent and append it to the table
        const imageUrl = "/assets/imgs/car-parts/placeholder.jpg";
        cartContentArray.forEach((cartItem, index) => {
            const newRow = `
        <tr class="border-bottom">
            <td scope="row">
                <a href="#" class="fw-bold text-black">#${index + 1}</a>
            </td>
            <td>
                <img style="height:2.5rem; width:2.5rem; object-fit: contain;"
                    src="${imageUrl}"
                    alt="${cartItem.name}" class="img-fluid">
            </td>
            <td class="text-start">
                <p>${cartItem.name}</p>
                <p>$${cartItem.price}</p>
            </td>
            <td>
            <div class="input-group d-flex justify-content-center">
                 <button title="Decrease item quantity"
                    class="btn btn-light btn-sm fw-bold cart-item-qty-minus"
                    data-rowid="${cartItem.rowId}"">-</button>
                <input type="number"
                    class="form-control text-center cart-item-qty-input"
                    value="${cartItem.qty}"
                    data-rowid="${cartItem.rowId}" style="width: 1rem;">
                <button title="Increase item quantity"
                    class="btn btn-light btn-sm fw-bold cart-item-qty-plus"
                    data-rowid="${cartItem.rowId}" data-qty="${
                cartItem.options["max"]
            }">+</button>
            </div>
            </td>
            <td class="text-end">
                <p class="item-total-price" data-id="${cartItem.rowId}">$${
                cartItem.price * cartItem.qty
            }</p>
            </td>
            <td>
               <button title="Remove item from cart"
                    value="${cartItem.rowId}"
                    class="btn btn-instagram rounded font-sm delete-cart-item">
                    <i style="pointer-events: none" class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `;

            // Append the new row to the table body
            cartItemTable.insertAdjacentHTML("beforeend", newRow);
        });
    };

    const addToCart = (button) => {
        const id = button.dataset.id;
        const name = button.dataset.name;
        const quantity = button.dataset.quantity || 1;
        const price = button.dataset.price;

        fetch(cartStoreUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({ id, name, quantity, price }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.code === 200) {
                    cartTableCreator(data);

                    button.disabled = true;
                    button.innerHTML = "<del>" + button.innerHTML + "</del>";
                    button.classList.add("disabled");

                    flasher.success(
                        data.message || "Data has been saved successfully!"
                    );
                } else {
                    flasher.error(
                        data.message || "An unexpected error occurred."
                    );
                }
            })
            .catch((error) => {
                console.error("Fetch error:", error);
                flasher.error("Oops! Something went wrong!", error.message);
            });
    };

    document.body.addEventListener("click", (event) => {
        if (event.target && event.target.matches("a.add-to-cart")) {
            event.preventDefault();
            addToCart(event.target);
        }
    });

    // Delete cart item
    const removeCartItem = (cartRowId) => {
        // console.log("Removing cart item with row ID:", cartRowId);

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, remove it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/cart/${cartRowId}`,
                    method: "DELETE",
                    data: {
                        _token: csrfToken,
                    },
                    success: function (data) {
                        if (data.code === 200) {
                            cartTableCreator(data);
                            flasher.success(data.message);
                        }
                    },
                    error: function (xhr) {
                        console.error("Error removing cart item:", xhr);
                    },
                });
            }
        });
    };
    document.body.addEventListener("click", (event) => {
        if (event.target && event.target.matches(".delete-cart-item")) {
            const button = event.target.closest(".delete-cart-item");
            if (button) {
                event.preventDefault();
                const rowId = button.value;
                console.log("Removing cart item with row ID:", rowId);
                removeCartItem(rowId);
            }
        }
    });

    // Update cart item quantity
    document.body.addEventListener("click", (event) => {
        if (
            event.target.matches(".cart-item-qty-plus") ||
            event.target.matches(".cart-item-qty-minus")
        ) {
            event.preventDefault();
            event.preventDefault();

            const cartRowId = event.target.dataset.rowid;
            const maxQuantity = parseInt(event.target.dataset.qty);

            const input = document.querySelector(
                `.cart-item-qty-input[data-rowid='${cartRowId}']`
            );

            let qty = parseInt(input.value);

            if (event.target.matches(".cart-item-qty-plus")) {
                if (qty < maxQuantity) {
                    qty += 1;
                } else {
                    alert(
                        "You have incremented to the maximum number of quantity for this item!"
                    );
                }
            } else if (
                event.target.matches(".cart-item-qty-minus") &&
                qty > 1
            ) {
                qty -= 1;
            }

            input.value = qty;

            $.ajax({
                url: `/admin/cart/${cartRowId}`,
                method: "PUT",
                data: {
                    _token: csrfToken,
                    qty: qty,
                },
                success: function (data) {
                    if (data.code === 200) {
                        // console.log(
                        //     "Cart item updated successfully",
                        //     data.data.updatedItem
                        // );
                        const totalPrice = data.data.totalPrice;
                        const updatedItem = data.data.updatedItem;

                        let itemTotalPrice = document.querySelector(
                            `.item-total-price[data-id='${updatedItem.rowId}']`
                        );

                        itemTotalPrice.innerHTML = `$${
                            parseInt(updatedItem.price) *
                            parseInt(updatedItem.qty)
                        }`;

                        let totalPriceElement =
                            document.getElementById("cartTotalValue");
                        totalPriceElement.innerHTML = `$${totalPrice}`;

                        let totalSubtotalElement =
                            document.getElementById("cartSubTotalValue");
                        totalSubtotalElement.innerHTML = `$${totalPrice}`;
                    }
                },
                error: function (xhr) {
                    console.error("Error removing cart item:", xhr);
                },
            });

            console.log("Plus button clicked", qty);
        }
    });
});
