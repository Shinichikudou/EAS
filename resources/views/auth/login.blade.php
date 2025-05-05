<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Employee Attendance System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('storage/foto/bf.png') }}" alt="Biofarma Logo" class="logo">
            <h2 class="title">
                <span class="employee">EMPLOYEE</span>
                <span class="attendance">ATTENDANCE</span>
                <span class="system">SYSTEM</span>
            </h2>
        </div>

        <!-- Content Wrapper -->
        <div class="content">
            <!-- Login Box -->
            <div class="login-box">
                <h2>Login</h2>

                <!-- Display errors -->
                @if ($errors->any())
                    <div class="alert alert-danger" style="margin-bottom: 15px;">
                        @foreach ($errors->all() as $error)
                            <p style="margin: 0;">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="options">
                        <label><input type="checkbox" name="remember"> Remember Password</label>
                        <a href="#">Forgot Password?</a>
                    </div>
                    <button type="submit" class="login-btn">Login</button>
                </form>

                <!-- Link or Button to Internship Splash Page -->
                <div class="login-footer">
                    <p>You are a Internship Student? <a href="{{ route('internship.splash') }}">Go to Internship</a></p>
                </div>
            </div>

            <!-- Illustration -->
            <div class="illustration">
                <img src="{{ asset('storage/foto/Calendar.png') }}" alt="Calendar Illustration">
            </div>
        </div>
    </div>
</body>
</html>
