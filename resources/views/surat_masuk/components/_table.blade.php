<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small">
                    <tr>
                        <th class="ps-3">Nomor Surat</th>
                        <th>Kategori</th>
                        <th>Asal Pengirim</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td class="ps-3 fw-medium">{{ $item->nomor_surat }}</td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary border border-primary">
                                Surat Masuk
                            </span>
                        </td>
                        <td>{{ $item->asal_pengirim }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_surat)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ $item->jenisSurat->jenis_surat ?? '-' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                {{-- Route Detail disesuaikan ke Masuk --}}
                                <a href="{{ route('surat.detail', ['Masuk', $item->id_surat_masuk]) }}" 
                                   class="btn btn-sm btn-outline-primary px-3">Detail</a>
                                
                                {{-- Tombol Edit memanggil Modal Edit Surat Masuk --}}
                                <button class="btn btn-sm btn-outline-secondary px-3" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEdit{{ $item->id_surat_masuk }}">Edit</button>
                                
                                {{-- Form Hapus ke Surat Masuk --}}
                                <form action="{{ route('surat-masuk.destroy', $item->id_surat_masuk) }}" 
                                      method="POST" onsubmit="return confirm('Hapus data surat masuk ini?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger px-3">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Panggil Modal Edit khusus Surat Masuk --}}
                    @include('surat_masuk.components._modal_edit')

                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Data surat masuk tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $data->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>