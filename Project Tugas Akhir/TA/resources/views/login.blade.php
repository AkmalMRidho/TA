<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Matriks Kompetensi Dosen & Tenaga Kependidikan TI</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet"> <!-- Menambahkan Google Font Roboto -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.23/dist/sweetalert2.min.css" rel="stylesheet"> <!-- Menambahkan SweetAlert CSS -->

    <style>
        body {
            background-color: #342682;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .login-container {
            background-color: white;
            border: none;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px; /* Mengatur jarak antara kedua logo */
            margin-bottom: 20px;
        }

        .logo-container img {
            width: 70px;
        }

        .login-container h3 {
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .login-container h4 {
            font-family: 'Roboto', sans-serif; /* Menggunakan font Roboto */
            font-weight: 700; /* Membuat teks lebih tebal */
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .login-container hr {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .login-container form {
            margin-top: 20px;
        }

        .login-container button {
            margin-top: 20px;
            background-color: #007bff;
            border: none;
            color: white;
        }
        
        .login-container button:hover {
            background-color: #0056b3;
        }

        .login-container p {
            margin-top: 20px;
        }

        .input-group-addon {
            cursor: pointer;
        }

        .form-group {
            text-align: left;
        }

        .form-group label {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="col-md-4 col-md-offset-4 login-container">
            <div class="logo-container">
                <img src="/images/POLNEP.png" alt="Logo">
                <img src="/images/ELEKTRO.jpg" alt="Logo">
            </div>
            <h4>MATRIKS KOMPETENSI DOSEN & TENAGA KEPENDIDIKAN</h4>
            <hr>
            @if(session('error'))
            <div class="alert alert-danger">
                <b>Opps!</b> {{session('error')}}
            </div>
            @endif
            <form action="{{ route('actionlogin') }}" method="post">
                @csrf
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" required="" id="passwordInput">
                        <span class="input-group-addon" id="showPassword" onclick="togglePassword()">
                            <i class="glyphicon glyphicon-eye-open"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
                <hr>
                <p class="text-center"><a href="#" onclick="forgotPassword()">Lupa Password?</a></p>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Menambahkan SweetAlert JS -->
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("passwordInput");
            var showPasswordIcon = document.getElementById("showPassword");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                showPasswordIcon.innerHTML = '<i class="glyphicon glyphicon-eye-close"></i>';
            } else {
                passwordInput.type = "password";
                showPasswordIcon.innerHTML = '<i class="glyphicon glyphicon-eye-open"></i>';
            }
        }

        function forgotPassword() {
            Swal.fire({
                title: 'Lupa Password?',
                text: 'Silahkan menghubungi Quality Assurance untuk memperbarui password anda!',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
    </script>
</body>
</html>
