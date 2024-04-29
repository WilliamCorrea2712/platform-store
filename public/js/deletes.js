$(document).ready(function () {
    $(".container").on("click", ".delete-customer", function () {
        var Id = $(this).data("customer-id");
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        if (
            Id &&
            confirm(
                "Tem certeza que deseja excluir este cliente, esta ação é irreversivel?"
            )
        ) {
            $.ajax({
                url: "/account/deleteCustomer",
                type: "POST",
                data: {
                    _token: csrfToken,
                    customer_id: Id,
                },
                success: function (response) {
                    window.location.href = "/getCustomer";
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                },
            });
        }
    });

    $(".addresses-section").on("click", ".delete-address", function () {
        var addressId = $(this).data("address-id");
        var customerId = $(this).data("customer-id");
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        if (
            addressId &&
            confirm(
                "Tem certeza que deseja excluir este endereço, esta ação é irreversivel?"
            )
        ) {
            $.ajax({
                url: "/account/deleteAddress",
                type: "POST",
                data: {
                    _token: csrfToken,
                    address_id: addressId,
                    customer_id: customerId,
                },
                success: function (response) {
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                },
            });
        }
    });

    $(".container").on("click", ".delete-user", function () {
        var Id = $(this).data("user-id");
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        if (
            Id &&
            confirm(
                "Tem certeza que deseja excluir este usuário, esta ação é irreversivel?"
            )
        ) {
            $.ajax({
                url: "/user/deleteUser",
                type: "POST",
                data: {
                    _token: csrfToken,
                    user_id: Id,
                },
                success: function (response) {
                    window.location.href = "/getUser";
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                },
            });
        }
    });

    $(".container").on("click", ".delete-category", function () {
        var Id = $(this).data("category-id");
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        if (
            Id &&
            confirm(
                "Tem certeza que deseja excluir esta categoria, esta ação é irreversivel?"
            )
        ) {
            $.ajax({
                url: "/product/deleteCategory",
                type: "POST",
                data: {
                    _token: csrfToken,
                    category_id: Id,
                },
                success: function (response) {
                    window.location.href = "/getCategory";
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                },
            });
        }
    });

    $(".container").on("click", ".delete-brand", function () {
        var Id = $(this).data("brand-id");
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        if (
            Id &&
            confirm(
                "Tem certeza que deseja excluir esta marca, esta ação é irreversivel?"
            )
        ) {
            $.ajax({
                url: "/product/deleteBrand",
                type: "POST",
                data: {
                    _token: csrfToken,
                    brand_id: Id,
                },
                success: function (response) {
                    window.location.href = "/getBrand";
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                },
            });
        }
    });

    $(".container").on("click", ".delete-product", function () {
        var Id = $(this).data("product-id");
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        if (
            Id &&
            confirm(
                "Tem certeza que deseja excluir este produto, esta ação é irreversivel?"
            )
        ) {
            $.ajax({
                url: "/product/deleteProduct",
                type: "POST",
                data: {
                    _token: csrfToken,
                    product_id: Id,
                },
                success: function (response) {
                    window.location.href = "/getProduct";
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                },
            });
        }
    });

    $(".container").on("click", ".delete-stock", function () {
        var Id = $(this).data("stock-id");
        var product_id = $(this).data("product-id");
        var attribute_id = $(this).data("attribute-id");
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        if (
            Id &&
            confirm(
                "Tem certeza que deseja excluir esta grade de estoque, esta ação é irreversivel?"
            )
        ) {
            $.ajax({
                url: "/product/deleteStock",
                type: "POST",
                data: {
                    _token: csrfToken,
                    stock_id: Id,
                    product_id: product_id,
                    attribute_id: attribute_id,
                },
                success: function (response) {
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                },
            });
        }
    });

    $(".container").on("click", ".delete-image", function () {
        var Id = $(this).data("image-id");
        var product_id = $(this).data("product-id");
        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        if (
            Id &&
            confirm(
                "Tem certeza que deseja excluir esta imagem, esta ação é irreversível?"
            )
        ) {
            $.ajax({
                url: "/product/deleteImage",
                type: "POST",
                data: {
                    _token: csrfToken,
                    image_id: Id,
                    product_id: product_id,
                },
                success: function (response) {
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                },
            });
        }
    });

    $(".container").on("click", ".delete-product-list", function () {
        var Id = $(this).data("list-id");
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        if (
            Id &&
            confirm(
                "Tem certeza que deseja excluir esta lista de produtos, esta ação é irreversivel?"
            )
        ) {
            $.ajax({
                url: "/product/deleteListProduct",
                type: "POST",
                data: {
                    _token: csrfToken,
                    list_id: Id,
                },
                success: function (response) {
                    window.location.href = "/getListProduct";
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                },
            });
        }
    });
});
