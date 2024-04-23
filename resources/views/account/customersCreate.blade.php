@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-6 title">{{ __('Cadastrar') }}</h1>
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('storeCustomer') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">{{ __('Nome:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">{{ __('Email:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="phone_number">{{ __('Número de Telefone:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" required pattern="\([0-9]{2}\) [0-9]{5}-[0-9]{4}" title="O telefone deve estar no formato (XX) XXXXX-XXXX">
                                </div>                                                     
                                <div class="form-group col-md-6">
                                    <label for="rg_ie">{{ __('RG/IE:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                    <input type="text" class="form-control" id="rg_ie" name="rg_ie" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="birth_date">{{ __('Data de Nascimento:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                    <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cnpj_cpf">{{ __('CNPJ/CPF:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                    <input type="text" class="form-control" id="cnpj_cpf" name="cnpj_cpf" required pattern="[0-9]+" title="Apenas números são permitidos">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="type_person">{{ __('Tipo de Pessoa:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                    <select class="form-control" id="type_person" name="type_person" required>
                                        <option value="1">{{ __('Pessoa Física') }}</option>
                                        <option value="2">{{ __('Pessoa Jurídica') }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="sex">{{ __('Sexo:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                    <select class="form-control" id="sex" name="sex" required>
                                        <option value="M">{{ __('Masculino') }}</option>
                                        <option value="F">{{ __('Feminino') }}</option>
                                        <option value="O">{{ __('Outro') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password">{{ __('Senha:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="confirmPassword">{{ __('Confirme a Senha:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Cadastrar') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#phone_number').inputmask('(99) 99999-9999', { placeholder: ' ' });

            $('#cnpj_cpf').inputmask({
                mask: ['999.999.999-99', '99.999.999/9999-99'],
                keepStatic: true,
                placeholder: ' '
            });
        });
    </script>
@endpush
