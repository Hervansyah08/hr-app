<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // $tasks = Task::all();

        // return view('dashboard.index', compact('tasks'));
        return view('dashboard.index');
    }
}
