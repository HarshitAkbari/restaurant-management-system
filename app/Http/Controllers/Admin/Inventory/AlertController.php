<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Services\Inventory\RawMaterialService;
use Illuminate\View\View;

class AlertController extends Controller
{
    public function __construct(
        private readonly RawMaterialService $rawMaterialService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.admin.inventory.alerts.index', [
            'materials' => $this->rawMaterialService->lowStock(),
        ]);
    }
}
