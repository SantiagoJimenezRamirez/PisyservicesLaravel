<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Services\ServicesService;
use Illuminate\Http\Request;


class ServiceRequestController extends Controller
{
    protected $serviceRequestService;

    public function __construct(ServicesService $serviceRequestService)
    {
        $this->serviceRequestService = $serviceRequestService;
    }

    public function store(Request $request)
    {
        $name = $request->input('form.name');
        $email = $request->input('form.email');
        $message = $request->input('form.message');

        try {
            $newRequest = $this->serviceRequestService->createServiceRequest(['name' => $name, 'email' => $email, 'message' => $message]);

            return response()->json($newRequest, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
        try {
            $requests = $this->serviceRequestService->getAllServiceRequests();
            return response()->json($requests);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $this->serviceRequestService->deleteServiceRequest($id);
            return response()->json(['message' => 'Service request deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
