<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\InformationFlow;
use App\Http\Controllers\Controller;

class InformationFlowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $flows = InformationFlow::ordered()->paginate(20);
        return view('admin.information.flows.index', compact('flows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.information.flows.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'step_number' => 'required|integer',
            'icon' => 'nullable|string|max:50',
            'duration_days' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        InformationFlow::create($validated);

        return redirect()->route('admin.information-flows.index')
            ->with('success', 'Alur permohonan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $flow = InformationFlow::findOrFail($id);
        return view('admin.information.flows.edit', compact('flow'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $flow = InformationFlow::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'step_number' => 'required|integer',
            'icon' => 'nullable|string|max:50',
            'duration_days' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $flow->update($validated);

        return redirect()->route('admin.information-flows.index')
            ->with('success', 'Alur permohonan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        InformationFlow::findOrFail($id)->delete();

        return redirect()->route('admin.information-flows.index')
            ->with('success', 'Alur permohonan berhasil dihapus');
    }
}
