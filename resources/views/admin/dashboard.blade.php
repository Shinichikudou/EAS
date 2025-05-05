<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin Sistem</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/foto/bf.png') }}">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    {{-- Sidebar --}}
    <section id='sidebar'>
        <a href="#" class="brand"><i class='bx bxs-wink-smile icon'></i>Employee Attendance System</a>
        <ul class="side-menu">
            <li><a href="{{ route('admin.dashboard') }}" class="active"><i class='bx bxs-dashboard icon'></i>Dashboard</a></li>
            <li class="divider" data-text="Main">Main</li>
            <li>
                <a href="#"><i class='bx bxs-user-badge icon'></i>Data Kunjungan<i class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="{{ route('admin.internship') }}">Anak Magang</a></li>
                </ul>
            </li>
            <li class="divider" data-text="Reports">Data</li>
            <li>
                <a href="#"><i class='bx bx-store-alt icon'></i>Departemen<i class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="{{ route('departemen.dashboard') }}">List Departemen</a></li>
                </ul>
            </li>
            <li class="divider" data-text="Reports">Other</li>
            <li>
                <a href="#"><i class='bx bxs-report icon'></i>Reports<i class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="{{ route('attendance.report') }}">Anak Magang</a></li>
                    <li><a href="#">Karyawan</a></li>
                    <li><a href="#">Vendor</a></li>
                </ul>
            </li>
        </ul>
    </section>

    {{-- Content --}}
    <section id="content">
        {{-- Navbar --}}
        <nav>
            <i class='bx bx-menu toggle-sidebar'></i>
            <form>
                {{-- <div class="form-group">
                    <input type="text" placeholder="Search...">
                    <i class='bx bx-search icon'></i>
                </div> --}}
            </form>
            {{-- <div class="notification-container"> --}}
                <a href="#" class="nav-link" id="notif-icon">
                    <i class='bx bxs-bell icon'></i>
                    <span class="badge">8</span>
                </a>

                {{-- <ul class="dropdown-notif">
                    @foreach ($notifications as $notif)
                        <li class="{{ $notif->is_read ? '' : 'fw-bold' }}" style="padding: 5px 10px; border-bottom: 1px solid #ddd;">
                            <strong>{{ $notif->title }}</strong><br>
                            <small>{{ $notif->message }}</small>
                        </li>
                    @endforeach
                    @if(count($notifications) == 0)
                        <li style="padding: 5px 10px;">Tidak ada notifikasi.</li>
                    @endif
                </ul> --}}
            {{-- </div> --}}

            <span class="divider"></span>
            <div class="profile">
                <img src="{{ asset('storage/foto/cuy.jpeg') }}" alt="User Profile">
                <ul class="profile-link">
                    <li><a href="#"><i class='bx bx-user icon'></i>Profile</a></li>
                    <li><a href="#"><i class='bx bxs-cog'></i>Setting</a></li>
                    <li>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class='bx bxs-log-out-circle icon'></i>Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        {{-- Main --}}
        <main>
            <h1 class="title">Dashboard</h1>
            <ul class="breadcrumbs">
                <li><a href="#">Home</a></li>
                <li class="divider">/</li>
                <li><a href="#" class="active">Dashboard</a></li>
            </ul>

            @php
                $visitTarget = 100; // target kunjungan harian
                $internTarget = 100; // target anak magang harian

                $visitPercent = min(100, round(($totalVisitToday / $visitTarget) * 100));
                $internPercent = min(100, round(($totalInternToday / $internTarget) * 100));
            @endphp
            <div class="info-data">
                <div class="card">
                    <div class="head">
                        <div>
                            <h2>{{ $totalVisitToday }}</h2>
                            <p>Total Kunjungan</p>
                        </div>
                        <i class='bx bxs-user-account icon'></i>
                    </div>
                    <span class="progress" data-value="{{ $visitPercent }}%"></span>
                    <span class="label">{{ $visitPercent }}%</span>
                </div>

                <div class="card">
                    <div class="head">
                        <div>
                            <h2>{{ $totalInternToday }}</h2>
                            <p>Total Anak Magang</p>
                        </div>
                        <i class='bx bxs-user-badge icon down'></i>
                    </div>
                    <span class="progress" data-value="{{ $internPercent }}%"></span>
                    <span class="label">{{ $internPercent }}%</span>
                </div>

                <div class="card">
                    <div class="head">
                        <div>
                            <h2>0</h2>
                            <p>Total Karyawan</p>
                        </div>
                        <i class='bx bxs-user-badge icon up'></i>
                    </div>
                    <span class="progress" data-value="90%"></span>
                    <span class="label">90%</span>
                </div>

                <div class="card">
                    <div class="head">
                        <div>
                            <h2>0</h2>
                            <p>Total Vendor</p>
                        </div>
                        <i class='bx bxs-user-badge icon center'></i>
                    </div>
                    <span class="progress" data-value="50%"></span>
                    <span class="label">50%</span>
                </div>
            </div>

            <div class="data">
                <div class="content-data">
                    <div class="head">
                        <h3>Kunjungan</h3>
                        <div class="menu">
                            <i class='bx bx-dots-horizontal-rounded icon'></i>
                            <ul class="menu-link">
                                <li><a href="">Edit</a></li>
                                <li><a href="">Save</a></li>
                                <li><a href="">Remove</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="chart">
                        <div id="chart"></div>
                    </div>
                </div>

                <div class="content-data">
                    <div class="head">
                        <h3>Jumlah Anak Magang per Departemen</h3> <!-- Change the title if you want -->
                        <div class="menu">
                            <i class='bx bx-dots-horizontal-rounded icon'></i>
                            <ul class="menu-link">
                                <li><a href="">Edit</a></li>
                                <li><a href="">Save</a></li>
                                <li><a href="">Remove</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Donut chart container -->
                    <div id="charts"></div>
                </div>
            </div>
        </main>
    </section>


    {{-- Inject data chart kunjungan berdasarkan jam --}}
    <script>
        const visitChartLabels = @json($chartLabels);
        const visitChartData = @json($chartData);
    </script>

    <script>
        const deptLabels = @json($deptLabels);
        const deptData = @json($deptData);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
