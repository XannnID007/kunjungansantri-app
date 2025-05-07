<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('kamar', 'like', "%{$search}%");
            });
        }

        $santri = $query->orderBy('nama')->paginate(10);

        return view('admin.santri.index', compact('santri'));
    }

    public function create()
    {
        return view('admin.santri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|max:20|unique:santri',
            'nama' => 'required|string|max:100',
            'kamar' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/santri', $filename);
            $data['foto'] = $filename;
        }

        Santri::create($data);

        return redirect()->route('admin.santri.index')
            ->with('success', 'Data santri berhasil ditambahkan.');
    }

    public function show(Santri $santri)
    {
        return view('admin.santri.show', compact('santri'));
    }

    public function edit(Santri $santri)
    {
        return view('admin.santri.edit', compact('santri'));
    }

    public function update(Request $request, Santri $santri)
    {
        $request->validate([
            'nis' => 'required|string|max:20|unique:santri,nis,' . $santri->id,
            'nama' => 'required|string|max:100',
            'kamar' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'required|boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($santri->foto) {
                Storage::delete('public/santri/' . $santri->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/santri', $filename);
            $data['foto'] = $filename;
        }

        $santri->update($data);

        return redirect()->route('admin.santri.index')
            ->with('success', 'Data santri berhasil diperbarui.');
    }

    public function destroy(Santri $santri)
    {
        // Periksa apakah santri memiliki kunjungan aktif
        if ($santri->kunjungan()->whereNotIn('status', ['completed', 'cancelled'])->exists()) {
            return redirect()->route('admin.santri.index')
                ->with('error', 'Santri tidak dapat dihapus karena memiliki kunjungan aktif.');
        }

        // Hapus foto jika ada
        if ($santri->foto) {
            Storage::delete('public/santri/' . $santri->foto);
        }

        $santri->delete();

        return redirect()->route('admin.santri.index')
            ->with('success', 'Data santri berhasil dihapus.');
    }
}
