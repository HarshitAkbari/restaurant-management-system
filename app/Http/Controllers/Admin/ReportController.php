<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Report\ReportService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(
        private readonly ReportService $reportService,
    ) {
    }

    public function sales(Request $request): View
    {
        [$from, $to] = $this->dateRange($request);
        $report = $this->reportService->sales($from, $to);

        return view('restaurant.admin.reports.sales', [
            'from' => $from,
            'to' => $to,
            'orders' => $report['orders'],
            'totals' => $report['totals'],
        ]);
    }

    public function items(Request $request): View
    {
        [$from, $to] = $this->dateRange($request);

        return view('restaurant.admin.reports.items', [
            'from' => $from,
            'to' => $to,
            'items' => $this->reportService->itemWise($from, $to),
        ]);
    }

    public function tax(Request $request): View
    {
        [$from, $to] = $this->dateRange($request);
        $report = $this->reportService->tax($from, $to);

        return view('restaurant.admin.reports.tax', [
            'from' => $from,
            'to' => $to,
            'orders' => $report['orders'],
            'totals' => $report['totals'],
        ]);
    }

    public function staff(Request $request): View
    {
        [$from, $to] = $this->dateRange($request);

        return view('restaurant.admin.reports.staff', [
            'from' => $from,
            'to' => $to,
            'rows' => $this->reportService->staff($from, $to),
        ]);
    }

    public function inventory(): View
    {
        return view('restaurant.admin.reports.inventory', [
            'materials' => $this->reportService->inventory(),
        ]);
    }

    /** @return array{0: string, 1: string} */
    private function dateRange(Request $request): array
    {
        $from = $request->get('from', now()->startOfMonth()->toDateString());
        $to = $request->get('to', now()->toDateString());

        return [$from, $to];
    }
}
