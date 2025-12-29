<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::whereHas('role', fn($q) => $q->where('slug', 'customer'))
                         ->with('bookings')
                         ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        $customer->load('bookings.plot', 'bookings.payments');
        return view('admin.customers.show', compact('customer'));
    }
}