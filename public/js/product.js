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
                    location.reload();
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
});

document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("selectImagesBtn")
        .addEventListener("click", function () {
            const input = document.createElement("input");
            input.type = "file";
            input.accept = "image/*";
            input.multiple = true;
            input.click();

            const productId = $(this).data("product-id");
            var csrfToken = $('meta[name="csrf-token"]').attr("content");

            input.addEventListener("change", function () {
                const images = Array.from(input.files);
                const selectedImagesMsg =
                    document.getElementById("selectedImagesMsg");
                const imagePreview = document.getElementById("imagePreview");
                const previewContainer =
                    document.getElementById("previewContainer");

                let saveBtn = document.getElementById("saveBtn");

                if (!saveBtn) {
                    saveBtn = document.createElement("button");
                    saveBtn.id = "saveBtn";
                    saveBtn.classList.add("btn", "btn-success");
                    saveBtn.textContent = "Enviar Imagen(s)";
                    saveBtn.addEventListener("click", function () {
                        const formData = new FormData();
                        images.forEach((image, index) => {
                            formData.append(`images[]`, image);
                        });

                        formData.append("product_id", productId);
                        formData.append("_token", csrfToken);

                        fetch(`/product/addProductImages`, {
                            method: "POST",
                            body: formData,
                        })
                            .then((response) => {
                                if (response.ok) {
                                    $("#message-api")
                                        .text("Imagens enviadas com sucesso!")
                                        .show();
                                    location.reload();
                                } else {
                                    console.error(
                                        "Erro ao enviar imagens:",
                                        response.statusText
                                    );
                                    response.text().then((text) => {
                                        $("#message-api")
                                            .text(
                                                text.length > 50
                                                    ? text.slice(0, 130) + "..."
                                                    : text
                                            )
                                            .show();
                                        console.log("Corpo da resposta:", text);
                                    });
                                }
                            })
                            .catch((error) => {
                                console.error("Erro ao enviar imagens:", error);
                            });
                    });

                    selectedImagesMsg.appendChild(saveBtn);
                }

                selectedImagesMsg.style.display = "block";
                imagePreview.style.display = "block";
                previewContainer.innerHTML = "";
                images.forEach((image) => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = document.createElement("img");
                        img.src = e.target.result;
                        img.classList.add("img-thumbnail", "mr-2", "mb-2");
                        img.style.width = "200px";
                        img.style.marginLeft = "17px";
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(image);
                });
            });
        });
});

$(document).ready(function () {
    $("#btnOpenCreatePopup").click(function () {
        $("#createProductModal").modal("show");
    });

    var formSubmitting = false;

    $("#submitButton").click(function (event) {
        if (formSubmitting) {
            event.preventDefault();
            return;
        }

        formSubmitting = true;

        event.preventDefault();

        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        var formData = {
            name: $("#productName").val(),
            description: $("#productDescription").val(),
            price: $("#productPrice").val(),
            weight: $("#productWeight").val(),
            _token: csrfToken,
        };

        $.ajax({
            type: "POST",
            url: "/product/products/store",
            data: formData,
            dataType: "json",
            encode: true,
            success: function (data) {
                window.location.href = "/editProduct/" + data.product_id;
            },
            error: function (xhr, status, error) {
                var errorMessage =
                    xhr.responseJSON && xhr.responseJSON.error
                        ? xhr.responseJSON.error
                        : error;
                $("#message-return").text(errorMessage).show();
            },
            complete: function () {
                formSubmitting = false;
            },
        });
    });
});
