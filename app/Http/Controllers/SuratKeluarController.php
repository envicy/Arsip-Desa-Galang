<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratKeluar;
use App\Models\JenisSurat;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query dengan eager loading untuk menghindari N+1 problem
        $query = SuratKeluar::with('jenisSurat');

        // Pencarian berdasarkan Nomor Surat atau Tujuan Surat
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%" . $search . "%")
                ->orWhere('tujuan_surat', 'like', "%" . $search . "%");
            });
        }

        // Filter berdasarkan Jenis Surat
        if ($request->id_jenis) {
            $query->where('id_jenis', $request->id_jenis);
        }
        
        // Filter berdasarkan Rentang Tanggal
        if ($request->tgl_mulai && $request->tgl_selesai) {
            $query->whereBetween('tgl_surat', [$request->tgl_mulai, $request->tgl_selesai]);
        }

        // Ambil data diurutkan berdasarkan tanggal terbaru dengan pagination
        $data = $query->orderBy('tgl_surat', 'desc')->paginate(10)->withQueryString();

        // Data pendukung untuk dashboard/statistik
        $jenis = JenisSurat::all();
        $totalKeluar = SuratKeluar::count();
        $totalJenis = JenisSurat::count();

        return view('surat_keluar.index', compact('data', 'jenis', 'totalKeluar', 'totalJenis'));
    }

    public function store(Request $request)
    {
    $request->validate([
            // Menambahkan 'unique:surat_keluar' agar nomor surat tidak boleh sama di tabel surat_keluar
            'nomor_surat'  => 'required|string|unique:surat_keluar,nomor_surat',
            'tgl_surat'    => 'required|date|before_or_equal:today',
            'tujuan_surat' => 'required|string',
            'id_jenis'     => 'required|exists:jenis_surat,id_jenis',
            'file_pdf'     => 'required|mimes:pdf|max:2048',
        ], [
            'nomor_surat.required' => 'Nomor surat wajib diisi.',
            'nomor_surat.unique'   => 'Gagal! Nomor surat sudah terdaftar di sistem.', // Notifikasi jika nomor sama
            'tgl_surat.required'   => 'Tanggal surat wajib diisi.',
            'tgl_surat.before_or_equal' => 'Tanggal surat tidak boleh melebihi hari ini.',
            'id_jenis.required'    => 'Jenis surat wajib dipilih.',
            'file_pdf.required'    => 'File surat wajib diunggah.',
            'file_pdf.mimes'       => 'File harus dalam format PDF.',
            'file_pdf.max'         => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        // Proses Upload File
        $file = $request->file('file_pdf');
        $namaFile = 'SK-' . time() . '.' . $file->getClientOriginalExtension();
        
        // Simpan ke storage/app/public/surat/keluar
        $file->storeAs('surat/keluar', $namaFile, 'public');

        SuratKeluar::create([
            'nomor_surat'  => $request->nomor_surat,
            'tgl_surat'    => $request->tgl_surat,
            'tujuan_surat' => $request->tujuan_surat,
            'id_jenis'     => $request->id_jenis,
            'file_pdf'     => $namaFile,
        ]);

        return redirect()->back()->with('success', 'Surat berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
    $request->validate([
            // 'unique' ditambahkan dengan parameter $id agar mengabaikan nomor surat milik data itu sendiri saat diedit
            'nomor_surat'  => 'required|string|unique:surat_keluar,nomor_surat,' . $id . ',id_surat_keluar',
            'tgl_surat'    => 'required|date|before_or_equal:today',
            'tujuan_surat' => 'required|string',
            'id_jenis'     => 'required|exists:jenis_surat,id_jenis',
            'file_pdf'     => 'nullable|mimes:pdf|max:2048',
        ], [
            'nomor_surat.required' => 'Nomor surat wajib diisi.',
            'nomor_surat.unique'   => 'Gagal! Nomor surat sudah digunakan oleh data lain.', // Notifikasi jika nomor sama
            'tgl_surat.before_or_equal' => 'Tanggal surat tidak boleh melebihi hari ini.',
            'file_pdf.mimes'       => 'File harus dalam format PDF.',
        ]);

        $surat = SuratKeluar::findOrFail($id);

        // Data dasar yang akan diupdate
        $dataUpdate = [
            'nomor_surat'  => $request->nomor_surat,
            'tgl_surat'    => $request->tgl_surat,
            'tujuan_surat' => $request->tujuan_surat,
            'id_jenis'     => $request->id_jenis,
        ];

        // Cek jika ada file PDF baru yang diunggah
        if ($request->hasFile('file_pdf')) {
            // 1. Hapus file lama jika ada di folder storage
            if ($surat->file_pdf && Storage::disk('public')->exists('surat/keluar/' . $surat->file_pdf)) {
                Storage::disk('public')->delete('surat/keluar/' . $surat->file_pdf);
            }

            // 2. Upload file baru
            $file = $request->file('file_pdf');
            $namaFile = 'SK-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('surat/keluar', $namaFile, 'public');

            // 3. Tambahkan nama file baru ke array update
            $dataUpdate['file_pdf'] = $namaFile;
        }

        $surat->update($dataUpdate);

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $surat = SuratKeluar::findOrFail($id);

        // Hapus file fisik dari storage sebelum hapus record di database
        if ($surat->file_pdf && Storage::disk('public')->exists('surat/keluar/' . $surat->file_pdf)) {
            Storage::disk('public')->delete('surat/keluar/' . $surat->file_pdf);
        }

        $surat->delete();

        return back()->with('success', 'Surat berhasil dihapus!');
    }
    public function show($kategori, $id) // Sesuaikan dengan parameter di route kamu
    {
        // Logika mengambil data surat...
        if ($kategori == 'Masuk') {
            $surat = SuratMasuk::findOrFail($id);
        } else {
            $surat = SuratKeluar::findOrFail($id);
        }

        // PASTIKAN 'kategori' masuk ke sini
        return view('surat.detail', compact('surat', 'kategori')); 
    }
}