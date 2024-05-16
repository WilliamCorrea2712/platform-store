@if($data)
    @foreach ($data as $customer)
        <div class="my-account">
            <h2 class="meus-dados-title">{{ _('Dados') }}</h2>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="name">{{ _('Nome') }}</label>
                    <input type="text" class="form-control" id="name" value="{{ $customer['name'] }}">
                </div>
                <div class="form-group col-md-5">
                    <label for="email">{{ _('E-mail') }}</label>
                    <input type="email" class="form-control" id="email" value="{{ $customer['email'] }}" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="phone_number">{{ _('Contato') }}</label>
                    <input type="tel" class="form-control" id="phone_number" value="{{ $customer['phone_number'] }}">
                </div>
                <div class="form-group col-md-5">
                    <label for="birth_date">{{ _('Dt Nasci.') }}</label>
                    <input type="date" class="form-control" id="birth_date" value="{{ $customer['birth_date'] }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="cnpj_cpf">{{ _('CPF/CNPJ') }}</label>
                    <input type="text" class="form-control" id="cnpj_cpf" value="{{ $customer['cnpj_cpf'] }}" readonly>
                </div>
                <div class="form-group col-md-5">
                    <label for="rg_ie">{{ _('RG/IE') }}</label>
                    <input type="text" class="form-control" id="rg_ie" value="{{ $customer['rg_ie'] }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="type_person">{{ _('Pessoa') }}</label>
                    <select class="form-control" id="type_person" name="type_person" required>
                        <option value="fisica" {{ $customer['type_person'] == 'fisica' ? 'selected' : '' }}>{{ __('Física') }}</option>
                        <option value="juridica" {{ $customer['type_person'] == 'juridica' ? 'selected' : '' }}>{{ __('Jurídica') }}</option>
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label for="sex">{{ _('Sexo') }}</label>
                    <select class="form-control" id="sex" name="sex" required>
                        <option value="M" {{ $customer['sex'] == 'M' ? 'selected' : '' }}>{{ __('Masculino') }}</option>
                        <option value="F" {{ $customer['sex'] == 'F' ? 'selected' : '' }}>{{ __('Feminino') }}</option>
                    </select>
                </div>
            </div>
            <button type="button" id="editCustomer" class="btn btn-success btn-edit-customer" data-customer-id="{{ $customer['id'] }}">{{ _('Salvar Dados') }}</button>

            <h2 class="meus-dados-title">{{ _('Endereços') }}</h2>
            @foreach ($customer['addresses'] as $address)
            <div class="my-address shadow-sm">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="nameAddress">{{ _('Responsável') }}</label>
                        <input type="text" class="form-control" id="nameAddress" value="{{ $address['nameAddress'] }}" readonly>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="address">{{ _('Endereço') }}</label>
                        <input type="text" class="form-control" id="address" value="{{ $address['street'] }}, {{ $address['number'] }}" readonly>
                    </div>
                </div>
                <div class="form-row">                    
                    <div class="form-group col-md-5">
                        <label for="city">{{ _('Cidade') }}</label>
                        <input type="text" class="form-control" id="city" value="{{ $address['city'] }}" readonly>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="state">{{ _('Estado') }}</label>
                        <input type="text" class="form-control" id="state" value="{{ $address['state'] }}" readonly>
                    </div>
                </div>
                <div class="form-row">                    
                    <div class="form-group col-md-5">
                        <label for="zip_code">{{ _('CEP') }}</label>
                        <input type="text" class="form-control" id="zip_code" value="{{ $address['zip_code'] }}" readonly>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="country">{{ _('País') }}</label>
                        <input type="text" class="form-control border-bottom" id="country" value="{{ $address['country'] }}" readonly>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endforeach            
@else
    <div class="alert alert-info" role="alert">{{ _('Nenhum dado encontrado para este cliente!') }}</div>
@endif
