<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    public function index()
    {
        $agents = User::whereHas('role', fn($q) => $q->where('slug', 'agent'))
                      ->with('agent')
                      ->paginate(15);

        return view('admin.agents.index', compact('agents'));
    }

    public function create()
    {
        return view('admin.agents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|unique:users',
            'password' => 'required|min:8|confirmed',
            'commission_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => 2, // Agent role ID
        ]);

        Agent::create([
            'user_id' => $user->id,
            'commission_percentage' => $request->commission_percentage,
        ]);

        return redirect()->route('admin.agents.index')
            ->with('success', 'Agent created successfully!');
    }
}