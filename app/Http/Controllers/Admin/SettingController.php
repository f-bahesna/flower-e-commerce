<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
       return view('ADMIN.Settings.Settings'); 
    }

    public function settingCarousel()
    {
        return view('ADMIN.Settings.carousel');
    }
}
