@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">Surat Masuk</h5>
    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="fas fa-envelope me-1"></i> Tambah Surat Masuk
    </button>
</div>

{{-- Alert Notifikasi --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm">
        <ul class="mb-0 small">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Memanggil Komponen-Komponen Surat Masuk --}}
@include('surat_masuk.components._stats')
@include('surat_masuk.components._filter')
@include('surat_masuk.components._table')
@include('surat_masuk.components._modal_tambah')

@endsection