<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('surat-masuk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="modalTambahLabel">
                        <i class="fas fa-file-import me-2"></i>Tambah Surat Masuk
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        {{-- Nomor Surat --}}
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nomor Surat</label>
                            <input type="text" name="nomor_surat" 
                                   class="form-control @error('nomor_surat') is-invalid @enderror" 
                                   placeholder="Contoh: 005/123/Sekretariat/2026" 
                                   value="{{ old('nomor_surat') }}" required>
                            @error('nomor_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Surat --}}
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Tanggal Surat</label>
                            <input type="date" name="tgl_surat" 
                                   class="form-control @error('tgl_surat') is-invalid @enderror" 
                                   max="{{ date('Y-m-d') }}" 
                                   value="{{ old('tgl_surat') }}" required>
                            @error('tgl_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Asal Pengirim --}}
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Asal Pengirim</label>
                            <input type="text" name="asal_pengirim" 
                                   class="form-control @error('asal_pengirim') is-invalid @enderror" 
                                   placeholder="Nama instansi atau perorangan pengirim" 
                                   value="{{ old('asal_pengirim') }}" required>
                            @error('asal_pengirim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jenis Surat --}}
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Jenis Surat</label>
                            <select name="id_jenis" class="form-select @error('id_jenis') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis --</option>
                                @foreach($jenis as $j)
                                    <option value="{{ $j->id_jenis }}" {{ old('id_jenis') == $j->id_jenis ? 'selected' : '' }}>
                                        {{ $j->jenis_surat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Upload PDF --}}
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-danger">Upload File PDF (Wajib)</label>
                            <input type="file" name="file_pdf" 
                                   class="form-control @error('file_pdf') is-invalid @enderror" 
                                   accept="application/pdf" required>
                            <div class="form-text mt-1 small">Maksimal ukuran: 2MB</div>
                            @error('file_pdf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">
                        <i class="fas fa-save me-1"></i> Simpan Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>