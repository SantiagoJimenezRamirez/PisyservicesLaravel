<?php

namespace App\Services;

use App\Models\Request as RequestModel;

class RequestService
{
    public function getAll()
    {
        return RequestModel::all();
    }

    public function create($data)
    {
        return RequestModel::create($data);
    }

    public function getById($id)
    {
        return RequestModel::findOrFail($id);
    }

    public function update($id, $data)
    {
        $requestModel = RequestModel::findOrFail($id);
        $requestModel->update($data);
        return $requestModel;
    }

    public function delete($id)
    {
        $requestModel = RequestModel::findOrFail($id);
        $requestModel->delete();
        return ['message' => 'Request deleted successfully'];
    }
}
