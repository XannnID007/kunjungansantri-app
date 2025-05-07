@extends('layouts.app')

@section('title', 'Edit Santri')

@section('page-title', 'Edit Data Santri')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Edit Santri</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.santri.update', $santri) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nis">Nomor Induk Santri:</label>
                            <input type="text" name="nis" id="nis"
                                class="form-control @error('nis') is-invalid @enderror"
                                value="{{ old('nis', $santri->nis) }}" required>
                            @error('nis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama Lengkap:</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $santri->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kamar">Kamar:</label>
                            <input type="text" name="kamar" id="kamar"
                                class="form-control @error('kamar') is-invalid @enderror"
                                value="{{ old('kamar', $santri->kamar) }}" required>
                            @error('kamar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin:</label>
                            <select name="jenis_kelamin" id="jenis_kelamin"
                                class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L"
                                    {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P"
                                    {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat:</label>
                            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"
                                required>{{ old('alamat', $santri->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="is_active">Status:</label>
                            <select name="is_active" id="is_active"
                                class="form-control @error('is_active') is-invalid @enderror" required>
                                <option value="1" {{ old('is_active', $santri->is_active) ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="0" {{ old('is_active', $santri->is_active) ? '' : 'selected' }}>Tidak
                                    Aktif</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="foto">Foto:</label>
                            @if ($santri->foto)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/santri/' . $santri->foto) }}" class="img-thumbnail"
                                        alt="Foto Santri" style="max-height: 150px;">
                                </div>
                            @endif
                            <input type="file" name="foto" id="foto"
                                class="form-control-file @error('foto') is-invalid @enderror">
                            <small class="form-text text-muted">Upload foto baru untuk mengganti foto saat ini (opsional).
                                Format: jpg, jpeg, png. Maks: 2MB.</small>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.santri.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
