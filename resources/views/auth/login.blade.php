<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Menambahkan font-awesome untuk ikon mata -->
    <style>
        .input-group {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 20px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="image-section">
            <img src="{{ asset('assets/img/cafe2.jpg') }}" alt="Login Image">
        </div>

        <div class="form-section">
            <h2>Login</h2>
            <p>Input your email and password</p>

            @if ($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <div class="input-group">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <i style="color :#e5e7eb;" class="fas fa-eye-slash toggle-password" onclick="togglePassword()"></i> <!-- Ikon mata tertutup saat pertama kali -->
                </div>

                <button type="submit" class="btn-main">Login</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye'); // Ubah ikon jadi mata terbuka
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash'); // Ubah ikon jadi mata tertutup
            }
        }
    </script>
</body>

</html>
