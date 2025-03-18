<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activity = Activity::orderBy('created_at', 'desc')->take(10)->get();
        return view('activity', compact('activity'));
    }
}
