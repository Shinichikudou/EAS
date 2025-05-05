<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Internship</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="{{asset('css/data.css')}}">
</head>
<body>
    {{-- Sidebar --}}
    <section id='sidebar'>
        <a href="#" class="brand"><i class='bx bxs-wink-smile icon'></i>Employee Attendance System</a>
        <ul class="side-menu">
            <li><a href="{{route('admin.dashboard')}}" class="active"><i class='bx bxs-dashboard icon'></i>Dashboard</a></li>
            <li class="divider" data-text="Main">Main</li>
            <li>
                <a href="#"><i class='bx bxs-user-badge icon'></i>Data Kunjungan<i class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="{{route('admin.internship')}}">Anak Magang</a></li>
                </ul>
            </li>
            <li class="divider" data-text="Reports">Data</li>
            <li>
                <a href="#"><i class='bx bx-store-alt icon'></i>Departemen<i class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="{{route('departemen.dashboard')}}">List Departemen</a></li>
                </ul>
            </li>
            <li class="divider" data-text="Reports">Other</li>
            <li>
                <a href="#"><i class='bx bxs-report icon'></i>Reports<i class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="{{route('attendance.report')}}">Anak Magang</a></li>
                    <li><a href="#">Karyawan</a></li>
                    <li><a href="#">Vendor</a></li>
                </ul>
            </li>
        </ul>
    </section>
    {{-- Sidebar End --}}

    {{-- Content --}}
    <section id="content">
        <nav>
            <i class='bx bx-menu toggle-sidebar'></i>
            <form action="">
                <div class="form-group">
                    <input type="text" placeholder="Search...">
                    <i class='bx bx-search icon'></i>
                </div>
            </form>
            {{-- <div class="notification-container"> --}}
                <a href="" class="nav-link">
                    <i class='bx bxs-bell icon'></i>
                    <span class="badge"> {{$unreadCount}} </span>
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
                <img src="{{asset('storage/foto/cuy.jpeg')}}" alt="">
                <ul class="profile-link">
                    <li><a href=""><i class='bx bx-user icon'></i>Profile</a></li>
                    <li><a href=""><i class='bx bxs-cog'></i>Setting</a></li>
                    <li><a href=""><i class='bx bxs-log-out-circle icon'></i>Logout</a></li>
                </ul>
            </div>
        </nav>

        <main>
            <h1 class="title">Data Internship</h1>
            <ul class="breadcrumbs">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="divider">/</li>
                <li><a href="" class="active">Data Internship</a></li>
            </ul>

            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Departemen</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($intern as $index => $interns)
                            <tr data-id="{{ $interns->id_magang }}">
                                <td>{{ $intern->firstItem() + $index }}</td>
                                <td>{{ $interns->nama }}</td>
                                <td>{{ $interns->departemen->nama_departemen ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($interns->tanggal_mulai)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($interns->tanggal_berakhir)->format('d-m-Y') }}</td>
                                <td>
                                    <span class="status {{ strtolower($interns->status) }}">
                                        {{ $interns->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Belum ada data magang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>

        <div class="pagination-container">
            <ul class="pagination">
                <li class="prev {{ $intern->onFirstPage() ? 'disabled' : '' }}">
                    <a href="{{ $intern->onFirstPage() ? '#' : $intern->previousPageUrl() }}">« Previous</a>
                </li>

                @for ($i = 1; $i <= $intern->lastPage(); $i++)
                    <li class="page {{ $intern->currentPage() == $i ? 'active' : '' }}">
                        <a href="{{ $intern->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                <li class="next {{ $intern->hasMorePages() ? '' : 'disabled' }}">
                    <a href="{{ $intern->hasMorePages() ? $intern->nextPageUrl() : '#' }}">Next »</a>
                </li>
            </ul>
        </div>
    </section>
    {{-- Content End --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const rows = document.querySelectorAll(".modern-table tbody tr");

            rows.forEach(row => {
                row.addEventListener("click", function () {
                    // Ambil ID magang dari atribut data-id
                    const idMagang = this.getAttribute("data-id");

                    // Arahkan ke halaman detail dengan ID magang yang sesuai
                    if (idMagang) {
                        window.location.href = `/admin/detail/${idMagang}`;
                    }
                });
            });
        });
    </script>
    <script src="{{asset('js/data.js')}}"></script>
    <script src="{{asset('js/internship-search.js')}}"></script>
</body>
</html>
