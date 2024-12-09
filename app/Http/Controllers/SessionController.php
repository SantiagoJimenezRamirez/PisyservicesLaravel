<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SessionService;

class SessionController extends Controller
{
    protected $sessionService;

    public function __construct(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    // Crear una nueva sesión
    public function add(Request $request)
    {
        $validated = $request->validate([
            'userAgent' => 'required|string',
            'browser' => 'required|string',
            'device' => 'required|string',
            'os' => 'required|string',
        ]);

        try {
            $session = $this->sessionService->add($validated);

            if (!$session) {
                return response()->json([
                    'msg' => 'Invalid Session',
                ], 400);
            }

            return response()->json([
                'message' => 'Session created successfully!',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the session.',
            ], 500);
        }
    }

    // Obtener todas las sesiones
    public function getAll()
    {
        try {
            $sessions = $this->sessionService->getAll();

            return response()->json([
                'ok' => true,
                'sessions' => $sessions,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving sessions.',
            ], 500);
        }
    }
}
