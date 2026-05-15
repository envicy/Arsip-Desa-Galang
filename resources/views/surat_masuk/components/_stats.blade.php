<div class="row g-3 mb-4">
    {{-- Card Total Surat Masuk --}}
    <div class="col-md-4">
        <div class="card p-3 shadow-sm border-0 border-start border-primary border-4">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white rounded-circle p-2 me-3">
                    <i class="fas fa-envelope px-1"></i>
                </div>
                <div>
                    <h5 class="mb-0">{{ $totalMasuk }}+</h5>
                    <small class="text-muted">Total Surat Masuk</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Card Jenis Surat --}}
    <div class="col-md-4">
        <div class="card p-3 shadow-sm border-0 border-start border-danger border-4">
            <div class="d-flex align-items-center">
                <div class="bg-danger text-white rounded-circle p-2 me-3">
                    <i class="fas fa-folder px-1"></i>
                </div>
                <div>
                    <h5 class="mb-0">{{ $totalJenis }}+</h5>
                    <small class="text-muted">Jenis Surat</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Card Petugas --}}
    <div class="col-md-4">
        <div class="card p-3 shadow-sm border-0 border-start border-info border-4">
            <div class="d-flex align-items-center">
                <div class="bg-info text-white rounded-circle p-2 me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user-check"></i>
                </div>
                <div>
                    <h6 class="mb-0 text-truncate fw-bold" style="max-width: 150px;">{{ auth()->user()->nama_lengkap ?? 'Admin' }}</h6>
                    <small class="text-muted">Petugas Aktif</small>
                </div>
            </div>
        </div>
    </div>
</div>