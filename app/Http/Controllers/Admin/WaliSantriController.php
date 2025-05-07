<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WaliSantri;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class WaliSantriController extends Controller
{
    public function index(Request $request)
    {
        $query = WaliSantri::with('user');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('no_identitas', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        $wali_santri = $query->orderBy('nama')->paginate(10);

        return view('admin.wali-santri.index', compact('wali_santri'));
    }

    public function create()
    {
        $santri = Santri::where('is_active', true)->orderBy('nama')->get();
        return view('admin.wali-santri.create', compact('santri'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_identitas' => 'required|string|max:20|unique:wali_santri',
            'no_hp' => 'nullable|string|max:20',
            'has_smartphone' => 'required|boolean',
            'alamat' => 'required|string',
            'hubungan' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'santri_ids' => 'required|array',
            'santri_ids.*' => 'exists:santri,id',
            'create_account' => 'boolean',
            'email' => 'required_if:create_account,1|email|nullable|unique:users',
            'password' => 'required_if:create_account,1|nullable|min:6',
        ]);

        // Buat user jika diminta
        $userId = null;
        if ($request->create_account && $request->email) {
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password ?? Str::random(8)),
                'role' => 'wali_santri',
                'is_active' => true,
            ]);

            $userId = $user->id;
        }

        // Upload foto jika ada
        $fotoFilename = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fotoFilename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/wali', $fotoFilename);
        }

        // Buat wali santri
        $wali = WaliSantri::create([
            'user_id' => $userId,
            'nama' => $request->nama,
            'no_identitas' => $request->no_identitas,
            'no_hp' => $request->no_hp,
            'has_smartphone' => $request->has_smartphone,
            'alamat' => $request->alamat,
            'hubungan' => $request->hubungan,
            'foto' => $fotoFilename,
        ]);

        // Kaitkan dengan santri
        if ($request->has('santri_ids')) {
            $wali->santri()->attach($request->santri_ids);
        }

        return redirect()->route('admin.wali-santri.index')
            ->with('success', 'Data wali santri berhasil ditambahkan.');
    }

    public function show(WaliSantri $waliSantri)
    {
        $waliSantri->load(['user', 'santri']);
        return view('admin.wali-santri.show', compact('waliSantri'));
    }

    public function edit(WaliSantri $waliSantri)
    {
        $santri = Santri::where('is_active', true)->orderBy('nama')->get();
        $selectedSantri = $waliSantri->santri->pluck('id')->toArray();

        return view('admin.wali-santri.edit', compact('waliSantri', 'santri', 'selectedSantri'));
    }

    public function update(Request $request, WaliSantri $waliSantri)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_identitas' => 'required|string|max:20|unique:wali_santri,no_identitas,' . $waliSantri->id,
            'no_hp' => 'nullable|string|max:20',
            'has_smartphone' => 'required|boolean',
            'alamat' => 'required|string',
            'hubungan' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'santri_ids' => 'required|array',
            'santri_ids.*' => 'exists:santri,id',
        ]);

        // Update data wali
        $data = $request->only(['nama', 'no_identitas', 'no_hp', 'has_smartphone', 'alamat', 'hubungan']);

        // Update foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($waliSantri->foto) {
                Storage::delete('public/wali/' . $waliSantri->foto);
            }

            $file = $request->file('foto');
            $fotoFilename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/wali', $fotoFilename);
            $data['foto'] = $fotoFilename;
        }

        $waliSantri->update($data);

        // Update relasi santri
        $waliSantri->santri()->sync($request->santri_ids);

        // Update user jika ada
        if ($waliSantri->user_id && $request->has('update_user') && $request->update_user) {
            $user = User::find($waliSantri->user_id);
            if ($user) {
                $userData = [
                    'name' => $request->nama,
                ];

                if ($request->has('email') && $request->email != $user->email) {
                    $request->validate([
                        'email' => 'required|email|unique:users,email,' . $user->id,
                    ]);
                    $userData['email'] = $request->email;
                }

                if ($request->has('password') && !empty($request->password)) {
                    $request->validate([
                        'password' => 'min:6',
                    ]);
                    $userData['password'] = Hash::make($request->password);
                }

                $user->update($userData);
            }
        }

        return redirect()->route('admin.wali-santri.index')
            ->with('success', 'Data wali santri berhasil diperbarui.');
    }

    public function destroy(WaliSantri $waliSantri)
    {
        // Periksa apakah wali memiliki kunjungan aktif
        if ($waliSantri->kunjungan()->whereNotIn('status', ['completed', 'cancelled'])->exists()) {
            return redirect()->route('admin.wali-santri.index')
                ->with('error', 'Wali santri tidak dapat dihapus karena memiliki kunjungan aktif.');
        }

        // Hapus foto jika ada
        if ($waliSantri->foto) {
            Storage::delete('public/wali/' . $waliSantri->foto);
        }

        // Hapus relasi dengan santri
        $waliSantri->santri()->detach();

        // Hapus user jika ada
        if ($waliSantri->user_id) {
            $user = User::find($waliSantri->user_id);
            if ($user) {
                $user->delete();
            }
        }

        $waliSantri->delete();

        return redirect()->route('admin.wali-santri.index')
            ->with('success', 'Data wali santri berhasil dihapus.');
    }

    public function createAccount(WaliSantri $waliSantri)
    {
        if ($waliSantri->user_id) {
            return redirect()->route('admin.wali-santri.show', $waliSantri)
                ->with('error', 'Wali santri sudah memiliki akun.');
        }

        return view('admin.wali-santri.create-account', compact('waliSantri'));
    }

    public function storeAccount(Request $request, WaliSantri $waliSantri)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($waliSantri->user_id) {
            return redirect()->route('admin.wali-santri.show', $waliSantri)
                ->with('error', 'Wali santri sudah memiliki akun.');
        }

        // Buat user baru
        $user = User::create([
            'name' => $waliSantri->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'wali_santri',
            'is_active' => true,
        ]);

        // Update wali santri
        $waliSantri->update([
            'user_id' => $user->id,
            'has_smartphone' => true,
        ]);

        return redirect()->route('admin.wali-santri.show', $waliSantri)
            ->with('success', 'Akun untuk wali santri berhasil dibuat.');
    }
}
