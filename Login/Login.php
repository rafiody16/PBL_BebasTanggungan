<?php
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0
header("Expires: 0"); // Prohibits caching

if (isset($_SESSION['Username'])) {
  switch ($_SESSION['Role_ID']) {
    case 1:
        header("Location: ../index.php");
        break;
    case 2:
        header("Location: ../index.php");
        break;
    case 3:
        header("Location: ../index.php");
        break;
    case 4:
        header("Location: ../index.php");
        break;
    case 5:
        header("Location: ../index.php");
        break;
    case 6:
        header("Location: ../index.php");
        break;
    case 7:
        header("Location: ../index.php");
        break;
    case 8:
        header("Location: ../User/mahasiswa/dashboardMHS.php");
        break;
  }

  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - BeTaTI</title>
    <link
      rel="shortcut icon"
      href="../assets/img/logoJti.png"
      type="image/x-icon"
    />
    <link
      rel="shortcut icon"
      href="../assets/img/logoJti.png"
      type="image/png"
    />
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css" />
    <link
      rel="stylesheet"
      crossorigin
      href="../assets/compiled/css/app-dark.css"
    />
    <link rel="stylesheet" crossorigin href="../assets/compiled/css/auth.css" />
  </head>

  <body>
    <script src="../assets/static/js/initTheme.js"></script>
    <div id="auth">
      <div class="row h-100">
        <div class="col-lg-5 col-12">
          <div id="auth-left">
            <div class="auth-logo">
            
              <div class="logo" style="font-weight: bold; font-size:25px">
                <img src="../assets/img/logoBetati.png"><br>
                <!-- SISTEM BEBAS TANGGUNGAN JURUSAN TEKNOLOGI INFORMASI -->
              </div>
            </div>
            <h1 class="auth-title">Log in</h1>
            <p class="auth-subtitle mb-5">
              Masukkan username dan password untuk login.
            </p>

            <form action="ProsesLogin.php" method="POST">
              <div class="form-group position-relative has-icon-left mb-4">
                <input
                  type="text"
                  class="form-control form-control-xl"
                  name="Username"
                  placeholder="Username"
                />
                <div class="form-control-icon">
                  <i class="bi bi-person"></i>
                </div>
              </div>
              <div class="form-group position-relative has-icon-left mb-4">
                <input
                  type="password"
                  class="form-control form-control-xl"
                  name="Password"
                  placeholder="Password"
                />
                <div class="form-control-icon">
                  <i class="bi bi-shield-lock"></i>
                </div>
              </div>
              <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" name="login">
                Log in
              </button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
              <p>
                <a class="font-bold" href="auth-forgot-password.html"
                  >Lupa password?</a
                >.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
          <div id="auth-right">
            <img alt="Polinema" height="500" src="../assets/img/gedungjti.jpeg" style="width: 100%; height: 100%; object-fit: cover;" width="400"/>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
