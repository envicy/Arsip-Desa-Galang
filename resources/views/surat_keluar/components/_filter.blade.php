<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form action="{{ route('surat-keluar.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold">Cari Surat</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Nomor/Tujuan..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Jenis</label>
                <select name="id_jenis" class="form-select form-select-sm">
                    <option value="">-- Semua --</option>
                    @foreach($jenis as $j)
                        <option value="{{ $j->id_jenis }}" {{ request('id_jenis') == $j->id_jenis ? 'selected' : '' }}>{{ $j->jenis_surat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Mulai</label>
                <input type="date" name="tgl_mulai" class="form-control form-control-sm" value="{{ request('tgl_mulai') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Selesai</label>
                <input type="date" name="tgl_selesai" class="form-control form-control-sm" value="{{ request('tgl_selesai') }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary flex-grow-1">Filter</button>
                <a href="{{ route('surat-keluar.index') }}" class="btn btn-sm btn-outline-secondary px-3"><i class="fas fa-undo"></i></a>
            </div>
        </form>
    </div>
</div>