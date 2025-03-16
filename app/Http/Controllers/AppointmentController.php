<?php

namespace App\Http\Controllers;

use App\Http\Requests\Appointment\StoreAppointmentRequest;
use App\Http\Requests\Appointment\UpdateAppointmentRequest;
use App\Services\AppointmentService;
use Illuminate\Http\Request;

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
     * Display a listing of appointments.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filters = $request->only(['egn', 'date_from', 'date_to']);
        $appointments = $this->appointmentService->getAllWithPagination($filters);

        return view('appointments.index', compact('appointments', 'filters'));
    }

    /**
     * Show the form for creating a new appointment.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('appointments.create');
    }

    /**
     * Store a newly created appointment in storage.
     *
     * @param StoreAppointmentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAppointmentRequest $request)
    {
        $result = $this->appointmentService->create($request->validated());

        return redirect()
            ->route('appointments.index')
            ->with('success', "Успешно запазихте час! Клиентът ще бъде уведомен чрез " .
                   strtoupper($result['appointment']->notification_method) . ".");
    }

    /**
     * Display the specified appointment.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $appointment = $this->appointmentService->find($id);

        if (!$appointment) {
            return redirect()->route('appointments.index')
                ->with('error', 'Часът не е намерен.');
        }

        $futureAppointments = $this->appointmentService->getFutureAppointmentsByEgn($appointment->egn);

        return view('appointments.show', compact('appointment', 'futureAppointments'));
    }

    /**
     * Show the form for editing the specified appointment.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $appointment = $this->appointmentService->find($id);

        if (!$appointment) {
            return redirect()->route('appointments.index')
                ->with('error', 'Часът не е намерен.');
        }

        return view('appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified appointment in storage.
     *
     * @param UpdateAppointmentRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAppointmentRequest $request, $id)
    {
        $appointment = $this->appointmentService->find($id);

        if (!$appointment) {
            return redirect()->route('appointments.index')
                ->with('error', 'Часът не е намерен.');
        }

        $this->appointmentService->update($id, $request->validated());

        return redirect()
            ->route('appointments.show', $id)
            ->with('success', 'Часът е успешно обновен.');
    }

    /**
     * Remove the specified appointment from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $deleted = $this->appointmentService->delete($id);

        if ($deleted) {
            return redirect()
                ->route('appointments.index')
                ->with('success', 'Часът е успешно изтрит.');
        }

        return redirect()
            ->route('appointments.index')
            ->with('error', 'Възникна проблем при изтриване на часа.');
    }
}
