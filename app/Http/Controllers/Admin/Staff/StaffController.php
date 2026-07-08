<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Staff;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Services\Staff\StaffService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function __construct(
        private readonly StaffService $staffService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.admin.staff.index', [
            'staff' => $this->staffService->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('restaurant.admin.staff.create', [
            'roles' => UserRole::cases(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string', 'in:' . implode(',', UserRole::values())],
            'preferred_landing' => ['nullable', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $this->staffService->create($data);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff member created successfully.');
    }

    public function edit(int $staff): View
    {
        return view('restaurant.admin.staff.edit', [
            'staffMember' => $this->staffService->find($staff),
            'roles' => UserRole::cases(),
        ]);
    }

    public function update(Request $request, int $staff): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $staff],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'string', 'in:' . implode(',', UserRole::values())],
            'preferred_landing' => ['nullable', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $this->staffService->update($staff, $data);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff member updated successfully.');
    }

    public function deactivate(int $staff): RedirectResponse
    {
        $this->staffService->deactivate($staff);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff member deactivated successfully.');
    }
}
