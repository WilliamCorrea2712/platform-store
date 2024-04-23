$(document).ready(function () {
    $("#addStockBtn").click(function () {
        $(".stock:first").addClass("highlighted");

        var stockHtml = `
            <div id="message-error-success" class="alert alert-warning" role="alert" style="display: none"></div>
            <div class="stock border rounded p-3 mb-3">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="attributeName">Atributo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="attributeName[]" value="" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="attributeValue">Variação <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="attributeValue[]" value="" required>
                    </div>  
                    <div class="form-group col-md-3">
                        <label for="quantity">Quantidade <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="quantity[]" value="" required>
                    </div>                                                                                  
                    <div class="form-group col-md-2">
                        <label for="additionalValue">Valor <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="additionalValue[]" value="" required>
                    </div>   
                    <div class="form-group col-md-1">
                        <label for="operationType">Add/Desc <span class="text-danger">*</span></label>
                        <select class="form-control" name="operationType[]" required>
                            <option value="+">+</option>
                            <option value="-">-</option>
                        </select>
                    </div>                                                                                                                             
                </div>
            </div>`;
        $(".stock-section").append(stockHtml);

        $("#addStockBtn").insertBefore("#saveStockBtn").show();
        $("#stockForm").show();

        $(".highlighted label[for='attributeName']").text(
            "Atributo Principal *"
        );
    });

    $("#saveStockBtn").click(function () {
        var formData = $("#stockForm").serializeArray();
        var stockData = [];

        var productId = $(this).data("product-id");

        for (var i = 0; i < formData.length; i += 5) {
            var stockItem = {
                product_id: productId,
                attribute_name: formData[i].value,
                attribute_value: formData[i + 1].value,
                quantity: parseInt(formData[i + 2].value),
                additional_value: parseFloat(formData[i + 3].value),
                operation_type: formData[i + 4].value,
            };
            stockData.push(stockItem);
        }

        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: "/product/addStock",
            type: "POST",
            data: {
                _token: csrfToken,
                stockData: stockData,
                productId: productId,
            },
            success: function (response) {
                if (response.success) {
                    $("#message-error-success")
                        .text("Estoque adicionado com sucesso!")
                        .show();
                } else {
                    $("#message-error-success")
                        .text("Erro Desconhecido!")
                        .show();
                }
            },
            error: function (xhr, status, error) {
                var errorMessage = "";
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage += xhr.responseJSON.error;
                } else {
                    errorMessage += error;
                }
                $("#message-error-success").text(errorMessage).show();
            },
        });
    });

    $(".container").on("click", "#saveProduct", function () {
        document.getElementById("productForm").submit();
    });
});
