<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Attendance System</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/security.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <script src="https://kit.fontawesome.com/2bc062483e.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #intern-data-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            z-index: 999;
        }
        #intern-photo {
            width: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <img class="logo" src="{{ asset('storage/foto/bf.png') }}" alt="Logo">
        <div class="profile">
            <img src="{{ asset('storage/foto/cuy.jpeg') }}" alt="Profile">
            <ul class="profile-link">
                <li><a href="#"><i class='bx bx-user icon'></i> Profile</a></li>
                <li><a href="#"><i class='bx bxs-cog'></i> Setting</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display: flex; align-items: center;">
                        @csrf
                        <button type="submit" style="display: flex; align-items: center; gap: 10px; background: none; border: none; color: #333; font-size: 14px; padding: 8px 15px; border-radius: 6px;">
                            <i class='bx bxs-log-out-circle icon'></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Content -->
    <div class="container mt-5">
        <h2 class="title text-center">Employee Attendance System</h2>
        <p class="text-center">Selamat Datang, Security! Silakan lakukan pemindaian keamanan di lokasi.</p>

        <div class="scan-image my-4 text-center" id="start-scan" style="cursor: pointer;">
            <img src="{{ asset('storage/foto/scan.svg') }}" alt="Scan">
            <p>Klik gambar untuk scan QR</p>
        </div>

        <div class="input-group justify-content-center mb-4">
            <input type="text" id="employee-id" placeholder="Enter Employee ID" class="form-control w-auto">
            <button class="scan-btn btn btn-primary" id="manual-input-btn"><i class="fa-solid fa-qrcode"></i></button>
        </div>

        <div id="reader" style="width: 300px; margin: auto; display: none;"></div>
        <div id="scan-result" class="text-center mt-3"></div>
    </div>

    <!-- Popup Data Intern -->
    <div id="intern-data-popup" style="display: none;">
        <div class="popup-content text-center">
            <img id="intern-photo" src="" alt="Foto Profil">
            <p><strong>ID Magang:</strong> <span id="intern-id"></span></p>
            <p><strong>Nama:</strong> <span id="intern-name"></span></p>
            <p><strong>Departemen:</strong> <span id="intern-department"></span></p>
            <div class="btn-group mt-3">
                <button id="check-in-btn" class="btn btn-success">Check In</button>
                <button id="check-out-btn" class="btn btn-warning">Check Out</button>
                <button id="close-popup-btn" class="btn btn-secondary">Close</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="{{ asset('js/scan.js') }}" defer></script>
</body>
</html>
