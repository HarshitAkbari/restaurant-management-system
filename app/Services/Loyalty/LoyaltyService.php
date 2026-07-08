<?php

declare(strict_types=1);

namespace App\Services\Loyalty;

use App\Models\LoyaltySetting;
use App\Repositories\Contracts\LoyaltySettingRepositoryInterface;

class LoyaltyService
{
    public function __construct(
        private readonly LoyaltySettingRepositoryInterface $loyaltySettingRepository,
    ) {
    }

    public function get(): LoyaltySetting
    {
        return $this->loyaltySettingRepository->firstOrCreateDefault();
    }

    public function update(array $data): LoyaltySetting
    {
        $setting = $this->get();

        return $this->loyaltySettingRepository->update($setting->id, [
            'is_enabled' => (bool) ($data['is_enabled'] ?? false),
            'points_per_rupee' => (float) ($data['points_per_rupee'] ?? 0),
            'rupee_per_point' => (float) ($data['rupee_per_point'] ?? 0),
            'min_redeem_points' => (int) ($data['min_redeem_points'] ?? 0),
        ]);
    }
}
