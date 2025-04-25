document.addEventListener("DOMContentLoaded", () => {
    const addToCart = (button) => {
        const id = button.dataset.id;
        const name = button.dataset.name;
        const quantity = button.dataset.quantity || 1; // Default to 1 if not provided
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
                flasher.error("Oops! Something went wrong!", error.message);
            });
    };
    
    // Add event listeners to the "Add to Cart" buttons on the product page
    const addToCartButtons = document.querySelectorAll(".add-to-cart");
    addToCartButtons.forEach((button) => {
        button.addEventListener("click", (event) => {
            event.preventDefault();
            addToCart(button);
        });
    });
});
