<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterSistemController extends Controller
{
    // ========== SISTEM MANAGEMENT ==========
    
    public function sistemIndex()
    {
        $sistems = DB::table('kod_sistem')
            ->orderBy('kod_sistem')
            ->paginate(15);
        
        return view('admin.sistem.index', compact('sistems'));
    }

    public function sistemCreate()
    {
        return view('admin.sistem.create');
    }

    public function sistemStore(Request $request)
    {
        $request->validate([
            'kod_sistem' => 'required|string|max:50|unique:kod_sistem,kod_sistem',
            'nama_sistem' => 'required|string|max:255',
        ], [
            'kod_sistem.required' => 'Kod Sistem wajib diisi',
            'kod_sistem.unique' => 'Kod Sistem sudah wujud',
            'nama_sistem.required' => 'Nama Sistem wajib diisi',
        ]);

        DB::table('kod_sistem')->insert([
            'kod_sistem' => strtoupper($request->kod_sistem),
            'nama_sistem' => $request->nama_sistem,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.sistem.index')
            ->with('success', 'Sistem berjaya ditambah!');
    }

    public function sistemEdit($id)
    {
        $sistem = DB::table('kod_sistem')->where('id', $id)->first();
        
        if (!$sistem) {
            abort(404);
        }
        
        return view('admin.sistem.edit', compact('sistem'));
    }

    public function sistemUpdate(Request $request, $id)
    {
        $request->validate([
            'kod_sistem' => 'required|string|max:50|unique:kod_sistem,kod_sistem,' . $id,
            'nama_sistem' => 'required|string|max:255',
        ]);

        DB::table('kod_sistem')
            ->where('id', $id)
            ->update([
                'kod_sistem' => strtoupper($request->kod_sistem),
                'nama_sistem' => $request->nama_sistem,
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.sistem.index')
            ->with('success', 'Sistem berjaya dikemaskini!');
    }

    public function sistemDelete($id)
    {
        // Check if sistem is being used in subsistem
        $usageCount = DB::table('kod_subsistem')
            ->where('kod_sistem', DB::table('kod_sistem')->where('id', $id)->value('kod_sistem'))
            ->count();

        if ($usageCount > 0) {
            return back()->with('error', 'Sistem tidak boleh dihapuskan kerana masih digunakan oleh ' . $usageCount . ' SubSistem!');
        }

        DB::table('kod_sistem')->where('id', $id)->delete();

        return redirect()->route('admin.sistem.index')
            ->with('success', 'Sistem berjaya dihapuskan!');
    }

    // ========== SUBSISTEM MANAGEMENT ==========
    
    public function subSistemIndex()
    {
        $subsistems = DB::table('kod_subsistem')
            ->leftJoin('kod_sistem', 'kod_subsistem.kod_sistem', '=', 'kod_sistem.kod_sistem')
            ->select('kod_subsistem.*', 'kod_sistem.nama_sistem')
            ->orderBy('kod_subsistem.kod_sistem')
            ->orderBy('kod_subsistem.kod_subsistem')
            ->paginate(15);
        
        return view('admin.subsistem.index', compact('subsistems'));
    }

    public function subSistemCreate()
    {
        $sistems = DB::table('kod_sistem')
            ->orderBy('kod_sistem')
            ->get();
        
        return view('admin.subsistem.create', compact('sistems'));
    }

    public function subSistemStore(Request $request)
    {
        $request->validate([
            'kod_sistem' => 'required|exists:kod_sistem,kod_sistem',
            'kod_subsistem' => 'required|string|max:50',
            'nama_subsistem' => 'required|string|max:255',
        ], [
            'kod_sistem.required' => 'Kod Sistem wajib dipilih',
            'kod_subsistem.required' => 'Kod SubSistem wajib diisi',
            'nama_subsistem.required' => 'Nama SubSistem wajib diisi',
        ]);

        // Check unique combination
        $exists = DB::table('kod_subsistem')
            ->where('kod_sistem', $request->kod_sistem)
            ->where('kod_subsistem', strtoupper($request->kod_subsistem))
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->withErrors(['kod_subsistem' => 'Kombinasi Kod Sistem dan Kod SubSistem sudah wujud!']);
        }

        DB::table('kod_subsistem')->insert([
            'kod_sistem' => $request->kod_sistem,
            'kod_subsistem' => strtoupper($request->kod_subsistem),
            'nama_subsistem' => $request->nama_subsistem,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.subsistem.index')
            ->with('success', 'SubSistem berjaya ditambah!');
    }

    public function subSistemEdit($id)
    {
        $subsistem = DB::table('kod_subsistem')->where('id', $id)->first();
        
        if (!$subsistem) {
            abort(404);
        }
        
        $sistems = DB::table('kod_sistem')
            ->orderBy('kod_sistem')
            ->get();
        
        return view('admin.subsistem.edit', compact('subsistem', 'sistems'));
    }

    public function subSistemUpdate(Request $request, $id)
    {
        $request->validate([
            'kod_sistem' => 'required|exists:kod_sistem,kod_sistem',
            'kod_subsistem' => 'required|string|max:50',
            'nama_subsistem' => 'required|string|max:255',
        ]);

        // Check unique combination (excluding current record)
        $exists = DB::table('kod_subsistem')
            ->where('kod_sistem', $request->kod_sistem)
            ->where('kod_subsistem', strtoupper($request->kod_subsistem))
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->withErrors(['kod_subsistem' => 'Kombinasi Kod Sistem dan Kod SubSistem sudah wujud!']);
        }

        DB::table('kod_subsistem')
            ->where('id', $id)
            ->update([
                'kod_sistem' => $request->kod_sistem,
                'kod_subsistem' => strtoupper($request->kod_subsistem),
                'nama_subsistem' => $request->nama_subsistem,
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.subsistem.index')
            ->with('success', 'SubSistem berjaya dikemaskini!');
    }

    public function subSistemDelete($id)
    {
        DB::table('kod_subsistem')->where('id', $id)->delete();

        return redirect()->route('admin.subsistem.index')
            ->with('success', 'SubSistem berjaya dihapuskan!');
    }
}