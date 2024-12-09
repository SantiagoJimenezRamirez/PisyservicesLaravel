<?php

namespace App\Http\Controllers;

use App\Services\RequestService;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    protected $requestService;

    public function __construct(RequestService $requestService)
    {
        $this->requestService = $requestService;
    }

    public function index()
    {
        return response()->json($this->requestService->getAll());
    }

    public function store(Request $request)
    {
        // Extraer los datos del objeto 'form'
        $validatedData = $request->validate([
            'form.title' => 'required|string|max:255',
            'form.description' => 'required|string',
        ]);
    
        // Crear el registro utilizando los datos validados
        $requestData = $validatedData['form'];
        $newRequest = $this->requestService->create($requestData);
    
        return response()->json($newRequest, 201);
    }
    

    public function show($id)
    {
        return response()->json($this->requestService->getById($id));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        return response()->json($this->requestService->update($id, $validatedData));
    }

    public function destroy($id)
    {
        return response()->json($this->requestService->delete($id));
    }
}
