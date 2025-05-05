<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Departemen</title>
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
                    {{-- <li><a href="{{route('admin-sistem.internship')}}">Anak Magang</a></li> --}}
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
                    <li><a href="">Anak Magang</a></li>
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
            <h1 class="title">Form Departemen</h1>
            <ul class="breadcrumbs">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="divider">/</li>
                <li><a href="{{route('departemen.dashboard')}}">Data Departemen</a></li>
                <li class="divider">/</li>
                <li><a href="" class="active">Edit Data Departemen</a></li>
            </ul>
            <div class="container-form">
                <div class="form-card">
                    <h2 class="form-title">Edit Departemen</h2>

                    <!-- Menampilkan Notifikasi Sukses -->
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

                    <!-- Menampilkan Error Validasi -->
                     @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                 <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('departemen.update', $departemen->id_departemen) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama_departemen">Nama Departemen</label>
                            <input type="text" name="nama_departemen" class="form-control" value="{{ old('nama_departemen', $departemen->nama_departemen) }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('departemen.dashboard') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </main>
    </section>
    {{-- Content End --}}
    <script src="{{asset('js/data.js')}}"></script>
</body>
</html>
