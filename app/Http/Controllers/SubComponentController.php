<?php

namespace App\Http\Controllers;

use App\Models\SubComponent;
use App\Models\MainComponent;
use Illuminate\Http\Request;

class SubComponentController extends Controller
{
    /**
     * Show the form for creating a new sub component
     */
    public function create()
    {
        $mainComponents = MainComponent::with('component')->get();
        return view('components.create-sub-component', compact('mainComponents'));
    }

    /**
     * Store a newly created sub component
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'main_component_id' => 'required|exists:main_components,id',
            'nama_sub_komponen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status_komponen' => 'nullable|string',
            'no_siri' => 'nullable|string|max:255',
            'no_sijil_pendaftaran' => 'nullable|string|max:255',
            'jenama' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'kuantiti' => 'nullable|integer|min:1',
            'catatan' => 'nullable|string',
            'saiz' => 'nullable|string|max:255',
            'saiz_unit' => 'nullable|string|max:50',
            'kadaran' => 'nullable|string|max:255',
            'kadaran_unit' => 'nullable|string|max:50',
            'kapasiti' => 'nullable|string|max:255',
            'kapasiti_unit' => 'nullable|string|max:50',
        ]);

        $validated['status'] = 'aktif';
        
        SubComponent::create($validated);

        return redirect()->route('components.index')
            ->with('success', 'Sub Komponen berjaya ditambah');
    }

    /**
     * Display the specified sub component
     */
    public function show(SubComponent $subComponent)
    {
        $subComponent->load(['mainComponent.component']);
        return view('components.view-sub-component', compact('subComponent'));
    }

    /**
     * Show the form for editing the sub component
     */
    public function edit(SubComponent $subComponent)
    {
        $mainComponents = MainComponent::with('component')->get();
        return view('components.edit-sub-component', compact('subComponent', 'mainComponents'));
    }

    /**
     * Update the specified sub component
     */
    public function update(Request $request, SubComponent $subComponent)
    {
        $validated = $request->validate([
            'main_component_id' => 'required|exists:main_components,id',
            'nama_sub_komponen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status_komponen' => 'nullable|string',
            'no_siri' => 'nullable|string|max:255',
            'no_sijil_pendaftaran' => 'nullable|string|max:255',
            'jenama' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'kuantiti' => 'nullable|integer|min:1',
            'catatan' => 'nullable|string',
            'saiz' => 'nullable|string|max:255',
            'saiz_unit' => 'nullable|string|max:50',
            'kadaran' => 'nullable|string|max:255',
            'kadaran_unit' => 'nullable|string|max:50',
            'kapasiti' => 'nullable|string|max:255',
            'kapasiti_unit' => 'nullable|string|max:50',
        ]);

        $subComponent->update($validated);

        return redirect()->route('components.index')
            ->with('success', 'Sub Komponen berjaya dikemaskini');
    }

    /**
     * Soft delete the specified sub component
     */
    public function destroy(SubComponent $subComponent)
    {
        $subComponent->delete(); // Soft delete
        
        return redirect()->route('components.index')
            ->with('success', 'Sub Komponen berjaya dipadam');
    }

    /**
     * Display a listing of trashed sub components
     */
    public function trashed()
    {
        $subComponents = SubComponent::onlyTrashed()
            ->with(['mainComponent.component'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);
        
        return view('sub-components.trashed', compact('subComponents'));
    }

    /**
     * Restore a trashed sub component
     */
    public function restore($id)
    {
        $subComponent = SubComponent::onlyTrashed()->findOrFail($id);
        $subComponent->restore();
        
        return redirect()->route('sub-components.trashed')
            ->with('success', 'Sub Komponen berjaya dipulihkan');
    }

    /**
     * Permanently delete a trashed sub component
     */
    public function forceDestroy($id)
    {
        $subComponent = SubComponent::onlyTrashed()->findOrFail($id);
        $subComponent->forceDelete(); // Permanent delete
        
        return redirect()->route('sub-components.trashed')
            ->with('success', 'Sub Komponen berjaya dipadam secara kekal');
    }
}