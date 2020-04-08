<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Inspiring;
use Illuminate\View\View;

class CitizenHomepageController extends Controller
{
    /**
     * Display default admin home page
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('citizen.homepage.index', [
            'inspiration' => Inspiring::quote()
        ]);
    }
}
