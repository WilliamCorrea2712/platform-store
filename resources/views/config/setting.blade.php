@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title">
            {{ __('Configurações') }}
        </h1>
        <div class="card shadow-sm">
            @if(session('errors'))
                <div class="alert alert-danger" role="alert">
                    @foreach(session('errors') as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if(!empty($settings))
            <div class="card-body">                
                <div id="message-info" class="alert alert-success" role="alert" style="display: none"></div>
                <button type="button" id="addSettingButton" class="btn btn-success mb-3">{{ __('Nova Configuração') }}</button>
                <div id="addSettingDiv" style="display: none;">
                        <form action="{{ route('addSetting') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="name">{{ __('Nome') }}</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="key">{{ __('Chave') }}</label>
                                    <input type="text" class="form-control" id="key" name="key" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="value">{{ __('Valor') }}</label>
                                    <input type="text" class="form-control" id="value" name="value" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="group_name">{{ __('Grupo') }}</label>
                                    <input type="text" class="form-control" id="group_name" name="group_name" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">{{ __('Adicionar') }}</button>
                        </form>
                    </div>                    
                     @foreach($settings as $group => $groupSettings)
                        <div class="accordion" id="accordion{{ Str::slug($group) }}">
                            <div class="card">
                                <div class="card-header custom-group-heading" id="heading{{ Str::slug($group) }}" data-toggle="collapse" data-target="#collapse{{ Str::slug($group) }}" aria-expanded="true" aria-controls="collapse{{ Str::slug($group) }}">
                                    <h3 class="mb-0">
                                        {{ ucfirst($group) }}
                                    </h3>
                                </div>
                                <div id="collapse{{ Str::slug($group) }}" class="collapse" aria-labelledby="heading{{ Str::slug($group) }}" data-parent="#accordion{{ Str::slug($group) }}">                                    
                                    <table class="table no-border-table">
                                        <tbody>
                                            @foreach($groupSettings as $setting)
                                                <tr>
                                                    <td class="align-middle width-35">{{ $setting['name'] }}<br /><b>{{ $setting['key'] ?? 'N/A' }}</b></td>
                                                    <td class="text-center align-middle">
                                                        <input type="text" class="form-control setting-value" value="{{ $setting['value'] ?? 'N/A' }}">
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <button type="button" class="btn btn-success btn-save-config d-none" data-setting-id="{{ $setting['id'] }}">
                                                            {{ __('Salvar') }}
                                                        </button>
                                                        <button type="button" class="btn btn-secondary btn-edit" data-setting-id="{{ $setting['id'] }}">
                                                            {{ __('Editar') }}
                                                        </button>
                                                        <form action="{{ route('deleteSetting', ['id' => $setting['id']]) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger ml-2" onclick="return confirm('Tem certeza que deseja excluir esta configuração?')">
                                                                {{ __('Excluir') }}
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>                                   
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card-body">
                    <p>{{ __('Nenhuma configuração encontrada.') }}</p>
                </div>
            @endif
        </div>
        <div class="modal fade" id="addSettingModal" tabindex="-1" role="dialog" aria-labelledby="addSettingModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSettingModalLabel">{{ __('Adicionar Configuração') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Fechar') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('addSetting') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{ __('Nome') }}</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="value">{{ __('Valor') }}</label>
                                <input type="text" class="form-control" id="value" name="value" required>
                            </div>
                            <div class="form-group">
                                <label for="group_name">{{ __('Grupo') }}</label>
                                <input type="text" class="form-control" id="group_name" name="group_name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Adicionar') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
