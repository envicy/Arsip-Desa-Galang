<div class="modal fade" id="modalEdit{{ $item->id_surat_masuk }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $item->id_surat_masuk }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('surat-masuk.update', $item->id_surat_masuk) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold" id="modalEditLabel{{ $item->id_surat_masuk }}">
                        <i class="fas fa-edit me-2"></i>Edit Surat Masuk
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-start">
                    <div class="row g-3">
                        {{-- Nomor Surat --}}
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nomor Surat</label>
                            <input type="text" name="nomor_surat" 
                                   class="form-control @error('nomor_surat') is-invalid @enderror" 
                                   value="{{ old('nomor_surat', $item->nomor_surat) }}" required>
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
                                   value="{{ old('tgl_surat', $item->tgl_surat) }}" required>
                            @error('tgl_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Asal Pengirim --}}
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Asal Pengirim</label>
                            <input type="text" name="asal_pengirim" 
                                   class="form-control @error('asal_pengirim') is-invalid @enderror" 
                                   value="{{ old('asal_pengirim', $item->asal_pengirim) }}" required>
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
                                    <option value="{{ $j->id_jenis }}" {{ old('id_jenis', $item->id_jenis) == $j->id_jenis ? 'selected' : '' }}>
                                        {{ $j->jenis_surat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Upload PDF (Opsional saat edit) --}}
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-primary">Ganti File PDF (Opsional)</label>
                            <input type="file" name="file_pdf" 
                                   class="form-control @error('file_pdf') is-invalid @enderror" 
                                   accept="application/pdf">
                            <div class="form-text mt-1 small">Biarkan kosong jika tidak ingin mengganti file.</div>
                            @error('file_pdf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning px-4 fw-bold text-dark">
                        <i class="fas fa-sync me-1"></i> Update Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>