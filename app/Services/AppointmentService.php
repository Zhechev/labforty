<?php

namespace App\Services;

use App\Models\Appointment;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Services\Notification\NotificationFactory;
use Illuminate\Pagination\LengthAwarePaginator;

class AppointmentService
{
    /**
     * @var AppointmentRepositoryInterface
     */
    protected $repository;

    /**
     * AppointmentService constructor.
     *
     * @param AppointmentRepositoryInterface $repository
     */
    public function __construct(AppointmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all appointments with pagination and filtering.
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllWithPagination(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->getAllWithPagination($filters);
    }

    /**
     * Get appointment by ID.
     *
     * @param int $id
     * @return Appointment|null
     */
    public function find(int $id): ?Appointment
    {
        return $this->repository->find($id);
    }

    /**
     * Create a new appointment and send notification.
     *
     * @param array $data
     * @return array With appointment and notification message
     */
    public function create(array $data): array
    {
        $appointment = $this->repository->create($data);

        // Send notification
        $notificationService = NotificationFactory::create($appointment->notification_method);
        $notificationMessage = $notificationService->send($appointment);

        return [
            'appointment' => $appointment,
            'notification_message' => $notificationMessage
        ];
    }

    /**
     * Update an appointment.
     *
     * @param int $id
     * @param array $data
     * @return Appointment
     */
    public function update(int $id, array $data): Appointment
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete an appointment.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * Get future appointments for a client by EGN.
     *
     * @param string $egn
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFutureAppointmentsByEgn(string $egn)
    {
        return $this->repository->getFutureAppointmentsByEgn($egn);
    }
}
