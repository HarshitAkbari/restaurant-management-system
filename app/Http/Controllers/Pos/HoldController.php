<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Services\Order\OrderService;
use Illuminate\View\View;

class HoldController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.pos.hold.index', [
            'orders' => $this->orderService->heldOrders(),
        ]);
    }
}
