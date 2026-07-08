<?php

declare(strict_types=1);

namespace App\Services\Kot;

use App\Enums\KotStatus;
use App\Models\Kot;
use App\Repositories\Contracts\KotRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class KotService
{
    public function __construct(
        private readonly KotRepositoryInterface $kotRepository,
    ) {
    }

    public function pending(?string $station = null): Collection
    {
        return $this->kotRepository->pendingByStation($station);
    }

    public function updateStatus(int $id, KotStatus|string $status): Kot
    {
        if (is_string($status)) {
            $status = KotStatus::from($status);
        }

        $data = ['status' => $status];

        if ($status === KotStatus::Ready) {
            $data['ready_at'] = now();
        }

        if ($status === KotStatus::Served) {
            $data['served_at'] = now();
        }

        return $this->kotRepository->update($id, $data);
    }
}
