<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Internship;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    //
    // AdminController.php
    public function intern() {
        $intern = Internship::with('departemen')->paginate(17); // Tambahkan relasi dan pagination

        // Menambah Notifikasi untuk setiap pendaftaran baru
        $notifications = Notification::latest()->take(10)->get();
        $unreadCount = Notification::where('is_read', false)->count();
        return view('admin.internship', compact('intern', 'notifications', 'unreadCount'));
    }

    public function details($id){
        $interns = Internship::where('id_magang', $id)->firstOrFail();
        return view('admin.detail', compact('interns'));
    }

    // Method untuk menerima anak magang
    public function AcceptIntern(Request $request, $id)
    {
        $intern = Internship::where('id_magang', $id)->firstOrFail();
        $intern->status = 'Diterima';
        $intern->save();

        // Ambil nama departemen berdasarkan departemen_id
        $departemen = Departemen::find($intern->departemen_id);
        $departemenName = $departemen ? $departemen->nama_departemen : 'Departemen Tidak Ditemukan';

        // Kirim notifikasi ke Formspree atau email
        $response = Http::post('https://formspree.io/f/xgvojgdb', [
            'id_magang' => $intern->id_magang,
            'nama' => $intern->nama,
            'status' => 'Diterima',
            'message' => "Selamat, {$intern->nama} sudah diterima di PT. BF di departemen {$departemenName}",
            'subject' => 'Pendaftaran Magang Diterima',
        ]);

        // Cek apakah pengiriman ke Formspree berhasil
        if ($response->successful()) {
            return redirect()->route('admin.internship.detail', $id)
                ->with('success', 'Anak magang telah diterima.');
        } else {
            return redirect()->route('admin.internship.detail', $id)
                ->with('error', 'Terjadi kesalahan dalam pengiriman notifikasi.');
        }
    }

    // Method untuk menolak anak magang
    public function RejectIntern(Request $request, $id)
    {
        $intern = Internship::where('id_magang', $id)->firstOrFail();
        $intern->status = 'Ditolak';
        $intern->save();

        // Kirim notifikasi untuk status ditolak
        $response = Http::post('https://formspree.io/f/xgvojgdb', [
            'id_magang' => $intern->id_magang,
            'nama' => $intern->nama,
            'status' => 'Ditolak',
            'message' => "Sayangnya, {$intern->nama} tidak diterima di PT. BF. Terima kasih atas partisipasinya.",
            'subject' => 'Pendaftaran Magang Ditolak',
        ]);

        // Cek apakah pengiriman ke Formspree berhasil
        if ($response->successful()) {
            return redirect()->route('admin.internship.detail', $id)
                ->with('success', 'Anak magang telah ditolak.');
        } else {
            return redirect()->route('admin.internship.detail', $id)
                ->with('error', 'Terjadi kesalahan dalam pengiriman notifikasi.');
        }
    }
}
