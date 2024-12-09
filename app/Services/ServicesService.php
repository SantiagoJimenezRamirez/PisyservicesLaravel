<?php

namespace App\Services;

use App\Models\ServiceRequest;

class ServicesService
{
    public function createServiceRequest($data)
    {
        try {
            $newRequest = ServiceRequest::create($data);
            return $newRequest;
        } catch (\Exception $e) {
            \Log::error("Error creating service request: " . $e->getMessage());
            throw new \Exception('Error creating service request: ' . $e->getMessage());
        }
    }

    public function getAllServiceRequests()
    {
        try {
            return ServiceRequest::orderBy('created_at', 'desc')->get();
        } catch (\Exception $e) {
            \Log::error("Error fetching service requests: " . $e->getMessage());
            throw new \Exception('Error fetching service requests: ' . $e->getMessage());
        }
    }

    public function deleteServiceRequest($id)
    {
        try {
            $result = ServiceRequest::destroy($id);
            if (!$result) {
                throw new \Exception('Service request not found');
            }
            return true;
        } catch (\Exception $e) {
            \Log::error("Error deleting service request: " . $e->getMessage());
            throw new \Exception('Error deleting service request: ' . $e->getMessage());
        }
    }
}
