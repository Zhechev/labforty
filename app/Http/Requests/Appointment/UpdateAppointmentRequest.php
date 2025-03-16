<?php

namespace App\Http\Requests\Appointment;

use App\Rules\ValidEgn;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'appointment_datetime' => ['required', 'date', 'after:now'],
            'client_name' => ['required', 'string', 'max:255'],
            'egn' => ['required', 'string', 'size:10', 'regex:/^[0-9]{10}$/', new ValidEgn],
            'description' => ['nullable', 'string'],
            'notification_method' => ['required', 'string', 'in:email,sms'],
            'email' => ['required_if:notification_method,email', 'nullable', 'email', 'max:255'],
            'phone' => ['required_if:notification_method,sms', 'nullable', 'string', 'max:20'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'appointment_datetime.required' => 'Датата и часът са задължителни.',
            'appointment_datetime.date' => 'Датата и часът трябва да са валидни.',
            'appointment_datetime.after' => 'Датата и часът трябва да са в бъдещето.',
            'client_name.required' => 'Имената на клиента са задължителни.',
            'egn.required' => 'ЕГН-то е задължително.',
            'egn.size' => 'ЕГН-то трябва да бъде точно 10 символа.',
            'egn.regex' => 'ЕГН-то трябва да съдържа само цифри.',
            'notification_method.required' => 'Методът за уведомяване е задължителен.',
            'notification_method.in' => 'Избраният метод за уведомяване е невалиден.',
            'email.required_if' => 'Email-ът е задължителен, когато е избран метод за уведомяване по email.',
            'email.email' => 'Email-ът трябва да бъде валиден.',
            'phone.required_if' => 'Телефонът е задължителен, когато е избран метод за уведомяване по SMS.',
        ];
    }
}
