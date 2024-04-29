@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title">
            {{ __('Configurações') }}
        </h1>
        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addSettingModal">{{ __('Adicionar') }}</button>
        <div class="card shadow-sm">
            @if(!empty($settings))
                @foreach($settings->groupBy('group_name') as $group => $groupSettings)
                    <div class="card-body">
                        <h3>{{ $group }}</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Nome') }}</th>
                                    <th class="text-center">{{ __('Valor') }}</th>
                                    <th class="text-center">{{ __('Ações') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groupSettings as $setting)
                                    <tr>
                                        <td>{{ $setting['name'] }}</td>
                                        <td class="text-center">{{ $setting['value'] ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editSettingModal{{ $setting['id'] }}">
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
                                    <div class="modal fade" id="editSettingModal{{ $setting['id'] }}" tabindex="-1" role="dialog" aria-labelledby="editSettingModalLabel{{ $setting['id'] }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editSettingModalLabel{{ $setting['id'] }}">{{ __('Editar Configuração') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Fechar') }}">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('updateSetting', ['id' => $setting['id']]) }}" method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="value">{{ __('Novo Valor') }}</label>
                                                            <input type="text" class="form-control" id="value" name="value" value="{{ $setting['value'] ?? '' }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">{{ __('Salvar') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
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
