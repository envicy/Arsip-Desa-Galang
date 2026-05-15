<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Statistik Card Atas
        $totalMasuk = SuratMasuk::count();
        $totalKeluar = SuratKeluar::count();
        $totalJenis = JenisSurat::count();

        // 2. Ambil list jenis surat untuk dropdown filter & label
        $jenisSuratList = JenisSurat::all();
        $jenisSurat = JenisSurat::pluck('jenis_surat', 'id_jenis');

        // 3. Query Dasar Surat Masuk
        $queryMasuk = DB::table('surat_masuk')
            ->select(
                'id_surat_masuk as id', 
                'nomor_surat', 
                'tgl_surat', 
                'asal_pengirim as info', 
                'id_jenis', 
                DB::raw("'Masuk' as kategori_surat")
            );

        // 4. Query Dasar Surat Keluar
        $queryKeluar = DB::table('surat_keluar')
            ->select(
                'id_surat_keluar as id', 
                'nomor_surat', 
                'tgl_surat', 
                'tujuan_surat as info', 
                'id_jenis', 
                DB::raw("'Keluar' as kategori_surat")
            );

        // 5. Terapkan Filter pada masing-masing query sebelum Union
        // Filter Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $queryMasuk->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%$search%")
                  ->orWhere('asal_pengirim', 'like', "%$search%");
            });
            $queryKeluar->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%$search%")
                  ->orWhere('tujuan_surat', 'like', "%$search%");
            });
        }

        // Filter Jenis Surat
        if ($request->filled('id_jenis')) {
            $queryMasuk->where('id_jenis', $request->id_jenis);
            $queryKeluar->where('id_jenis', $request->id_jenis);
        }

        // Filter Rentang Tanggal
        if ($request->filled('tgl_mulai')) {
            $queryMasuk->whereDate('tgl_surat', '>=', $request->tgl_mulai);
            $queryKeluar->whereDate('tgl_surat', '>=', $request->tgl_mulai);
        }
        if ($request->filled('tgl_selesai')) {
            $queryMasuk->whereDate('tgl_surat', '<=', $request->tgl_selesai);
            $queryKeluar->whereDate('tgl_surat', '<=', $request->tgl_selesai);
        }

        // 6. Menggabungkan Data (Union) Berdasarkan Kategori
        if ($request->kategori == 'Masuk') {
            $combinedQuery = $queryMasuk;
        } elseif ($request->kategori == 'Keluar') {
            $combinedQuery = $queryKeluar;
        } else {
            $combinedQuery = $queryMasuk->union($queryKeluar);
        }

        // 7. Eksekusi Final Query dengan Wrap Table (agar orderBy bekerja pada hasil union)
        $riwayat = DB::table(DB::raw("({$combinedQuery->toSql()}) as combined_surat"))
            ->mergeBindings($combinedQuery) // Penting untuk query union
            ->orderBy('tgl_surat', 'desc')
            ->paginate(10)
            ->withQueryString(); // Agar filter tetap ada saat pindah halaman

        return view('dashboard', compact(
            'totalMasuk', 
            'totalKeluar', 
            'totalJenis', 
            'riwayat', 
            'jenisSurat', 
            'jenisSuratList'
        ));
    }
    
    public function show($kategori, $id)
    {
        if ($kategori === 'Masuk') {
            $surat = SuratMasuk::with('jenisSurat')->findOrFail($id);
        } else {
            $surat = SuratKeluar::with('jenisSurat')->findOrFail($id);
        }
        
        return view('detail_surat', compact('surat', 'kategori'));
    }
}