document.addEventListener("DOMContentLoaded", () => {
    let input = document.querySelector("#discountAmountInput");

    let subTotalAmount = parseInt(
        document.querySelector("#subTotalAmount").innerHTML
    );

    let grandTotalValue = parseInt(
        document.querySelector("#grandTotalAmount").innerHTML
    );

    input.addEventListener("input", (e) => {

        let discountAmountInputValue = parseInt(e.target.value);
        let grandTotal = parseInt(grandTotalValue);

        if (e.target.value === "") {
            e.target.value = 0;
        } else {
            console.log(
                "Discount amount changed to:",
                parseInt(e.target.value)
            );

            if (discountAmountInputValue > subTotalAmount) {
                alert("Discount amount cannot be greater than the subtotal!");
                e.target.value = 0;
                document.querySelector("#grandTotalAmount").innerHTML = subTotalAmount;
            } else {
                let discountedTotal = grandTotal - discountAmountInputValue;
                document.querySelector("#grandTotalAmount").innerHTML = discountedTotal;
            }
        }
    });
});
