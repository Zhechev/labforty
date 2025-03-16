<?php

namespace App\Repositories\Interfaces;

use App\Models\Appointment;
use Illuminate\Pagination\LengthAwarePaginator;

interface AppointmentRepositoryInterface
{
    /**
     * Get all appointments with pagination.
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllWithPagination(array $filters = []): LengthAwarePaginator;

    /**
     * Get appointment by ID.
     *
     * @param int $id
     * @return Appointment|null
     */
    public function find(int $id): ?Appointment;

    /**
     * Create new appointment.
     *
     * @param array $data
     * @return Appointment
     */
    public function create(array $data): Appointment;

    /**
     * Update appointment.
     *
     * @param int $id
     * @param array $data
     * @return Appointment
     */
    public function update(int $id, array $data): Appointment;

    /**
     * Delete appointment.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get future appointments for a client by EGN.
     *
     * @param string $egn
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFutureAppointmentsByEgn(string $egn);
}
