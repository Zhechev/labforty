@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Филтриране на часове</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('appointments.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="egn" class="form-label">ЕГН</label>
                                <input type="text" class="form-control" id="egn" name="egn" value="{{ $filters['egn'] ?? '' }}" maxlength="10" placeholder="Въведете ЕГН">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="date_from" class="form-label">От дата</label>
                                <input type="date" class="form-control" id="date_from" name="date_from" value="{{ $filters['date_from'] ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="date_to" class="form-label">До дата</label>
                                <input type="date" class="form-control" id="date_to" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-search"></i> Филтрирай
                                </button>
                                <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Изчисти
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Списък с часове</h4>
                    <a href="{{ route('appointments.create') }}" class="btn btn-light">
                        <i class="fas fa-plus"></i> Добави нов час
                    </a>
                </div>
                <div class="card-body">
                    @if($appointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Дата и час</th>
                                        <th>Клиент</th>
                                        <th>ЕГН</th>
                                        <th>Метод за уведомяване</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <td>{{ $appointment->id }}</td>
                                            <td>{{ $appointment->appointment_datetime->format('d.m.Y H:i') }}</td>
                                            <td>{{ $appointment->client_name }}</td>
                                            <td>{{ $appointment->egn }}</td>
                                            <td>
                                                @if($appointment->notification_method == 'email')
                                                    <span class="badge bg-info">Email</span>
                                                @else
                                                    <span class="badge bg-success">SMS</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('appointments.show', $appointment->id) }}" class="btn btn-sm btn-info" title="Преглед">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-sm btn-warning" title="Редактиране">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Сигурни ли сте, че искате да изтриете този час?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Изтриване">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $appointments->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            Няма намерени часове. <a href="{{ route('appointments.create') }}" class="alert-link">Добавете нов час</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
