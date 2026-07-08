<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Table\TableService;
use Illuminate\Http\JsonResponse;

class TableController extends Controller
{
    public function __construct(
        private readonly TableService $tableService,
    ) {
    }

    public function index(): JsonResponse
    {
        $tables = $this->tableService->allWithArea();

        return response()->json([
            'data' => $tables->map(fn ($table) => [
                'id' => $table->id,
                'area_id' => $table->area_id,
                'area_name' => $table->area?->name,
                'name' => $table->name,
                'code' => $table->code,
                'capacity' => $table->capacity,
                'status' => $table->status?->value ?? $table->status,
            ])->values(),
        ]);
    }
}
