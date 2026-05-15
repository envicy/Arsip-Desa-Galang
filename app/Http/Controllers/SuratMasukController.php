<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\JenisSurat;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query dengan eager loading
        $query = SuratMasuk::with('jenisSurat');

        // Pencarian berdasarkan Nomor Surat atau Asal Pengirim
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%" . $search . "%")
                ->orWhere('asal_pengirim', 'like', "%" . $search . "%");
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

        // Ambil data diurutkan berdasarkan tanggal terbaru paling atas
        $data = $query->orderBy('tgl_surat', 'desc')->paginate(10)->withQueryString();

        // Data pendukung untuk dashboard/statistik
        $jenis = JenisSurat::all();
        $totalMasuk = SuratMasuk::count();
        $totalJenis = JenisSurat::count();

        return view('surat_masuk.index', compact('data', 'jenis', 'totalMasuk', 'totalJenis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'  => 'required|string|unique:surat_keluar,nomor_surat',
            'tgl_surat'     => 'required|date|before_or_equal:today',
            'asal_pengirim' => 'required|string',
            'id_jenis'      => 'required|exists:jenis_surat,id_jenis',
            'file_pdf'      => 'required|mimes:pdf|max:2048',
        ], [
            'nomor_surat.required'   => 'Nomor surat wajib diisi.',
            'nomor_surat.unique'   => 'Gagal! Nomor surat sudah terdaftar di sistem.',
            'tgl_surat.required'     => 'Tanggal surat wajib diisi.',
            'tgl_surat.before_or_equal' => 'Tanggal surat tidak boleh melebihi hari ini.',
            'asal_pengirim.required' => 'Asal pengirim wajib diisi.',
            'id_jenis.required'      => 'Jenis surat wajib dipilih.',
            'file_pdf.required'      => 'File surat wajib diunggah.',
            'file_pdf.mimes'         => 'File harus dalam format PDF.',
            'file_pdf.max'           => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        // Proses Upload File
        $file = $request->file('file_pdf');
        $namaFile = 'SM-' . time() . '.' . $file->getClientOriginalExtension();
        
        // Simpan ke storage/app/public/surat/masuk
        $file->storeAs('surat/masuk', $namaFile, 'public');

        SuratMasuk::create([
            'nomor_surat'   => $request->nomor_surat,
            'tgl_surat'     => $request->tgl_surat,
            'asal_pengirim' => $request->asal_pengirim,
            'id_jenis'      => $request->id_jenis,
            'file_pdf'      => $namaFile,
        ]);

        return redirect()->back()->with('success', 'Surat Masuk berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_surat'  => 'required|string|unique:surat_keluar,nomor_surat,' . $id . ',id_surat_keluar',
            'tgl_surat'     => 'required|date|before_or_equal:today',
            'asal_pengirim' => 'required|string',
            'id_jenis'      => 'required|exists:jenis_surat,id_jenis',
            'file_pdf'      => 'nullable|mimes:pdf|max:2048', 
        ], [
            'nomor_surat.required'   => 'Nomor surat wajib diisi.',
            'nomor_surat.unique'   => 'Gagal! Nomor surat sudah digunakan oleh data lain.',
            'tgl_surat.before_or_equal' => 'Tanggal surat tidak boleh melebihi hari ini.',
            'asal_pengirim.required' => 'Asal pengirim wajib diisi.',
            'file_pdf.mimes'         => 'File harus dalam format PDF.',
        ]);

        $surat = SuratMasuk::findOrFail($id);

        // Data dasar yang akan diupdate
        $dataUpdate = [
            'nomor_surat'   => $request->nomor_surat,
            'tgl_surat'     => $request->tgl_surat,
            'asal_pengirim' => $request->asal_pengirim,
            'id_jenis'      => $request->id_jenis,
        ];

        // Cek jika ada file PDF baru
        if ($request->hasFile('file_pdf')) {
            // Hapus file lama jika ada
            if ($surat->file_pdf && Storage::disk('public')->exists('surat/masuk/' . $surat->file_pdf)) {
                Storage::disk('public')->delete('surat/masuk/' . $surat->file_pdf);
            }

            // Upload file baru
            $file = $request->file('file_pdf');
            $namaFile = 'SM-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('surat/masuk', $namaFile, 'public');

            $dataUpdate['file_pdf'] = $namaFile;
        }

        $surat->update($dataUpdate);

        return redirect()->back()->with('success', 'Data Surat Masuk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        // Hapus file fisik
        if ($surat->file_pdf && Storage::disk('public')->exists('surat/masuk/' . $surat->file_pdf)) {
            Storage::disk('public')->delete('surat/masuk/' . $surat->file_pdf);
        }

        $surat->delete();

        return back()->with('success', 'Surat Masuk berhasil dihapus!');
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