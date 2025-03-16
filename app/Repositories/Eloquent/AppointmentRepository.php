<?php

namespace App\Repositories\Eloquent;

use App\Models\Appointment;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    /**
     * @var Appointment
     */
    protected $model;

    /**
     * AppointmentRepository constructor.
     *
     * @param Appointment $model
     */
    public function __construct(Appointment $model)
    {
        $this->model = $model;
    }

    /**
     * Get all appointments with pagination.
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllWithPagination(array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        // Apply filters
        if (isset($filters['egn']) && !empty($filters['egn'])) {
            $query->byEgn($filters['egn']);
        }

        if (isset($filters['date_from'])) {
            $dateFrom = $filters['date_from'];
            $dateTo = $filters['date_to'] ?? null;
            $query->byDateRange($dateFrom, $dateTo);
        }

        // Order by appointment date
        $query->orderBy('appointment_datetime', 'asc');

        return $query->paginate(10);
    }

    /**
     * Get appointment by ID.
     *
     * @param int $id
     * @return Appointment|null
     */
    public function find(int $id): ?Appointment
    {
        return $this->model->find($id);
    }

    /**
     * Create new appointment.
     *
     * @param array $data
     * @return Appointment
     */
    public function create(array $data): Appointment
    {
        return $this->model->create($data);
    }

    /**
     * Update appointment.
     *
     * @param int $id
     * @param array $data
     * @return Appointment
     */
    public function update(int $id, array $data): Appointment
    {
        $appointment = $this->find($id);
        $appointment->update($data);
        return $appointment;
    }

    /**
     * Delete appointment.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->model->destroy($id) > 0;
    }

    /**
     * Get future appointments for a client by EGN.
     *
     * @param string $egn
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFutureAppointmentsByEgn(string $egn)
    {
        return $this->model
            ->byEgn($egn)
            ->future()
            ->orderBy('appointment_datetime')
            ->get();
    }
}
