<?php

namespace App\Http\Controllers;

use App\Models\TestingSession;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    
    public function show(TestingSession $session) {

        if ($session->hasEnded()) return redirect()->route('testing.result', $session->id);

        return view('testing.show', [
            'session' => $session,
        ]);
    }

    public function result(TestingSession $session) {

        if (!$session->hasEnded()) {
            return redirect()->route('testing.show', $session->id);
        }

        return view('testing.result', [
            'session'=> $session,
        ]);
    }

    public function complete(TestingSession $session) {
        if ($session->hasEnded()) return response(null, 400);

        $session->ends_at = now();
        $session->save();

        return redirect()->route('testing.result', $session->id);
    }

}
