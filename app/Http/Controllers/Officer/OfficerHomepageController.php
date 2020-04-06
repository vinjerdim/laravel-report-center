<?php

namespace App\Http\Controllers\Officer;

use Brackets\AdminAuth\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Inspiring;
use Illuminate\View\View;

class OfficerHomepageController extends Controller
{
    /**
     * Display default admin home page
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('officer.homepage.index', [
            'inspiration' => Inspiring::quote()
        ]);
    }
}
