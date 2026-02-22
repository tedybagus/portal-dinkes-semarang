<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformationRequest;

class InformationTrackingController extends Controller
{
    public function index()
    {
        return view('information.tracking');
    }

    public function search(Request $request)
    {
        $request->validate([
            'registration_number' => 'required'
        ]);

        $data = InformationRequest::with('followups')
            ->where('registration_number', $request->registration_number)
            ->first();

        return view('information.tracking', compact('data'));
    }
}
