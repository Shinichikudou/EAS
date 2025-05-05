<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Internship</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
                    <li><a href="#">Anak Magang</a></li>
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
            <a href="#" class="nav-link">
                <i class='bx bxs-bell icon'></i>
                <span class="badge">5</span>
            </a>
            <span class="divider"></span>
            <div class="profile">
                <img src="{{ asset('storage/foto/cuy.jpeg') }}" alt="">
                <ul class="profile-link">
                    <li><a href="#"><i class='bx bx-user icon'></i>Profile</a></li>
                    <li><a href="#"><i class='bx bxs-cog'></i>Setting</a></li>
                    <li><a href="#"><i class='bx bxs-log-out-circle icon'></i>Logout</a></li>
                </ul>
            </div>
        </nav>

        <main>
            <h1 class="title">Detail Data Internship</h1>
            <ul class="breadcrumbs">
                <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="divider">/</li>
                <li><a href="{{ route('admin.internship') }}">Data Internship</a></li>
                <li class="divider">/</li>
                <li><a href="#" class="active">Detail Data Internship</a></li>
            </ul>

            <div class="card">
                <div class="profile-photo">
                    <img src="{{ asset('storage/' . $interns->pas_foto) }}" alt="Pas Foto">
                </div>
                <div class="profile-details">
                    <table class="table">
                        <tr><th>ID Magang</th><td>: {{ $interns->id_magang }}</td></tr>
                        <tr><th>Nama</th><td>: {{ $interns->nama }}</td></tr>
                        <tr><th>No Telepon</th><td>: {{ $interns->no_telepon }}</td></tr>
                        <tr><th>Email</th><td>: {{ $interns->email }}</td></tr>
                        <tr><th>Instansi</th><td>: {{ $interns->instansi }}</td></tr>
                        <tr><th>Departemen</th><td>: {{ $interns->departemen->nama_departemen }}</td></tr>
                        <tr><th>Area Kerja</th><td>: {{ $interns->area_kerja }}</td></tr>
                        <tr><th>Tanggal Mulai</th><td>: {{ \Carbon\Carbon::parse($interns->tanggal_mulai)->format('d M Y') }}</td></tr>
                        <tr><th>Tanggal Berakhir</th><td>: {{ \Carbon\Carbon::parse($interns->tanggal_berakhir)->format('d M Y') }}</td></tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge
                                    {{ $interns->status == 'Pending' ? 'bg-warning' :
                                       ($interns->status == 'Ditolak' ? 'bg-danger' : 'bg-success') }}">
                                    {{ ucfirst($interns->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Surat Rekomendasi</th>
                            <td>: @if ($interns->surat_rekomendasi)
                                    <a href="{{ asset('storage/' . $interns->surat_rekomendasi) }}" target="_blank" class="btn-secondary">Lihat Surat</a>
                                 @else
                                    <span class="text-muted">Tidak Ada</span>
                                 @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="action-buttons">
                @if ($interns->status == 'Pending')
                    <form action="{{ route('accept-intern', $interns->id_magang) }}" method="POST" style="display:inline-block;">
                        @csrf
                        <input type="hidden" name="email" value="{{ $interns->email }}">
                        <input type="hidden" name="nama" value="{{ $interns->nama }}">
                        <button type="submit" class="btn btn-success">Terima</button>
                    </form>

                    <form action="{{ route('reject-intern', $interns->id_magang) }}" method="POST" style="display:inline-block;">
                        @csrf
                        <input type="hidden" name="email" value="{{ $interns->email }}">
                        <input type="hidden" name="nama" value="{{ $interns->nama }}">
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </form>
                @endif

                <a href="{{ route('admin.internship') }}" class="btn btn-info">Kembali</a>
            </div>

            {{-- Cetak ID Card jika status bukan Ditolak --}}
            @if ($interns->status !== 'Ditolak')
                <div class="text-center mt-3">
                    <button onclick="generatePDF()" class="btn btn-primary">Cetak ID Card (PDF)</button>
                </div>

                {{-- ID Card Section --}}
<div class="id-card mt-4">
    <img src="{{ asset('storage/foto/bf.png') }}" class="logo" alt="Logo Perusahaan">

    <div class="photo-container">
        <img src="{{ asset('storage/' . $interns->pas_foto) }}" alt="Pas Foto">
    </div>

    <div class="details">
        <h2>{{ $interns->nama }}</h2>
        <p class="id">ID: <strong>{{ $interns->id_magang }}</strong></p>
        <p>Departemen: <strong>{{ $interns->departemen->nama_departemen }}</strong></p>
        <p>Mulai: <strong>{{ \Carbon\Carbon::parse($interns->tanggal_mulai)->format('d M Y') }}</strong></p>
        <p>Berakhir: <strong>{{ \Carbon\Carbon::parse($interns->tanggal_berakhir)->format('d M Y') }}</strong></p>
    </div>

    <div class="qr-container">
        <canvas id="qr-code" width="150" height="150"></canvas>
    </div>
</div>


                @else

                <div class="alert alert-warning text-center mt-4">
                    ID Card tidak tersedia karena status magang <strong>Ditolak</strong>.
                </div>
            @endif
        </main>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const idMagang = "{{ $interns->id_magang }}";

    if (idMagang) {
        const qr = new QRious({
            element: document.getElementById('qr-code'),
            size: 250,
            level: 'H',
            value: JSON.stringify({ id_magang: idMagang }) // <-- FORMAT JSON
        });
    } else {
        console.error("ID Magang tidak tersedia!");
    }
});

        function generatePDF() {
            const { jsPDF } = window.jspdf;
            const idCard = document.querySelector(".id-card");

            html2canvas(idCard, {
                scale: 3, // DINAIIKIN supaya tajam saat render PDF
                useCORS: true
            }).then(canvas => {
                const imgData = canvas.toDataURL("image/png");

                const pdf = new jsPDF({
                    orientation: "portrait",
                    unit: "px",
                    format: [400, 600] // Sama persis ukuran div ID Card
                });

                pdf.addImage(imgData, "PNG", 0, 0, 400, 600);
                pdf.save("ID_Card_{{ $interns->id_magang }}.pdf");
            });
        }
    </script>

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="{{ asset('js/data.js') }}"></script>
</body>
</html>
