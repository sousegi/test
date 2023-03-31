<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Admin
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('admin.dashboard.index');
    }

    /**
     * @return RedirectResponse
     */
    public function cache(): RedirectResponse
    {
        Cache::flush();
        return redirect()->back()->with('success', 'Cache cleared successfully');
    }

    /**
     * @return RedirectResponse
     */
    public function maintenance(): RedirectResponse
    {
        if (app()->isDownForMaintenance()) {
            Artisan::call('up');
            return redirect()->back()->with('success', 'Website is no more in maintenance mode!');
        }

        Artisan::call('down');
        return redirect()->back()->with('success', 'Website is in maintenance mode!');
    }
}
