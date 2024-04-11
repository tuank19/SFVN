<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function index(): View {
        return view('pages.dashboard.index');
    }
}
