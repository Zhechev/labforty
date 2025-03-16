@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Добавяне на нов час</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('appointments.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="appointment_datetime" class="form-label">Дата и час <span class="text-danger">*</span></label>
                                <input type="text" class="form-control datetime-picker @error('appointment_datetime') is-invalid @enderror"
                                    id="appointment_datetime" name="appointment_datetime" value="{{ old('appointment_datetime') }}"
                                    placeholder="Изберете дата и час" required>
                                @error('appointment_datetime')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="client_name" class="form-label">Имена на клиента <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('client_name') is-invalid @enderror"
                                    id="client_name" name="client_name" value="{{ old('client_name') }}"
                                    placeholder="Въведете имена на клиента" required>
                                @error('client_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="egn" class="form-label">ЕГН <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('egn') is-invalid @enderror"
                                    id="egn" name="egn" value="{{ old('egn') }}"
                                    placeholder="Въведете ЕГН" maxlength="10" required>
                                @error('egn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="notification_method" class="form-label">Метод за уведомяване <span class="text-danger">*</span></label>
                                <select class="form-select @error('notification_method') is-invalid @enderror"
                                    id="notification_method" name="notification_method" required>
                                    <option value="">Изберете метод</option>
                                    <option value="email" {{ old('notification_method') == 'email' ? 'selected' : '' }}>Email</option>
                                    <option value="sms" {{ old('notification_method') == 'sms' ? 'selected' : '' }}>SMS</option>
                                </select>
                                @error('notification_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6" id="email-field" style="{{ old('notification_method') == 'sms' ? 'display: none;' : '' }}">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}"
                                    placeholder="Въведете email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6" id="phone-field" style="{{ old('notification_method') != 'sms' ? 'display: none;' : '' }}">
                                <label for="phone" class="form-label">Телефон <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone') }}"
                                    placeholder="Въведете телефон">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Описание</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" rows="3"
                                placeholder="Въведете описание (по желание)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Назад
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Запази
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
