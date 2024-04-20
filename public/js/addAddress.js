$(document).ready(function () {
    $("#addAddress").click(function () {
        var addressHtml = `
          <div class="address border rounded p-3 mb-3">
              <div class="form-row">
                  <div class="form-group col-md-4">
                      <label for="nameAddress">Nome:</label>
                      <input type="text" class="form-control" name="nameAddress[]" value="" required>
                  </div>
                  <div class="form-group col-md-5">
                      <label for="street">Rua:</label>
                      <input type="text" class="form-control" name="street[]" value="" required>
                  </div>  
                  <div class="form-group col-md-3">
                      <label for="number">Número:</label>
                      <input type="text" class="form-control" name="number[]" value="" required>
                  </div>                                          
              </div>
              <div class="form-row">                                            
                  <div class="form-group col-md-3">
                      <label for="city">Cidade:</label>
                      <input type="text" class="form-control" name="city[]" value="" required>
                  </div>   
                  <div class="form-group col-md-3">
                      <label for="state">Estado:</label>
                      <input type="text" class="form-control" name="state[]" value="" required>
                  </div>                                                                                                                             
                  <div class="form-group col-md-3">
                      <label for="zip_code">CEP:</label>
                      <input type="text" class="form-control" name="zip_code[]" value="" required>
                  </div>  
                  <div class="form-group col-md-3">
                      <label for="country">País:</label>
                      <input type="text" class="form-control" name="country[]" value="" required>
                  </div>                                          
              </div>                                        
          </div>`;
        $(".addresses-section").append(addressHtml);
    });
});
