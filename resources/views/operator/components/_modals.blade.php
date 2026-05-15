{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> {{-- Ukuran disamakan dengan Surat Keluar --}}
        <form action="{{ route('operator.store') }}" method="POST" class="modal-content border-0 shadow-lg">
            @csrf
            <div class="modal-header bg-primary text-white border-0 py-3">
                <h5 class="modal-title fw-bold"><i class="fas fa-user-plus me-2"></i> Tambah Operator</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control shadow-sm" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Username</label>
                        <input type="text" name="nama_pengguna" class="form-control shadow-sm" placeholder="Contoh: maula" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Kata Sandi</label>
                        <input type="password" name="kata_sandi" class="form-control shadow-sm" required>
                        <div class="mt-2 p-2 rounded bg-light border" style="font-size: 11px;">
                            <i class="fas fa-info-circle text-primary me-1"></i> Min. 8 karakter, 1 Huruf Kapital, & Angka.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Peran</label>
                        <select name="peran" class="form-select shadow-sm" required>
                            <option value="" disabled selected>-- Pilih Peran --</option>
                            <option value="staf">Staf</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light p-3 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-secondary px-4 fw-bold" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                <button type="submit" class="btn btn-primary px-4 fw-bold" style="border-radius: 8px;">
                    <i class="fas fa-save me-1"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
@foreach($operators as $op)
<div class="modal fade" id="modalEdit{{ $op->id_pengguna }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('operator.update', $op->id_pengguna) }}" method="POST" class="modal-content border-0 shadow-lg">
            @csrf @method('PUT')
            <div class="modal-header bg-primary text-white border-0 py-3">
                <h5 class="modal-title fw-bold"><i class="fas fa-user-edit me-2"></i> Edit Petugas: {{ $op->nama_lengkap }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control shadow-sm" value="{{ $op->nama_lengkap }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Username</label>
                        <input type="text" name="nama_pengguna" class="form-control shadow-sm" value="{{ $op->nama_pengguna }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Ganti Sandi (Opsional)</label>
                        <input type="password" name="kata_sandi" class="form-control shadow-sm">
                        <p class="text-muted mt-1" style="font-size: 10px;">*Biarkan kosong jika tidak ingin mengubah sandi.</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Peran</label>
                        <select name="peran" class="form-select shadow-sm" required {{ auth()->id() === $op->id_pengguna ? 'disabled' : '' }}>
                            <option value="staf" {{ $op->peran == 'staf' ? 'selected' : '' }}>Staf</option>
                            <option value="admin" {{ $op->peran == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @if(auth()->id() === $op->id_pengguna)
                            <input type="hidden" name="peran" value="{{ $op->peran }}">
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light p-3 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-secondary px-4 fw-bold" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                <button type="submit" class="btn btn-primary px-4 fw-bold" style="border-radius: 8px;">
                    <i class="fas fa-sync me-1"></i> Update Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach