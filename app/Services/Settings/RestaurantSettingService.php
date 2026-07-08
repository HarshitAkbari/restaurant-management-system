<?php

declare(strict_types=1);

namespace App\Services\Settings;

use App\Models\RestaurantSetting;
use App\Repositories\Contracts\RestaurantSettingRepositoryInterface;
use App\Enums\PaymentMethod;

class RestaurantSettingService
{
    public function __construct(
        private readonly RestaurantSettingRepositoryInterface $settingRepository,
    ) {
    }

    public function getProfile(): RestaurantSetting
    {
        return $this->settingRepository->firstOrCreateDefault();
    }

    public function updateProfile(array $data): RestaurantSetting
    {
        $setting = $this->settingRepository->firstOrCreateDefault();

        return $this->settingRepository->update($setting->id, [
            'name' => $data['name'],
            'legal_name' => $data['legal_name'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'gstin' => $data['gstin'] ?? null,
            'currency' => $data['currency'] ?? 'INR',
            'timezone' => $data['timezone'] ?? 'Asia/Kolkata',
        ]);
    }

    public function getTax(): RestaurantSetting
    {
        return $this->settingRepository->firstOrCreateDefault();
    }

    public function updateTax(array $data): RestaurantSetting
    {
        $setting = $this->settingRepository->firstOrCreateDefault();

        return $this->settingRepository->update($setting->id, [
            'cgst_percent' => (float) ($data['cgst_percent'] ?? 0),
            'sgst_percent' => (float) ($data['sgst_percent'] ?? 0),
            'service_charge_percent' => (float) ($data['service_charge_percent'] ?? 0),
        ]);
    }

    public function getPayments(): RestaurantSetting
    {
        return $this->settingRepository->firstOrCreateDefault();
    }

    public function updatePayments(array $data): RestaurantSetting
    {
        $setting = $this->settingRepository->firstOrCreateDefault();

        return $this->settingRepository->update($setting->id, [
            'payment_methods' => $data['payment_methods'] ?? [],
        ]);
    }

    public function getPrinters(): RestaurantSetting
    {
        return $this->settingRepository->firstOrCreateDefault();
    }

    public function updatePrinters(array $data): RestaurantSetting
    {
        $setting = $this->settingRepository->firstOrCreateDefault();

        return $this->settingRepository->update($setting->id, [
            'printers' => $data['printers'] ?? [],
        ]);
    }

    /**
     * @return list<string>
     */
    public function enabledPaymentMethodCodes(): array
    {
        $methods = $this->getPayments()->payment_methods ?? ['cash', 'card', 'upi'];

        $codes = collect($methods)
            ->map(function (mixed $method): ?string {
                if (is_string($method)) {
                    return $method;
                }

                if (is_array($method)) {
                    if (($method['is_enabled'] ?? true) === false) {
                        return null;
                    }

                    return $method['code'] ?? $method['value'] ?? null;
                }

                if ($method instanceof PaymentMethod) {
                    return $method->value;
                }

                return null;
            })
            ->filter()
            ->values()
            ->all();

        return $codes !== [] ? $codes : ['cash', 'card', 'upi'];
    }
}
