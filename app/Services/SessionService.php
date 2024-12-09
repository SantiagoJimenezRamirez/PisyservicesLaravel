<?php

namespace App\Services;

use App\Models\Session;

class SessionService
{
    public function add($session)
    {
        try {
            $newSession = Session::create($session);
            return $newSession;
        } catch (\Exception $e) {
            \Log::error("Error creating session: " . $e->getMessage());
            throw new \Exception('Error creating session: ' . $e->getMessage());
        }
    }

    public function getAll()
    {
        try {
            return Session::orderBy('created_at', 'desc')->get();
        } catch (\Exception $e) {
            \Log::error("Error retrieving sessions: " . $e->getMessage());
            throw new \Exception('Error finding sessions');
        }
    }
}
