<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Customer\CustomerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function __construct(
        private readonly CustomerService $customerService,
    ) {
    }

    public function index(Request $request): View
    {
        return view('restaurant.admin.customers.index', [
            'customers' => $this->customerService->search(
                $request->get('q'),
                (int) $request->get('per_page', 15),
            ),
            'search' => $request->get('q'),
        ]);
    }

    public function create(): View
    {
        return view('restaurant.admin.customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'loyalty_points' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $this->customerService->create($data);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function show(int $customer): View
    {
        return view('restaurant.admin.customers.show', [
            'customer' => $this->customerService->find($customer),
        ]);
    }

    public function edit(int $customer): View
    {
        return view('restaurant.admin.customers.edit', [
            'customer' => $this->customerService->find($customer),
        ]);
    }

    public function update(Request $request, int $customer): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'loyalty_points' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $this->customerService->update($customer, $data);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer updated successfully.');
    }
}
