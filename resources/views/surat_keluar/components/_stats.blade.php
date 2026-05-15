<div class="row g-3 mb-4">
    {{-- Card Surat Keluar --}}
    <div class="col-md-4">
        <div class="card p-3 shadow-sm border-0 border-start border-warning border-4">
            <div class="d-flex align-items-center">
                {{-- Menggunakan fas fa-paper-plane --}}
                <div class="bg-warning text-white rounded-circle p-2 me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{ $totalKeluar }}+</h5>
                    <small class="text-muted">Total Surat Keluar</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Card Jenis Surat --}}
    <div class="col-md-4">
        <div class="card p-3 shadow-sm border-0 border-start border-danger border-4">
            <div class="d-flex align-items-center">
                {{-- Menggunakan fas fa-folder --}}
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