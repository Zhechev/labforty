<?php

namespace App\Services\Notification;

use App\Models\Appointment;

class EmailNotification implements NotificationInterface
{
    /**
     * Send email notification for appointment.
     *
     * @param Appointment $appointment
     * @return string
     */
    public function send(Appointment $appointment): string
    {
        // In a real implementation, we would send an actual email
        // For this task, we just return a message
        return "Email would be sent to {$appointment->email} for the appointment on " .
               $appointment->appointment_datetime->format('d.m.Y H:i');
    }
}
