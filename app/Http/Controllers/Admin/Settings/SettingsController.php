<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\UpdatePaymentsRequest;
use App\Http\Requests\Admin\Settings\UpdatePrintersRequest;
use App\Http\Requests\Admin\Settings\UpdateProfileRequest;
use App\Http\Requests\Admin\Settings\UpdateTaxRequest;
use App\Services\Settings\RestaurantSettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function __construct(
        private readonly RestaurantSettingService $settingService,
    ) {
    }

    public function profile(): View
    {
        return view('restaurant.admin.settings.profile', [
            'setting' => $this->settingService->getProfile(),
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request): RedirectResponse
    {
        $this->settingService->updateProfile($request->validated());

        return back()->with('success', 'Profile updated successfully.');
    }

    public function tax(): View
    {
        return view('restaurant.admin.settings.tax', [
            'setting' => $this->settingService->getTax(),
        ]);
    }

    public function updateTax(UpdateTaxRequest $request): RedirectResponse
    {
        $this->settingService->updateTax($request->validated());

        return back()->with('success', 'Tax settings updated successfully.');
    }

    public function payments(): View
    {
        return view('restaurant.admin.settings.payments', [
            'setting' => $this->settingService->getPayments(),
        ]);
    }

    public function updatePayments(UpdatePaymentsRequest $request): RedirectResponse
    {
        $this->settingService->updatePayments($request->validated());

        return back()->with('success', 'Payment methods updated successfully.');
    }

    public function printers(): View
    {
        return view('restaurant.admin.settings.printers', [
            'setting' => $this->settingService->getPrinters(),
        ]);
    }

    public function updatePrinters(UpdatePrintersRequest $request): RedirectResponse
    {
        $names = $request->input('printer_names', []);
        $ips = $request->input('printer_ips', []);
        $printers = [];

        foreach ($names as $index => $name) {
            if (empty($name)) {
                continue;
            }

            $printers[] = [
                'name' => $name,
                'ip' => $ips[$index] ?? '',
            ];
        }

        $this->settingService->updatePrinters(['printers' => $printers]);

        return back()->with('success', 'Printers updated successfully.');
    }
}
