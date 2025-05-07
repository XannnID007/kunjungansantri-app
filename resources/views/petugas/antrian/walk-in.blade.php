<div class="modal fade" id="walkInModal" tabindex="-1" role="dialog" aria-labelledby="walkInModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="walkInModalLabel">Pendaftaran Kunjungan Walk-In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('petugas.antrian.register-walk') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="wali_id">Wali Santri:</label>
                        <select name="wali_id" id="wali_id" class="form-control" required>
                            <option value="">-- Pilih Wali Santri --</option>
                            @foreach (\App\Models\WaliSantri::orderBy('nama')->get() as $wali)
                                <option value="{{ $wali->id }}">{{ $wali->nama }} ({{ $wali->no_identitas }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="santri_id">Santri:</label>
                        <select name="santri_id" id="santri_id" class="form-control" required>
                            <option value="">-- Pilih Santri --</option>
                            @foreach (\App\Models\Santri::where('is_active', true)->orderBy('nama')->get() as $santri)
                                <option value="{{ $santri->id }}">{{ $santri->nama }} ({{ $santri->kamar }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tujuan_kunjungan">Tujuan Kunjungan:</label>
                        <input type="text" name="tujuan_kunjungan" id="tujuan_kunjungan" class="form-control"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="catatan">Catatan (opsional):</label>
                        <textarea name="catatan" id="catatan" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Daftar Barang yang Dibawa (opsional):</label>
                        <div id="barang-container">
                            <div class="barang-item mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="barang[0][nama_barang]" class="form-control"
                                            placeholder="Nama Barang">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="barang[0][jumlah]" class="form-control"
                                            placeholder="Jumlah" min="1" value="1">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="barang[0][deskripsi]" class="form-control"
                                            placeholder="Deskripsi/Keterangan">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="tambah-barang" class="btn btn-sm btn-info">
                            <i class="fas fa-plus"></i> Tambah Barang
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Daftarkan Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle tambah barang
        const tambahBarangBtn = document.getElementById('tambah-barang');
        const barangContainer = document.getElementById('barang-container');
        let barangCount = 1;

        tambahBarangBtn.addEventListener('click', function() {
            const barangItem = document.createElement('div');
            barangItem.className = 'barang-item mb-3';
            barangItem.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="barang[${barangCount}][nama_barang]" class="form-control" placeholder="Nama Barang">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="barang[${barangCount}][jumlah]" class="form-control" placeholder="Jumlah" min="1" value="1">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="barang[${barangCount}][deskripsi]" class="form-control" placeholder="Deskripsi/Keterangan">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm hapus-barang">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;

            barangContainer.appendChild(barangItem);
            barangCount++;

            // Handle hapus barang
            const hapusBarangBtns = document.querySelectorAll('.hapus-barang');
            hapusBarangBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.barang-item').remove();
                });
            });
        });
    });
</script>
