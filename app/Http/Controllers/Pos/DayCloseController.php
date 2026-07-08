<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pos\StoreDayCloseRequest;
use App\Services\Pos\DayCloseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class DayCloseController extends Controller
{
    public function __construct(
        private readonly DayCloseService $dayCloseService,
    ) {
    }

    public function index(Request $request): View
    {
        $date = $request->get('date', today()->toDateString());

        return view('restaurant.pos.day-close.index', [
            'preview' => $this->dayCloseService->preview($date),
            'date' => $date,
        ]);
    }

    public function store(StoreDayCloseRequest $request): RedirectResponse
    {
        try {
            $this->dayCloseService->close(
                $request->validated(),
                (int) $request->user()->id,
            );
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Day close completed successfully.');
    }
}
