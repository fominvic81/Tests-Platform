<?php

namespace App\Http\Controllers;

use App\Models\TestingSession;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    
    public function show(TestingSession $session) {
        return view('testing.show', [
            'session' => $session,
        ]);
    }

}
