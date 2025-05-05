<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;  // Import HTTP Client

class InternshipController extends Controller
{
    // Menampilkan halaman splash
    public function splash(){
        return view('internship.splash');
    }

    // Menampilkan halaman form pendaftaran internship
    public function register(){
        $departemens = Departemen::all();
        return view('internship.register', compact('departemens'));
    }

    // Menyimpan data pendaftaran internship
    public function store(Request $request){
        // Validasi data input
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_telepon' => 'required|string|max:30',
            'email' => 'required|email|unique:internships,email',
            'instansi' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'departemen_id' => 'required|exists:departemens,id_departemen',
            'area_kerja' => 'required|string|max:100',
            'pas_foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'surat_rekomendasi' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Generate custom ID untuk internship
        $prefix = now()->format('Ym'); // contoh: 202504
        $last = Internship::where('id_magang', 'like', "$prefix%")->count() + 1;
        $id_magang = $prefix . str_pad($last, 4, '0', STR_PAD_LEFT);

        // Menangani upload file
        $pasFotoPath = $request->file('pas_foto')->store('pas_foto', 'public');
        $suratRekomendasiPath = $request->file('surat_rekomendasi')->store('surat_rekomendasi', 'public');

        // Membuat data internship baru
        $internship = Internship::create([
            'id_magang' => $id_magang,
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'instansi' => $request->instansi,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'departemen_id' => $request->departemen_id,
            'area_kerja' => $request->area_kerja,
            'pas_foto' => $pasFotoPath,
            'surat_rekomendasi' => $suratRekomendasiPath,
            'status' => 'Pending',
        ]);

        // Ambil nama departemen berdasarkan departemen_id
        $departemen = Departemen::find($request->departemen_id);

        // Kirim notifikasi ke Formspree
        $response = Http::post('https://formspree.io/f/xgvojgdb', [
            'id_magang' => $internship->id_magang,
            'nama' => $internship->nama,
            'no_telepon' => $internship->no_telepon,
            'email' => $internship->email,
            'instansi' => $internship->instansi,
            'jenis_kelamin' => $internship->jenis_kelamin,
            'tanggal_mulai' => $internship->tanggal_mulai,
            'tanggal_berakhir' => $internship->tanggal_berakhir,
            'departemen' => $departemen ? $departemen->nama_departemen : 'Departemen Tidak Ditemukan', // Mengambil nama departemen
            'status' => $internship->status,
            'subject' => 'Pendaftaran Magang Baru',
            'message' => 'Data Anda sudah terdaftar, dan mohon tunggu persetujuan dari admin', // Pesan notifikasi
        ]);

        // Cek apakah pengiriman ke Formspree berhasil
        if ($response->successful()) {
            return redirect()->route('internship.splash')->with('success', 'Data magang berhasil dikirim. Menunggu persetujuan.');
        } else {
            return redirect()->route('internship.splash')->with('error', 'Terjadi kesalahan dalam pengiriman notifikasi.');
        }
    }
}
