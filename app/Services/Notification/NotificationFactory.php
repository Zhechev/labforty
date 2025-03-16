<?php

namespace App\Services\Notification;

class NotificationFactory
{
    /**
     * Create notification service based on notification method.
     *
     * @param string $method
     * @return NotificationInterface
     * @throws \InvalidArgumentException
     */
    public static function create(string $method): NotificationInterface
    {
        return match ($method) {
            'email' => new EmailNotification(),
            'sms' => new SmsNotification(),
            default => throw new \InvalidArgumentException("Unsupported notification method: {$method}"),
        };
    }
}
