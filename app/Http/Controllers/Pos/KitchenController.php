<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pos\UpdateKotStatusRequest;
use App\Services\Kot\KotService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KitchenController extends Controller
{
    public function __construct(
        private readonly KotService $kotService,
    ) {
    }

    public function index(Request $request): View
    {
        return view('restaurant.pos.kitchen.index', [
            'kots' => $this->kotService->pending($request->get('station')),
            'station' => $request->get('station'),
        ]);
    }

    public function updateStatus(UpdateKotStatusRequest $request, int $kot): RedirectResponse
    {
        $this->kotService->updateStatus($kot, $request->validated('status'));

        return back()->with('success', 'KOT status updated.');
    }
}
