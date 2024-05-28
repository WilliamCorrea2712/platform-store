document.querySelectorAll('input[name="stock"]').forEach((radio) => {
    radio.addEventListener("change", function () {
        if (this.checked) {
            const selectedId = this.getAttribute("data-id");
            const selectedAttributeId = this.getAttribute("data-attribute-id");
            document.getElementById("selectedId").value = selectedId;
            document.getElementById("selectedAttributeId").value =
                selectedAttributeId;
        }
    });
});

$(".remove-product-form").submit(function (event) {
    event.preventDefault();

    var id = $(this).find("input[name='id']").val();
    var productId = $(this).find("input[name='product_id']").val();
    var attributeId = $(this).find("input[name='attribute_id']").val();

    if (id !== "" && productId !== "" && attributeId !== "") {
        $(this).unbind("submit").submit();
    } else {
        $("#message-cart").text("Selecione uma opção de estoque!").show();

        setTimeout(function () {
            $("#message-cart").fadeOut();
        }, 2000);
    }
});

$(document).ready(function () {
    $('input[type="number"]').on("change", function () {
        var productId = $(this).attr("id").split("_")[1];
        var inputValue = $(this).val();
        var updateBtn = $("#quantity_" + productId)
            .next(".input-group-append")
            .find(".update-quantity-btn");

        if (inputValue != $("#quantity_" + productId).data("original-value")) {
            updateBtn.removeClass("d-none");
        } else {
            updateBtn.addClass("d-none");
        }
    });

    $(".update-quantity-btn").click(function () {
        var productId = $(this).data("product-id");
        var newQuantity = $("#quantity_" + productId).val();
        var quantityCurrent = $("#quantity_current_" + productId).val();
        var id = $("#id_" + productId).val();
        var attributeId = $("#attribute_id_" + productId).val();
        var productId = $("#product_id_" + productId).val();

        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: "/update_quantity_cart",
            type: "POST",
            data: {
                id: id,
                product_id: productId,
                attribute_id: attributeId,
                quantity: newQuantity,
                quantityCurrent: quantityCurrent,
                _token: csrfToken,
            },
            success: function (response) {
                location.reload();
            },
            error: function (xhr, status, error) {
                var errorMessage =
                    xhr.responseJSON && xhr.responseJSON.error
                        ? xhr.responseJSON.error
                        : error;
                location.reload();
                //$("#message-cart").text(errorMessage).show();
            },
        });
    });
});
