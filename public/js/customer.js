$(document).ready(function () {
    $(".container").on("click", ".delete-customer", function () {
        var customerId = $(this).data("customer-id");
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        if (
            customerId &&
            confirm(
                "Tem certeza que deseja excluir este endereço, esta ação é irreversivel?"
            )
        ) {
            $.ajax({
                url: "/account/deleteCustomer",
                type: "POST",
                data: {
                    _token: csrfToken,
                    customer_id: customerId,
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
});
