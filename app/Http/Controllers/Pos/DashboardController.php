<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Services\Order\OrderService;
use App\Services\Table\TableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
        private readonly TableService $tableService,
    ) {
    }

    public function index(): View
    {
        $layout = $this->tableService->layoutWithActiveOrders();

        return view('restaurant.pos.dashboard', [
            'areas' => $layout['areas'],
            'ordersByTable' => $layout['ordersByTable'],
        ]);
    }
}
