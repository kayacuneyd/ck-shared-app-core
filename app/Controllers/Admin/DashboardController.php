<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

/**
 * DashboardController
 *
 * Simple controller for the administrative dashboard.
 * Requires authentication via the auth filter.
 */
class DashboardController extends BaseController
{
    /**
     * Display the admin dashboard.
     *
     * @return string
     */
    public function index(): string
    {
        return view('admin/dashboard');
    }
}
