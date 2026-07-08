<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Kot\KotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KotController extends Controller
{
    public function __construct(
        private readonly KotService $kotService,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $kots = $this->kotService->pending($request->get('station'));

        return response()->json([
            'data' => $kots->map(fn ($kot) => [
                'id' => $kot->id,
                'order_id' => $kot->order_id,
                'kot_number' => $kot->kot_number,
                'station' => $kot->station,
                'status' => $kot->status?->value ?? $kot->status,
                'created_at' => $kot->created_at?->toIso8601String(),
            ])->values(),
        ]);
    }

    public function updateStatus(Request $request, int $kot): JsonResponse
    {
        $data = $request->validate([
            'status' => ['required', 'string'],
        ]);

        $updated = $this->kotService->updateStatus($kot, $data['status']);

        return response()->json([
            'data' => [
                'id' => $updated->id,
                'status' => $updated->status?->value ?? $updated->status,
                'ready_at' => $updated->ready_at?->toIso8601String(),
                'served_at' => $updated->served_at?->toIso8601String(),
            ],
        ]);
    }
}
