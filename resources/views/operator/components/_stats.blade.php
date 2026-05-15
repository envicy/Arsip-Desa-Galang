<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body d-flex align-items-center">
                <div class="bg-primary-subtle p-3 rounded-circle me-3">
                    <i class="fas fa-users text-primary"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Total Operator</p>
                    <h3 class="fw-bold mb-0">{{ $totalOperator }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body d-flex align-items-center">
                <div class="bg-danger-subtle p-3 rounded-circle me-3">
                    <i class="fas fa-user-shield text-danger"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Admin</p>
                    <h3 class="fw-bold mb-0">{{ $totalAdmin }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body d-flex align-items-center">
                <div class="bg-info-subtle p-3 rounded-circle me-3">
                    <i class="fas fa-user-tie text-info"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Staf</p>
                    <h3 class="fw-bold mb-0">{{ $totalStaf }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>