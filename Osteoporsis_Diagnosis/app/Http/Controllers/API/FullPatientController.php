<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequests\storePatientRequest;
use App\Http\Requests\PatientRequests\updatePatientRequest;
use App\Services\FullPatientService;
use App\Traits\ApiResponse;

class FullPatientController extends Controller
{
    use ApiResponse;

    protected $service;

    public function __construct(FullPatientService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $patients = $this->service->getAll();
        return $this->successResponse($patients, 'Patients retrieved successfully.');
    }

    public function show($id)
    {
        try {
            $patient = $this->service->getById($id);
            return $this->successResponse($patient, 'Patient retrieved successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function store(storePatientRequest $request)
    {
        try {
            $patient = $this->service->create($request->validated());
            return $this->successResponse($patient, 'Patient created successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update(updatePatientRequest $request, $id)
    {
        try {
            $patient = $this->service->update($id, $request->validated());
            return $this->successResponse($patient, 'Patient updated successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }
}

