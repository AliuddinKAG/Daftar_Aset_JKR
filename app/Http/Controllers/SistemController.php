<?php

namespace App\Http\Controllers;

use App\Models\Sistem;
use Illuminate\Http\Request;

class SistemController extends Controller
{
    /**
     * Display a listing of systems
     */
    public function index(Request $request)
    {
        $query = Sistem::withCount('subsistems');

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('kod', 'like', "%{$request->search}%")
                  ->orWhere('nama', 'like', "%{$request->search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } else {
                $query->where('is_active', false);
            }
        }

        $sistems = $query->orderBy('kod')->paginate(12);

        return view('admin.sistem.index', compact('sistems'));
    }

    /**
     * Show the form for creating a new system
     */
    public function create()
    {
        return view('admin.sistem.create');
    }

    /**
     * Store a newly created system
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kod' => 'required|string|max:50|unique:sistems',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ], [
            'kod.required' => 'Kod sistem diperlukan',
            'kod.unique' => 'Kod sistem sudah wujud',
            'nama.required' => 'Nama sistem diperlukan',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        Sistem::create($validated);

        return redirect()->route('admin.sistem.index')
            ->with('success', 'Sistem berjaya ditambah!');
    }

    /**
     * Show the form for editing the system
     */
    public function edit(Sistem $sistem)
    {
        return view('admin.sistem.edit', compact('sistem'));
    }

    /**
     * Update the system
     */
    public function update(Request $request, Sistem $sistem)
    {
        $validated = $request->validate([
            'kod' => 'required|string|max:50|unique:sistems,kod,' . $sistem->id,
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ], [
            'kod.required' => 'Kod sistem diperlukan',
            'kod.unique' => 'Kod sistem sudah wujud',
            'nama.required' => 'Nama sistem diperlukan',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $sistem->update($validated);

        return redirect()->route('admin.sistem.index')
            ->with('success', 'Sistem berjaya dikemaskini!');
    }

    /**
     * Remove the system
     */
    public function destroy(Sistem $sistem)
    {
        // Check if sistem has subsistems
        if ($sistem->subsistems()->count() > 0) {
            return back()->with('error', 'Sistem tidak boleh dipadam kerana masih mempunyai subsistem!');
        }

        $sistem->delete();

        return redirect()->route('admin.sistem.index')
            ->with('success', 'Sistem berjaya dipadam!');
    }

    /**
     * Show subsistems for a system
     */
    public function subsistems(Sistem $sistem)
    {
        $subsistems = $sistem->subsistems()->paginate(15);

        return view('admin.sistem.subsystems', compact('sistem', 'subsistems'));
    }
}