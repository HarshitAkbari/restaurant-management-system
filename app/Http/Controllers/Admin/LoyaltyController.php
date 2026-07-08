<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Loyalty\LoyaltyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoyaltyController extends Controller
{
    public function __construct(
        private readonly LoyaltyService $loyaltyService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.admin.customers.loyalty', [
            'setting' => $this->loyaltyService->get(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'is_enabled' => ['sometimes', 'boolean'],
            'points_per_rupee' => ['required', 'numeric', 'min:0'],
            'rupee_per_point' => ['required', 'numeric', 'min:0'],
            'min_redeem_points' => ['required', 'integer', 'min:0'],
        ]);

        $this->loyaltyService->update($data);

        return back()->with('success', 'Loyalty settings updated successfully.');
    }
}
