@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Wali Santri</h4>
                        <div class="card-tools">
                            <a href="{{ route('admin.wali-santri.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.wali-santri.update', $waliSantri->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $waliSantri->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="no_hp">Nomor HP</label>
                                <input type="text" name="no_hp" id="no_hp"
                                    class="form-control @error('no_hp') is-invalid @enderror"
                                    value="{{ old('no_hp', $waliSantri->no_hp) }}" required>
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"
                                    required>{{ old('alamat', $waliSantri->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="hubungan">Hubungan dengan Santri</label>
                                <select name="hubungan" id="hubungan"
                                    class="form-control @error('hubungan') is-invalid @enderror" required>
                                    <option value="">-- Pilih Hubungan --</option>
                                    <option value="ayah"
                                        {{ old('hubungan', $waliSantri->hubungan) == 'ayah' ? 'selected' : '' }}>Ayah
                                    </option>
                                    <option value="ibu"
                                        {{ old('hubungan', $waliSantri->hubungan) == 'ibu' ? 'selected' : '' }}>Ibu</option>
                                    <option value="wali"
                                        {{ old('hubungan', $waliSantri->hubungan) == 'wali' ? 'selected' : '' }}>Wali
                                    </option>
                                    <option value="lainnya"
                                        {{ old('hubungan', $waliSantri->hubungan) == 'lainnya' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                                @error('hubungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group" id="hubungan_lainnya_container"
                                style="{{ old('hubungan', $waliSantri->hubungan) == 'lainnya' ? 'display: block;' : 'display: none;' }}">
                                <label for="hubungan_lainnya">Sebutkan Hubungan Lainnya</label>
                                <input type="text" name="hubungan_lainnya" id="hubungan_lainnya"
                                    class="form-control @error('hubungan_lainnya') is-invalid @enderror"
                                    value="{{ old('hubungan_lainnya', $waliSantri->hubungan_lainnya) }}">
                                @error('hubungan_lainnya')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="santri_id">Santri</label>
                                <select name="santri_id" id="santri_id"
                                    class="form-control @error('santri_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Santri --</option>
                                    @foreach ($santri as $s)
                                        <option value="{{ $s->id }}"
                                            {{ old('santri_id', $waliSantri->santri_id) == $s->id ? 'selected' : '' }}>
                                            {{ $s->nama }} - {{ $s->nis }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('santri_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const hubunganSelect = document.getElementById('hubungan');
                const hubunganLainnyaContainer = document.getElementById('hubungan_lainnya_container');

                // Check initial value
                if (hubunganSelect.value === 'lainnya') {
                    hubunganLainnyaContainer.style.display = 'block';
                }

                // Add event listener for changes
                hubunganSelect.addEventListener('change', function() {
                    if (this.value === 'lainnya') {
                        hubunganLainnyaContainer.style.display = 'block';
                    } else {
                        hubunganLainnyaContainer.style.display = 'none';
                    }
                });
            });
        </script>
    @endpush
@endsection
