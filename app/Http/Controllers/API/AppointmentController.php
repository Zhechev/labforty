<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\StoreAppointmentRequest;
use App\Http\Requests\Appointment\UpdateAppointmentRequest;
use App\Services\AppointmentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AppointmentController extends Controller
{
    /**
     * @var AppointmentService
     */
    protected $appointmentService;

    /**
     * AppointmentController constructor.
     *
     * @param AppointmentService $appointmentService
     */
    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['egn', 'date_from', 'date_to']);
        $appointments = $this->appointmentService->getAllWithPagination($filters);

        return response()->json([
            'status' => 'success',
            'data' => $appointments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAppointmentRequest $request
     * @return JsonResponse
     */
    public function store(StoreAppointmentRequest $request): JsonResponse
    {
        $result = $this->appointmentService->create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => "Успешно запазихте час! Клиентът ще бъде уведомен чрез " .
                         strtoupper($result['appointment']->notification_method) . ".",
            'data' => $result['appointment'],
            'notification' => $result['notification_message']
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $appointment = $this->appointmentService->find($id);

        if (!$appointment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Часът не е намерен.'
            ], 404);
        }

        $futureAppointments = $this->appointmentService->getFutureAppointmentsByEgn($appointment->egn);

        return response()->json([
            'status' => 'success',
            'data' => $appointment,
            'future_appointments' => $futureAppointments
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAppointmentRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UpdateAppointmentRequest $request, string $id): JsonResponse
    {
        $appointment = $this->appointmentService->find($id);

        if (!$appointment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Часът не е намерен.'
            ], 404);
        }

        $updatedAppointment = $this->appointmentService->update($id, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Часът е успешно обновен.',
            'data' => $updatedAppointment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $appointment = $this->appointmentService->find($id);

        if (!$appointment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Часът не е намерен.'
            ], 404);
        }

        $deleted = $this->appointmentService->delete($id);

        if ($deleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Часът е успешно изтрит.'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Възникна проблем при изтриване на часа.'
        ], 500);
    }
}
