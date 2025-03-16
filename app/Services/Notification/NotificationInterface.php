<?php

namespace App\Services\Notification;

use App\Models\Appointment;

interface NotificationInterface
{
    /**
     * Send notification for appointment.
     *
     * @param Appointment $appointment
     * @return string Message indicating what would happen in a real implementation
     */
    public function send(Appointment $appointment): string;
}
