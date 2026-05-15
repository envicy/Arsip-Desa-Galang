@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        {{-- Header Card --}}
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-primary">
                <i class="fas fa-info-circle me-2"></i>Detail Arsip Surat {{ $kategori }}
            </h5>
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
        
        <div class="card-body p-4">
            {{-- Judul Perihal --}}
            <h4 class="mb-4 fw-bold text-dark">{{ $surat->perihal ?? 'Tanpa Perihal' }}</h4>
            
            {{-- Informasi Surat --}}
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td width="180" class="text-muted">Nomor Surat</td>
                            <td class="fw-bold">: {{ $surat->nomor_surat }}</td>
                        </tr>
                        <tr>
                            {{-- Kondisi Label: Jika Masuk tampilkan 'Asal Pengirim', jika Keluar tampilkan 'Tujuan Surat' --}}
                            <td class="text-muted">
                                {{ $kategori == 'Masuk' ? 'Asal Pengirim' : 'Tujuan Surat' }}
                            </td>
                            <td class="fw-bold">
                                : {{ $kategori == 'Masuk' ? ($surat->asal_pengirim ?? '-') : ($surat->tujuan_surat ?? '-') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tanggal Surat</td>
                            <td>: {{ \Carbon\Carbon::parse($surat->tgl_surat)->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jenis Surat</td>
                            <td>: <span class="badge bg-light text-dark border">{{ $surat->jenisSurat->jenis_surat ?? '-' }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr class="my-4">

            {{-- Pratinjau PDF --}}
            <div class="mt-2">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-file-pdf text-danger me-2"></i>Pratinjau File Surat
                    </h6>
                    
                    @if($surat->file_pdf)
                        <a href="{{ asset('storage/surat/' . strtolower($kategori) . '/' . $surat->file_pdf) }}" 
                           target="_blank" 
                           class="btn btn-sm btn-danger px-3">
                            <i class="fas fa-external-link-alt me-1"></i> Buka di Tab Baru
                        </a>
                    @endif
                </div>

                @if($surat->file_pdf)
                    <div class="rounded border bg-light shadow-sm" style="height: 700px; overflow: hidden;">
                        {{-- Menggunakan iframe/embed untuk pratinjau --}}
                        <iframe 
                            src="{{ asset('storage/surat/' . strtolower($kategori) . '/' . $surat->file_pdf) }}#toolbar=0" 
                            width="100%" 
                            height="100%" 
                            style="border:none;">
                        </iframe>
                    </div>
                @else
                    <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-3 fa-2x"></i>
                        <div>
                            <strong>File tidak ditemukan!</strong><br>
                            Arsip digital untuk surat ini belum diunggah atau file tidak ada di direktori server.
                        </div>
                    </div>
                @endif
            </div>
            
            {{-- Footer Action --}}
            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ url()->previous() }}" class="btn btn-secondary px-4 shadow-sm">
                    <i class="fas fa-chevron-left me-1"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection