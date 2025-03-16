@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Детайли за час</h4>
                    <div>
                        <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit"></i> Редактирай
                        </a>
                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Сигурни ли сте, че искате да изтриете този час?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Изтрий
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2 mb-3">Информация за часа</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Дата и час:</dt>
                                <dd class="col-sm-8">{{ $appointment->appointment_datetime->format('d.m.Y H:i') }}</dd>

                                <dt class="col-sm-4">Създаден на:</dt>
                                <dd class="col-sm-8">{{ $appointment->created_at->format('d.m.Y H:i') }}</dd>

                                <dt class="col-sm-4">Последна промяна:</dt>
                                <dd class="col-sm-8">{{ $appointment->updated_at->format('d.m.Y H:i') }}</dd>

                                <dt class="col-sm-4">Описание:</dt>
                                <dd class="col-sm-8">{{ $appointment->description ?: 'Няма описание' }}</dd>
                            </dl>
                        </div>

                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2 mb-3">Информация за клиента</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Имена:</dt>
                                <dd class="col-sm-8">{{ $appointment->client_name }}</dd>

                                <dt class="col-sm-4">ЕГН:</dt>
                                <dd class="col-sm-8">{{ $appointment->egn }}</dd>

                                <dt class="col-sm-4">Метод за уведомяване:</dt>
                                <dd class="col-sm-8">
                                    @if($appointment->notification_method == 'email')
                                        <span class="badge bg-info">Email</span>
                                    @else
                                        <span class="badge bg-success">SMS</span>
                                    @endif
                                </dd>

                                <dt class="col-sm-4">Контакт:</dt>
                                <dd class="col-sm-8">
                                    @if($appointment->notification_method == 'email')
                                        <i class="fas fa-envelope"></i> {{ $appointment->email }}
                                    @else
                                        <i class="fas fa-phone"></i> {{ $appointment->phone }}
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Други предстоящи часове за този клиент</h4>
                </div>
                <div class="card-body">
                    @if($futureAppointments->count() > 1)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Дата и час</th>
                                        <th>Описание</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($futureAppointments as $futureAppointment)
                                        @if($futureAppointment->id != $appointment->id)
                                            <tr>
                                                <td>{{ $futureAppointment->id }}</td>
                                                <td>{{ $futureAppointment->appointment_datetime->format('d.m.Y H:i') }}</td>
                                                <td>{{ Str::limit($futureAppointment->description, 50) ?: 'Няма описание' }}</td>
                                                <td>
                                                    <a href="{{ route('appointments.show', $futureAppointment->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> Преглед
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Няма други предстоящи часове за този клиент.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Назад към списъка
        </a>
    </div>
</div>
@endsection
