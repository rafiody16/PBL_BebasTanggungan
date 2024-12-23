<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ubah Password - BeTaTI</title>

    <link
      rel="shortcut icon"
      href="../../assets/img/logoJti.png"
      type="image/x-icon"
    />
    <link
      rel="shortcut icon"
      href="../../assets/img/logoJti.png"
      type="image/png"
    />

    <link
      rel="stylesheet"
      crossorigin
      href="./../../assets/compiled/css/app.css"
    />
    <link
      rel="stylesheet"
      crossorigin
      href="./../../assets/compiled/css/app-dark.css"
    />
  </head>

  <body>
    <script src="../../assets/static/js/initTheme.js"></script>
    <div id="app">
    <?php include('../../assets/sidebar/Sidebar.php'); ?>
      <div id="main">
        <header class="mb-3">
          <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
          </a>
        </header>

        <div class="page-heading">
          <div class="page-title">
            <div class="row">
              <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Keamanan Akun</h3>
                <p class="text-subtitle text-muted">
                  Anda bisa mengubah password Anda.
                </p>
              </div>
              <div class="col-12 col-md-6 order-md-2 order-first">
                <nav
                  aria-label="breadcrumb"
                  class="breadcrumb-header float-start float-lg-end"
                >
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                      <a href="dashboardMHS.php">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Keamanan
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
          <section class="section">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h5 class="card-title">Ubah Password</h5>
                  </div>
                  <div class="card-body">
                    <form action="ubah_password.php" method="post">
                      <div class="form-group my-2">
                        <label for="current_password" class="form-label"
                          >Password Saat ini</label
                        >
                        <input
                          type="password"
                          name="current_password"
                          id="current_password"
                          class="form-control"
                          placeholder="Masukkan password Saat ini"
                          value=""
                        />
                      </div>
                      <div class="form-group my-2">
                        <label for="password" class="form-label"
                          >Password Baru</label
                        >
                        <input
                          type="password"
                          name="password"
                          id="password"
                          class="form-control"
                          placeholder="Masukkan password baru"
                          value=""
                        />
                      </div>
                      <div class="form-group my-2">
                        <label for="confirm_password" class="form-label"
                          >Konfirmasi Password</label
                        >
                        <input
                          type="password"
                          name="confirm_password"
                          id="confirm_password"
                          class="form-control"
                          placeholder="Masukkan Konfirmasi password"
                          value=""
                        />

                        <br>
                      </div>

                      <div class="form-group my-2 d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary">
                          Simpan Perubahan
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

          </section>
        </div>

        <footer>
          <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
              <!-- <p>2024 &copy; BeTaTI</p> -->
              <p>2023 &copy; Mazer</p>
            </div>
            <div class="float-end">
              <!-- <p>
                Crafted with
                <span class="text-danger"
                  ><i class="bi bi-heart-fill icon-mid"></i
                ></span>
                by <a href="https://saugi.me">Kelompok 1</a>
              </p> -->
              <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
              by <a href="https://saugi.me">Saugi</a></p>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <script src="../../assets/static/js/components/dark.js"></script>
    <script src="../../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="../../assets/compiled/js/app.js"></script>

    <script>
      const checkbox = document.getElementById("iaggree");
      const buttonDeleteAccount = document.getElementById("btn-delete-account");
      checkbox.addEventListener("change", function () {
        const checked = checkbox.checked;
        if (checked) {
          buttonDeleteAccount.removeAttribute("disabled");
        } else {
          buttonDeleteAccount.setAttribute("disabled", true);
        }
      });
    </script>
  </body>
</html>
