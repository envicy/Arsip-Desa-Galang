<div class="card shadow-sm border-0" style="border-radius: 15px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small">
                    <tr>
                        <th class="ps-4 py-3">NAMA LENGKAP</th>
                        <th>USERNAME</th>
                        <th>PERAN</th>
                        <th>LOGIN TERAKHIR</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($operators as $op)
                    <tr>
                        <td class="ps-4 fw-medium text-dark">{{ $op->nama_lengkap }}</td>
                        <td><span class="badge bg-light text-dark border px-2">{{ $op->nama_pengguna }}</span></td>
                        <td>
                            <span class="badge {{ $op->peran == 'admin' ? 'bg-danger-subtle text-danger' : 'bg-info-subtle text-info' }} border px-3">
                                {{ ucfirst($op->peran) }}
                            </span>
                        </td>
                        <td class="text-muted small">
                            {{ $op->terakhir_login ? \Carbon\Carbon::parse($op->terakhir_login)->diffForHumans() : 'Belum Login' }}
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-outline-primary px-3" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $op->id_pengguna }}" style="border-radius: 8px;">Edit</button>
                                
                                @if(auth()->id() !== $op->id_pengguna)
                                <form action="{{ route('operator.destroy', $op->id_pengguna) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus operator ini?')" style="border-radius: 8px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-sm btn-light text-muted border-0" disabled title="Akun sedang digunakan">
                                    <i class="fas fa-user-lock"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-5 text-muted">Data operator tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $operators->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>