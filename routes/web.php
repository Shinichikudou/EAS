<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\SecurityController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Arahkan root (/) langsung ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes

Route::middleware(['auth', 'role:admin_sistem'])->group(function () {
    Route::get('/admin/dashboard', function () {
        $today = Carbon::today();

        $totalVisitToday = DB::table('attendances')
            ->whereDate('created_at', $today)
            ->count();

        $totalInternToday = DB::table('internships')
            ->where('status', 'Diterima')
            ->whereDate('created_at', $today)
            ->count();

        // Ambil jam kunjungan hari ini
        $visitByHour = DB::table('attendances')
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as total'))
            ->whereDate('created_at', $today)
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->orderBy('hour')
            ->get();

            // Ambil data anak magang per departemen
$internByDept = DB::table('internships')
->join('departemens', 'internships.departemen_id', '=', 'departemens.id_departemen')  // Join dengan tabel departemens
->select('departemens.nama_departemen', DB::raw('COUNT(*) as total'))
->where('internships.status', 'Diterima')
->groupBy('departemens.nama_departemen')  // Kelompokkan berdasarkan nama departemen
->get();

// Siapkan data untuk chart
$deptLabels = $internByDept->pluck('nama_departemen');  // Ambil nama departemen
$deptData = $internByDept->pluck('total');  // Ambil jumlah anak magang per departemen

        // Siapkan data chart
        $hours = [];
        $values = [];

        for ($i = 0; $i < 24; $i++) {
            $label = sprintf('%02d:00', $i);
            $hours[$label] = 0;
        }

        foreach ($visitByHour as $row) {
            $label = sprintf('%02d:00', $row->hour);
            $hours[$label] = $row->total;
        }

        $chartLabels = array_keys($hours);
        $chartData = array_values($hours);

        return view('admin.dashboard', compact('totalVisitToday', 'totalInternToday', 'chartLabels', 'chartData', 'internByDept', 'deptLabels', 'deptData'));
    })->name('admin.dashboard');
});
// Security routes
Route::middleware(['auth', 'role:security'])->group(function () {
    Route::get('/security/dashboard', function () {
        return view('security.dashboard');  // Tampilkan dashboard security
    })->name('security.dashboard');
});

// Departemen routes
Route::get('/departemen/dashboard',[DepartemenController::class, 'index'])->name('departemen.dashboard');
Route::get('/departemen/create', [DepartemenController::class, 'create'])->name('departemen.create');
Route::post('/departemen/store', [DepartemenController::class, 'store'])->name('departemen.store');
Route::get('/departemen/{id}/edit/', [DepartemenController::class, 'edit'])->name('departemen.edit');
Route::put('/departemen/update/{id}', [DepartemenController::class, 'update'])->name('departemen.update');
Route::delete('/departemen/delete/{id}', [DepartemenController::class, 'destroy'])->name('departemen.destroy');

// Internship routes
Route::get('/internship/splash', [InternshipController::class, 'splash'])->name('internship.splash');
Route::get('/internship/register', [InternshipController::class, 'register'])->name('internship.register');
Route::post('/internship/store', [InternshipController::class, 'store'])->name('internship.store');

// Internship Page routes
Route::get('/internship/page', [AdminController::class, 'intern'])->name('admin.internship');
Route::get('/admin/detail/{id}', [AdminController::class, 'details'])->name('admin.internship.detail');
Route::post('/admin/accept-intern/{id}', [AdminController::class, 'AcceptIntern'])->name('accept-intern');
Route::post('/admin/reject-intern/{id}', [AdminController::class, 'RejectIntern'])->name('reject-intern');

// Security Scan routes
Route::post('/get-intern', [SecurityController::class, 'getInternData']);
Route::post('/check-in', [SecurityController::class, 'checkIn']);
Route::post('/check-out', [SecurityController::class, 'checkOut']);

// Report routes
Route::get('/report-attendance', [SecurityController::class, 'showAttendance'])->name('attendance.report');
