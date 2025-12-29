<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['booking.plot', 'booking.customer'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('booking.customer', fn($q) => $q->where('name', 'like', "%$search%"))
                  ->orWhere('transaction_id', 'like', "%$search%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('method')) {
            $query->where('payment_method', str_replace('_', ' ', $request->method));
        }

        $payments = $query->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }
}