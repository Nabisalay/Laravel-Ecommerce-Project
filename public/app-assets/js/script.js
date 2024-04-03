$(document).ready(function () {
    // When the update-quantity button is clicked
    $(".update-quantity").on("click", function () {
        // Get the CSRF token from the nearest input field
        let token = $(this).closest("td").find('input[name="_token"]').val();
        // Get the action (plus or minus) from the data-action attribute
        let action = $(this).data("action");
        // Get the product ID from the data-id attribute
        let id = $(this).data("id");
        // Get the product price from the data-price attribute
        let price = $(this).data("price");
        // Find the quantity input field related to the clicked button
        let quantityInput = $(this)
            .closest(".input-group-btn")
            .siblings(".cart-quantity");
        // Find the total input field related to the clicked button's parent table cell
        let totalInput = $(this).closest("td").next("td").find(".total-price");
        // Get the current quantity value from the input field
        let quantity = quantityInput.val();
        if (quantity <= 1) {
            $(this).prop("disabled", true);
        } else {
            $(this)
                .closest(".input-group")
                .find(".btn-minus")
                .prop("disabled", false);
        }
        // Get the current total price from the total-Price element
        let finalAmount = parseFloat($("#total-Price").text().replace("$", ""));

        // Send an AJAX request to update the quantity
        $.ajax({
            url: "/mycart/update/quantity",
            type: "post",
            data: { action: action, id: id, _token: token },
            dataType: "json",
            success: function (res) {
                // If the update was successful
                if (res.success) {
                    // Update the total price display for the current item
                    totalInput.text("$ " + quantity * price);
                    // Update the total price display for all items based on the action (plus or minus)
                    if (action !== "minus") {
                        $("#total-Price").text(
                            "$ " + (finalAmount + parseFloat(price))
                        );
                    } else {
                        $("#total-Price").text(
                            "$ " + (finalAmount - parseFloat(price))
                        );
                    }
                }
            },
            error: function (err) {
                console.log(err.responseText);
            },
        });
    });
    $(".update-order-quantity").on("click", function () {
        // Get the CSRF token from the nearest input field
        let token = $(this).closest("td").find('input[name="_token"]').val();
        // Get the action (plus or minus) from the data-action attribute
        let action = $(this).data("action");
        // Get the product ID from the data-id attribute
        let id = $(this).data("id");
        // Get the product price from the data-price attribute
        let price = $(this).data("price");
        // Find the quantity input field related to the clicked button
        let quantityInput = $(this)
            .closest(".input-group-btn")
            .siblings(".cart-quantity");
        // Find the total input field related to the clicked button's parent table cell
        let totalInput = $(this).closest("td").next("td").find(".total-price");
        // Get the current quantity value from the input field
        let quantity = quantityInput.val();
        if (quantity <= 1) {
            $(this).prop("disabled", true);
        } else {
            $(this)
                .closest(".input-group")
                .find(".btn-minus")
                .prop("disabled", false);
        }
        // Get the current total price from the total-Price element
        let finalAmount = parseFloat($("#total-Price").text().replace("$", ""));

        // Send an AJAX request to update the quantity
        $.ajax({
            url: "/order/update/quantity",
            type: "post",
            data: { action: action, id: id, _token: token },
            dataType: "json",
            success: function (res) {
                // If the update was successful
                if (res.success) {
                    // Update the total price display for the current item
                    totalInput.text("$ " + quantity * price);
                    // Update the total price display for all items based on the action (plus or minus)
                    if (action !== "minus") {
                        $("#total-Price").text(
                            "$ " + (finalAmount + parseFloat(price))
                        );
                    } else {
                        $("#total-Price").text(
                            "$ " + (finalAmount - parseFloat(price))
                        );
                    }
                }
            },
            error: function (err) {
                console.log(err.responseText);
            },
        });
    });
    $('input[type="radio"]').change(function () {
        let selectedValue = $('input[name="shipping"]:checked').val();

        // Perform action on radio button change
        console.log("Selected Shipping Option:", selectedValue);
        let value = parseFloat($("#subTotal").text().replace("$", ""));
        // Perform additional actions based on the selected value
        if (selectedValue === "0") {
            $("#finalAmountinp").val(value + 5);
            $("#finalAmount").text("$" + (value + 5));
        } else if (selectedValue === "1") {
            $("#finalAmountinp").val(value + 15);
            $("#finalAmount").text("$" + (value + 15));
        }
    });
});
