<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class ApplicationController extends Controller
{
    public function index()
    {
        //$exitCode = Artisan::call('cache:clear');
        return view('application');
    }
}
