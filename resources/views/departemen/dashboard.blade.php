<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Departemen</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="{{asset('css/departemen.css')}}">
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
            <a href="" class="nav-link">
                <i class='bx bxs-bell icon'></i>
                <span class="badge">5</span>
            </a>
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
            <h1 class="title">Data Departemen</h1>
            <ul class="breadcrumbs">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="divider">/</li>
                <li><a href="" class="active">Data Departemen</a></li>
            </ul>
            <div class="action-bar" style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
                <a href="{{ route('departemen.create') }}" class="btn btn-primary">Tambah</a>
            </div>

            <div class="table-container">
                @if(session('success'))
                    <div class="alert alert-success" id="success-message">
                        {{ session('success') }}
                    </div>
                    <script>
                        setTimeout(() => {
                            document.getElementById('success-message').style.display = 'none';
                        }, 3000);
                    </script>
                @endif

                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Departemen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departemens as $index => $departemen)
                        <tr>
                            <td>{{ $departemens->firstItem() + $index }}</td>
                            <td>{{ $departemen->nama_departemen }}</td>
                            <td>
                                <a href="{{ route('departemen.edit', ['id' => $departemen->id_departemen]) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('departemen.destroy', ['id' => $departemen->id_departemen]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus departemen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3">Tidak ada data departemen.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>

        <div class="pagination-container">
            <ul class="pagination">
                <!-- Tombol Previous -->
                <li class="prev {{ $departemens->onFirstPage() ? 'disabled' : '' }}">
                    <a href="{{ $departemens->onFirstPage() ? '#' : $departemens->previousPageUrl() }}">« Previous</a>
                </li>

                <!-- Nomor Halaman -->
                @for ($i = 1; $i <= $departemens->lastPage(); $i++)
                    <li class="page {{ $departemens->currentPage() == $i ? 'active' : '' }}">
                        <a href="{{ $departemens->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                <!-- Tombol Next -->
                <li class="next {{ $departemens->hasMorePages() ? '' : 'disabled' }}">
                    <a href="{{ $departemens->hasMorePages() ? $departemens->nextPageUrl() : '#' }}">Next »</a>
                </li>
            </ul>
        </div>
    </section>
    {{-- Content End --}}
    <script src="{{asset('js/data.js')}}"></script>
    <script src="{{asset('js/departemen-search.js')}}"></script>
</body>
</html>
