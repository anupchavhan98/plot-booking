<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plot;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PlotController extends Controller
{
    /**
     * Display a listing of plots.
     */
    public function index()
    {
        $plots = Plot::orderBy('plot_number')->paginate(15);
        return view('admin.plots.index', compact('plots'));
    }

    /**
     * Show the form for creating a new plot.
     */
    public function create()
    {
        return view('admin.plots.create');
    }

    /**
     * Store a newly created plot.
     */
    public function store(Request $request)
    {
        $request->validate([
            'plot_number' => 'required|string|unique:plots,plot_number',
            'size' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(['available', 'booked', 'blocked'])],
            'row_position' => 'nullable|integer|min:1',
            'col_position' => 'nullable|integer|min:1',
        ]);

        Plot::create($request->all());

        return redirect()->route('admin.plots.index')
            ->with('success', 'Plot added successfully!');
    }

    /**
     * Show the form for editing the specified plot.
     */
    public function edit(Plot $plot)
    {
        return view('admin.plots.edit', compact('plot'));
    }

    /**
     * Update the specified plot.
     */
    public function update(Request $request, Plot $plot)
    {
        $request->validate([
            'plot_number' => [
                'required',
                'string',
                Rule::unique('plots')->ignore($plot->id),
            ],
            'size' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(['available', 'booked', 'blocked'])],
            'row_position' => 'nullable|integer|min:1',
            'col_position' => 'nullable|integer|min:1',
        ]);

        $plot->update($request->all());

        return redirect()->route('admin.plots.index')
            ->with('success', 'Plot updated successfully!');
    }

    /**
     * Remove the specified plot.
     */
    public function destroy(Plot $plot)
    {
        // Prevent deletion if plot is booked
        if ($plot->status === 'booked') {
            return redirect()->route('admin.plots.index')
                ->with('error', 'Cannot delete a booked plot!');
        }

        $plot->delete();

        return redirect()->route('admin.plots.index')
            ->with('success', 'Plot deleted successfully!');
    }

    /**
     * Change plot status via AJAX.
     */
    public function changeStatus(Request $request, Plot $plot)
    {
        $request->validate([
            'status' => ['required', Rule::in(['available', 'booked', 'blocked'])],
        ]);

        $plot->status = $request->status;
        $plot->save();

        return response()->json([
            'success' => true,
            'message' => 'Plot status updated!',
            'new_status' => $plot->status
        ]);
    }
}