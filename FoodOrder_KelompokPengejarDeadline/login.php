<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('location: internal.php');
}

// Membuat string CAPTCHA acak
$captcha = generateRandomString(6); 

// Simpan string CAPTCHA dalam sesi
$_SESSION['captcha'] = $captcha;

// Fungsi untuk menghasilkan string acak
function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $string;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>Login Page</title>
</head>
<body>

<?php
include_once 'navbar.php';
?>

    <!-- Main Container -->
    <form action="login_process.php" method="post">
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <!-- Login Container -->
            <div class="row border rounded-5 p-4 bg-white shadow box-area">
                <!-- Left Box -->
                <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
                    <div class="featured-image mb-2">
                        <img src="images/user1.png" class="img-fluid" style="width: 250px;">
                    </div>
                    <p class="text-white fs-3 text-center" style="font-family: 'Poppins', sans-serif; font-weight: 450;">Welcome to Login Page</p>
                </div>
                <!-- Right Box -->
                <div class="col-md-6 right-box">
                    <div class="row mx-auto p-2" style="width: 400px;">
                        <div class="header-text mb-4 text-center">
                            <p>Belum memiliki akun? <a href="register.php">Daftar</a></p>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" name="username" id="username" placeholder="Username">
                        </div>
                        <div class="input-group mb-1">
                            <input type="password" class="form-control form-control-lg bg-light fs-6" name="password" id="password" placeholder="Password">
                        </div>
                        <div class="input-group mb-3 pt-2">
                            <img src="captcha_image.php" alt="CAPTCHA" class="p-2"/>
                            <input type="text" class="form-control form-control-lg bg-light fs-6" name="captcha_input" id="captcha_input" placeholder="Verify Captcha">
                        </div>
                        <div class="input-group mb-3 pt-5">
                            <button type="submit" name="submit" class="btn btn-lg btn-primary w-100 fs-5">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');
            const captchaInput = document.getElementById('captcha_input');
            const loginForm = document.querySelector('form');

            loginForm.addEventListener('submit', function (event) {
                if (usernameInput.value.trim() === '' || passwordInput.value.trim() === '' || captchaInput.value.trim() === '') {
                    event.preventDefault(); // Prevent form submission
                    alert('Tolong isi semua field yang ada.');
                } else if (captchaInput.value !== '<?php echo $_SESSION['captcha']; ?>') {
                    event.preventDefault(); // Prevent form submission
                    alert('Verifikasi CAPTCHA gagal. Silahkan coba lagi!');
                }
            });
        });
    </script>

</body>
</html>