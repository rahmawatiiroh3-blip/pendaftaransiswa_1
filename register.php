<?php
require 'koneksi.php';

$pesan = "";
$status = "";

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Cek apakah username atau email sudah terdaftar
    $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
    
    if (mysqli_num_rows($cek_user) > 0) {
        $pesan = "Username atau email sudah digunakan!";
        $status = "error";
    } else {
        // Enkripsi password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Masukkan data ke database (pastikan nama tabel Anda 'users')
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password_hash')";
        
        if (mysqli_query($conn, $query)) {
            $pesan = "Registrasi berhasil! Silakan login.";
            $status = "success";
        } else {
            $pesan = "Registrasi gagal: " . mysqli_error($conn);
            $status = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            text-align: center;
        }
        .alert.success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .register {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }
        .register a {
            color: #007bff;
            text-decoration: none;
        }
        .register a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>Form Register</h2>
        
        <?php if (!empty($pesan)): ?>
            <div class="alert <?= $status; ?>">
                <?= $pesan; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="register">Daftar</button>
        </form>
        <div class="register">
        Sudah daftar? <a href="login.php">Login disini</a>
        </div>
    </div>
    

</body>
</html>