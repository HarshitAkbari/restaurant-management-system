<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Staff;

use App\Http\Controllers\Controller;
use App\Services\Staff\RoleService;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function __construct(
        private readonly RoleService $roleService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.admin.staff.roles.index', [
            'roles' => $this->roleService->allWithPermissions(),
        ]);
    }
}
