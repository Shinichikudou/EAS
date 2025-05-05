<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <a href="" class="nav-link"><i class='bx bxs-bell icon'></i><span class="badge">5</span></a>
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
            <h1 class="title">Report Data Internship</h1>
            <ul class="breadcrumbs">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="divider">/</li>
                <li><a href="" class="active">Report Data Internship</a></li>
            </ul>

            {{-- Button cetak --}}
            <div style="margin: 1rem 0;">
                <button onclick="printPDF()" style="background-color: #007BFF; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
                    Cetak PDF
                </button>
            </div>

            {{-- Tabel --}}
            <div class="table-container" id="print-area">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Magang</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $index => $attendance)
                            <tr>
                                <td>{{ $attendances->firstItem() + $index }}</td>
                                <td>{{ $attendance->internship->id_magang ?? '-' }}</td>
                                <td>{{ $attendance->internship->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d-m-Y') }}</td>
                                <td>{{ $attendance->check_in ?? '-' }}</td>
                                <td>{{ $attendance->check_out ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Belum ada data absensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>

        {{-- Pagination --}}
        <div class="pagination-container">
            <ul class="pagination">
                <li class="prev {{ $attendances->onFirstPage() ? 'disabled' : '' }}">
                    <a href="{{ $attendances->onFirstPage() ? '#' : $attendances->previousPageUrl() }}">« Previous</a>
                </li>

                @for ($i = 1; $i <= $attendances->lastPage(); $i++)
                    <li class="page {{ $attendances->currentPage() == $i ? 'active' : '' }}">
                        <a href="{{ $attendances->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                <li class="next {{ $attendances->hasMorePages() ? '' : 'disabled' }}">
                    <a href="{{ $attendances->hasMorePages() ? $attendances->nextPageUrl() : '#' }}">Next »</a>
                </li>
            </ul>
        </div>
    </section>

    {{-- JS Script --}}
    <script src="{{asset('js/data.js')}}"></script>
    <script src="{{asset('js/report-seacrch.js')}}"></script>

    {{-- HTML2PDF CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function printPDF() {
            const element = document.getElementById("print-area");

            const today = new Date();
            const formattedDate = today.toLocaleDateString('id-ID', {
                day: '2-digit', month: '2-digit', year: 'numeric'
            }).replace(/\//g, '-');

            const filename = `report-${formattedDate}.pdf`;

            const opt = {
                margin:       0.5,
                filename:     filename,
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>
</html>
