<?php

namespace App\Services\Notification;

use App\Models\Appointment;

class SmsNotification implements NotificationInterface
{
    /**
     * Send SMS notification for appointment.
     *
     * @param Appointment $appointment
     * @return string
     */
    public function send(Appointment $appointment): string
    {
        // In a real implementation, we would send an actual SMS
        // For this task, we just return a message
        return "SMS would be sent to {$appointment->phone} for the appointment on " .
               $appointment->appointment_datetime->format('d.m.Y H:i');
    }
}
