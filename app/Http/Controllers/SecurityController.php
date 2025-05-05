<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Attendance; // Ganti dari Security ke Attendance
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    public function showAttendance(){
        $attendances = Attendance::with('internship')
        ->orderBy('date', 'asc')       // Urutkan berdasarkan tanggal
        ->orderBy('check_in', 'asc')   // Lalu check-in
        ->orderBy('check_out', 'asc')  // Lalu check-out
        ->paginate(10);

        return view('attendance.report', compact('attendances'));
    }

    public function getInternData(Request $request)
{
    $intern = Internship::with('departemen')
        ->where('id_magang', $request->id_magang)
        ->first();

    if (!$intern) {
        return response()->json(['error' => 'Data magang tidak ditemukan'], 404);
    }

    if ($intern->status == 'Ditolak') {
        return response()->json(['error' => 'Status magang ditolak. Tidak dapat melakukan absensi.'], 403);
    }

    return response()->json([
        'id' => $intern->id,
        'id_magang' => $intern->id_magang,
        'nama' => $intern->nama,
        'departemen' => $intern->departemen->nama_departemen ?? '-',
        'foto' => asset('storage/' . $intern->pas_foto),
        ]);
    }
    public function checkIn(Request $request)
{
    try {
        $intern = Internship::where('id_magang', $request->id_magang)->first();
        if (!$intern) {
            return response()->json(['error' => 'Data magang tidak ditemukan'], 404);
        }

        if ($intern->status == 'Ditolak') {
            return response()->json(['error' => 'Status magang ditolak. Tidak dapat check-in.'], 403);
        }

        $today = now()->toDateString();

        $attendance = Attendance::where('internship_id', $intern->id)
            ->where('date', $today)
            ->first();

        if ($attendance && $attendance->check_in) {
            return response()->json(['error' => 'Anda sudah melakukan check-in hari ini.'], 400);
        }

        if (!$attendance) {
            Attendance::create([
                'internship_id' => $intern->id,
                'date' => $today,
                'check_in' => now()
            ]);
        } else {
            $attendance->update(['check_in' => now()]);
        }

        return response()->json(['message' => 'Check-in berhasil']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function checkOut(Request $request)
{
    try {
        $intern = Internship::where('id_magang', $request->id_magang)->first();
        if (!$intern) {
            return response()->json(['error' => 'Data magang tidak ditemukan'], 404);
        }

        if ($intern->status == 'Ditolak') {
            return response()->json(['error' => 'Status magang ditolak. Tidak dapat check-out.'], 403);
        }

        $today = now()->toDateString();

        $attendance = Attendance::where('internship_id', $intern->id)
            ->where('date', $today)
            ->first();

        if (!$attendance || !$attendance->check_in) {
            return response()->json(['error' => 'Belum melakukan check-in hari ini.'], 400);
        }

        if ($attendance->check_out) {
            return response()->json(['error' => 'Anda sudah melakukan check-out hari ini.'], 400);
        }

        $attendance->update(['check_out' => now()]);

        return response()->json(['message' => 'Check-out berhasil']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
