$(document).ready(function () {
    $("#addAddress").click(function () {
        var addressHtml = `
            <div class="address border rounded p-3 mb-3">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="nameAddress">Nome <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nameAddress[]" value="" required>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="street">Rua <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="street[]" value="" required>
                    </div>  
                    <div class="form-group col-md-3">
                        <label for="number">Número <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="number[]" value="" required>
                    </div>                                          
                </div>
                <div class="form-row">                                            
                    <div class="form-group col-md-3">
                        <label for="city">Cidade <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="city[]" value="" required>
                    </div>   
                    <div class="form-group col-md-3">
                        <label for="state">Estado <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="state[]" value="" required>
                    </div>                                                                                                                             
                    <div class="form-group col-md-3">
                        <label for="zip_code">CEP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="zip_code[]" maxlength="9" value="" required>
                    </div>  
                    <div class="form-group col-md-3">
                        <label for="country">País <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="country[]" value="" required>
                    </div>                                          
                </div>
            </div>`;
        $(".addresses-section").append(addressHtml);
    });
});
