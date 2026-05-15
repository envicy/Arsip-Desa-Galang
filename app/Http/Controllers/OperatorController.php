<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class OperatorController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->peran !== 'admin') {
                return redirect('/dashboard')->with('error', 'Akses ditolak! Hanya Admin yang boleh mengakses halaman Operator.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        // Mengambil data dengan urutan login terbaru dan pagination 10 data
        $operators = Operator::orderBy('terakhir_login', 'desc')->paginate(10);

        // Menghitung total berdasarkan peran
        $totalOperator = Operator::count();
        $totalAdmin = Operator::where('peran', 'admin')->count();
        $totalStaf = Operator::where('peran', 'staf')->count();

        // Kirim semua variabel ke view
        return view('operator.index', compact('operators', 'totalOperator', 'totalAdmin', 'totalStaf'));
    }

    public function store(Request $request)
    {
        // Fitur tidak akan diselesaikan jika validasi gagal
        $request->validate([
            'nama_pengguna' => 'required|string|max:50|unique:pengguna,nama_pengguna',
            'nama_lengkap'  => 'required|string|max:100',
            'kata_sandi'    => 'required|min:8|regex:/[A-Z]/|regex:/[0-9]/',
            'peran'         => 'required|in:admin,staf'
        ], [
            'nama_pengguna.unique' => 'Gagal! Nama pengguna sudah digunakan.',
            'kata_sandi.regex'     => 'Sandi wajib mengandung huruf kapital dan angka.',
            'kata_sandi.min'       => 'Sandi minimal 8 karakter.'
        ]);

        Operator::create([
            'nama_pengguna' => $request->nama_pengguna,
            'nama_lengkap'  => $request->nama_lengkap,
            'kata_sandi'    => Hash::make($request->kata_sandi),
            'peran'         => $request->peran,
        ]);

        return back()->with('success', 'Operator berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $operator = Operator::findOrFail($id);

        // Proteksi Akun Mandiri
        if (Auth::id() == $id && $request->peran !== $operator->peran) {
            return back()->with('error', 'Gagal! Anda tidak bisa mengubah peran sendiri.');
        }

        $request->validate([
            'nama_pengguna' => 'required|string|max:50|unique:pengguna,nama_pengguna,' . $id . ',id_pengguna',
            'nama_lengkap'  => 'required|string|max:100',
            'kata_sandi'    => 'nullable|min:8|regex:/[A-Z]/|regex:/[0-9]/',
            'peran'         => 'required|in:admin,staf'
        ]);

        $operator->nama_pengguna = $request->nama_pengguna;
        $operator->nama_lengkap = $request->nama_lengkap;
        if ($request->filled('kata_sandi')) {
            $operator->kata_sandi = Hash::make($request->kata_sandi);
        }
        $operator->peran = $request->peran;
        $operator->save();

        return back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Gagalkan jika mencoba menghapus diri sendiri
        if (auth()->id() == $id) {
            return back()->with('error', 'Gagal! Anda tidak bisa menghapus akun yang sedang digunakan.');
        }

        Operator::destroy($id);
        return redirect()->route('operator.index')->with('success', 'Operator berhasil dihapus.');
    }
}