@extends('layouts.app')

@section('content')
<h5 class="mb-4 fw-semibold">Dashboard</h5>

{{-- Card Statistik --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card p-3 shadow-sm border-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white rounded-circle p-2 me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{ $totalMasuk }}+</h5>
                    <small class="text-muted">Surat Masuk</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 shadow-sm border-0">
            <div class="d-flex align-items-center">
                <div class="bg-warning text-white rounded-circle p-2 me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{ $totalKeluar }}+</h5>
                    <small class="text-muted">Surat Keluar</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 shadow-sm border-0">
            <div class="d-flex align-items-center">
                <div class="bg-danger text-white rounded-circle p-2 me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-folder"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{ $totalJenis }}+</h5>
                    <small class="text-muted">Jenis Surat</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 shadow-sm border-0">
            <div class="d-flex align-items-center">
                <div class="bg-info text-white rounded-circle p-2 me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user-check"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold">{{ auth()->user()->nama_lengkap ?? 'Admin' }}</h6>
                    <small class="text-muted">Petugas Aktif</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        {{-- Form diarahkan ke route dashboard --}}
        <form action="{{ route('dashboard') }}" method="GET" class="row g-3 align-items-end">
            
            {{-- Pencarian Nama/Nomor --}}
            <div class="col-md-3">
                <label class="form-label small fw-bold">Cari Riwayat</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" 
                           placeholder="Nomor surat atau asal..." 
                           value="{{ request('search') }}">
                </div>
            </div>

            {{-- Filter Kategori --}}
            <div class="col-md-2">
                <label class="form-label small fw-bold">Kategori</label>
                <select name="kategori" class="form-select form-select-sm">
                    <option value="">-- Semua Kategori --</option>
                    <option value="Masuk" {{ request('kategori') == 'Masuk' ? 'selected' : '' }}>Surat Masuk</option>
                    <option value="Keluar" {{ request('kategori') == 'Keluar' ? 'selected' : '' }}>Surat Keluar</option>
                </select>
            </div>

            {{-- Filter Jenis Surat --}}
            <div class="col-md-2">
                <label class="form-label small fw-bold">Jenis Surat</label>
                <select name="id_jenis" class="form-select form-select-sm">
                    <option value="">-- Semua Jenis --</option>
                    @foreach($jenisSuratList as $j)
                        <option value="{{ $j->id_jenis }}" {{ request('id_jenis') == $j->id_jenis ? 'selected' : '' }}>
                            {{ $j->jenis_surat }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Rentang Tanggal --}}
            <div class="col-md-2">
                <label class="form-label small fw-bold">Mulai</label>
                <input type="date" name="tgl_mulai" class="form-control form-control-sm" value="{{ request('tgl_mulai') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Selesai</label>
                <input type="date" name="tgl_selesai" class="form-control form-control-sm" value="{{ request('tgl_selesai') }}">
            </div>

            {{-- Tombol Aksi --}}
            <div class="col-md-1 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary w-100" title="Cari">
                    <i class="fas fa-filter"></i>
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary w-100" title="Reset">
                    <i class="fas fa-undo"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Riwayat Terbaru --}}
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="p-3 border-bottom bg-white">
            <h6 class="mb-0 fw-semibold">Riwayat Surat Terbaru</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small">
                    <tr>
                        <th class="ps-3">Nomor Surat</th>
                        <th>Kategori</th>
                        <th>Asal / Tujuan</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $item)
                    <tr>
                        <td class="ps-3 fw-medium text-dark">{{ $item->nomor_surat }}</td>
                        <td>
                            <span class="badge {{ $item->kategori_surat == 'Masuk' ? 'bg-primary-subtle text-primary border-primary' : 'bg-success-subtle text-success border-success' }} border px-2">
                                Surat {{ $item->kategori_surat }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $item->info }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_surat)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ $jenisSurat[$item->id_jenis] ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="text-center">
                            {{-- Tombol Detail Tunggal di Tengah untuk Dashboard --}}
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('surat.detail', [$item->kategori_surat, $item->id]) }}" 
                                   class="btn btn-sm btn-outline-primary px-3">
                                   Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada riwayat surat ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $riwayat->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection