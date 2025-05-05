<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Screen Internship</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/foto/bf.png')}}"> <!-- ✅ Tambahkan favicon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{asset('css/splash.css')}}">
</head>
<body>
    <div class="container">
        <div class="left">
            <div class="title">
                <span style="color: white;">EMPLOYEE</span>
                <span class="attendance">ATTENDANCE</span>
                <span style="color: white;">SYSTEM</span>
            </div>
            <img src="{{asset('storage/foto/OLC.png')}}" alt="OLC">
        </div>
        <div class="right">
            <img src="{{asset('storage/foto/bf.png')}}" alt="Bio Farma" class="logo">
            <h2>Welcome, Internship Student</h2>
            <p>We are thrilled to have you at Bio Farma</p>
            <p>Before getting started, please fill out your details through the button below:</p>
            <button onclick="window.location.href='{{ route('internship.register') }}'">Click Here</button>
            <a href="{{ route('login') }}" class="home-link">Go to Home Page</a>
        </div>
    </div>
</body>
</html>
