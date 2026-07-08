<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Order\OrderService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.admin.dashboard', [
            'stats' => $this->orderService->dashboardStats(),
        ]);
    }
}
