<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small">
                    <tr>
                        <th class="ps-3">Nomor Surat</th>
                        <th>Kategori</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td class="ps-3 fw-medium">{{ $item->nomor_surat }}</td>
                        <td><span class="badge bg-success-subtle text-success border border-success">Surat Keluar</span></td>
                        <td>{{ $item->tujuan_surat }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_surat)->format('d/m/Y') }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $item->jenisSurat->jenis_surat ?? '-' }}</span></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('surat.detail', ['Keluar', $item->id_surat_keluar]) }}" class="btn btn-sm btn-outline-primary px-3">Detail</a>
                                <button class="btn btn-sm btn-outline-secondary px-3" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id_surat_keluar }}">Edit</button>
                                <form action="{{ route('surat-keluar.destroy', $item->id_surat_keluar) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger px-3">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Panggil Modal Edit di sini agar variabel $item terbaca --}}
                    @include('surat_keluar.components._modal_edit')

                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Data tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $data->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>