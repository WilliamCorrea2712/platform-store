@if($addresses)
    <div class="my-account">
        <h2 class="meus-dados-title">{{ _('Meus Endereços') }}</h2>
        <div class="mb-3">
            <button type="button" class="btn btn-primary mt-3" id="addAddress">{{ __('Adicionar Endereço') }}</button>
        </div>
        <div class="addresses-section">
            <div class="form-row" id="saveAddressButtonRow" style="display: none;">
                <div class="form-group col-md-12">
                    <button type="button" id="saveAddressButton" class="btn btn-success btn-save-address">{{ _('Salvar Endereço') }}</button>
                </div>
            </div>            
            @foreach ($addresses as $address)
            <div class="my-address">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="nameAddress">{{ _('Responsável') }}</label>
                        <input type="text" class="form-control" id="nameAddress" value="{{ $address['nameAddress'] }}">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="address">{{ _('Endereço') }}</label>
                        <input type="text" class="form-control" id="address" value="{{ $address['street'] }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="number">{{ _('Número') }}</label>
                        <input type="text" class="form-control" id="number" value="{{ $address['number'] }}">
                    </div>                    
                    <div class="form-group col-md-5">
                        <label for="city">{{ _('Cidade') }}</label>
                        <input type="text" class="form-control" id="city" value="{{ $address['city'] }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="state">{{ _('Estado') }}</label>
                        <input type="text" class="form-control" id="state" value="{{ $address['state'] }}">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="zip_code">{{ _('CEP') }}</label>
                        <input type="text" class="form-control" id="zip_code" value="{{ $address['zip_code'] }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="country">{{ _('País') }}</label>
                        <input type="text" class="form-control border-bottom" id="country" value="{{ $address['country'] }}">
                    </div>
                    <div class="form-group col-md-1 text-right">
                        <label>&nbsp;</label>
                        <a href="{{ route('deleteAddress', ['address_id' => $address['id']]) }}" class="btn btn-danger btn-delete-address">{{ _('Deletar') }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>  
    </div>         
@else
    <div class="alert alert-info" role="alert">{{ _('Nenhum dado encontrado para este cliente!') }}</div>
@endif
