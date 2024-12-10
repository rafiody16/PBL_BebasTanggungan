<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $current_page = basename($_SERVER['PHP_SELF']);
    $submenu_pages = ['dashboardMHS.php', 'index.php', 'kaprodiPPLS.php', 'kaprodiTI.php', 'kaprodiSIB.php', 'dasborKajur.php'];

    include('Koneksi.php');
    $role = $_SESSION['Role_ID'];
?>

<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="dashboardMHS.php">
                        <img src="assets/img/logoBetati.png" alt="Logo" />
                    </a>
                </div>
                <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" viewBox="0 0 21 21">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
                        </g>
                    </svg>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer" />
                        <label class="form-check-label"></label>
                    </div>
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>
                <li class="sidebar-item <?php echo (in_array($current_page, $submenu_pages)) ? 'active' : ''; ?>">
                    <?php if ($role === 1) { ?>
                        <a href="index.php" class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Beranda</span>
                        </a>
                    <?php } else if ($role === 2) { ?>
                        <a href="User/kajur/dasborKajur.php" class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Beranda</span>
                        </a>
                    <?php } else if ($role === 3) { ?>
                        <a href="kaprodiTI.php" class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Beranda</span>
                        </a>
                    <?php } else if ($role === 4) { ?>
                        <a href="kaprodiSIB.php" class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Beranda</span>
                        </a>
                    <?php } else if ($role === 5) { ?>
                        <a href="kaprodiPPLS.php" class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Beranda</span>
                        </a>
                    <?php } else if ($role === 6) { ?>
                        <a href="verifikatorTA.php" class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Beranda</span>
                        </a>
                    <?php } else if ($role === 7) { ?>
                        <a href="verifikatorAdministrasi.php" class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Beranda</span>
                        </a>
                    <?php } else if ($role === 8) { ?>
                        <a href="User/mahasiswa/dashboardMHS.php" class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Beranda</span>
                        </a>
                    <?php } ?>
                </li>
                <?php if ($role === 8) { ?>
                    <li class="sidebar-item <?php echo ($current_page == 'FormBerkas.php') ? 'active' : ''; ?>">
                        <a href="Berkas/FormBerkas.php" class="sidebar-link">
                            <i class="bi bi-file-earmark-medical-fill"></i>
                            <span>Unggah Berkas</span>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($role === 1 || $role === 6) { ?>
                    <li class="sidebar-item <?php echo ($current_page == 'TabelTA.php') ? 'active' : ''; ?>">
                        <a href="Berkas/TabelTA.php" class="sidebar-link">
                            <i class="bi bi-folder-check"></i>
                            <span>Verifikas TA</span>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($role === 1 || $role === 7) { ?>
                    <li class="sidebar-item <?php echo ($current_page == 'TabelAdministrasi.php') ? 'active' : ''; ?>">
                        <a href="Berkas/TabelAdministrasi.php" class="sidebar-link">
                            <i class="bi bi-folder-check"></i>
                            <span>Verifikasi Administrasi</span>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($role === 1 || $role === 2 || $role === 3 || $role === 4 || $role === 5) { ?>
                    <li class="sidebar-item <?php echo ($current_page == 'TabelBerkas.php') ? 'active' : ''; ?>">
                        <a href="Berkas/TabelBerkas.php" class="sidebar-link">
                            <i class="bi bi-folder-check"></i>
                            <span>Verifikasi Berkas</span>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($role === 1 || $role === 2 || $role === 3 || $role === 4 || $role === 5) { ?>
                    <li class="sidebar-item has-sub">
                        <a href="#" class="sidebar-link">
                        <i class="bi bi-person-lines-fill"></i>
                        <span>Data Mahasiswa</span>
                        </a>

                        <ul class="submenu active">
                            <li class="submenu-item <?php echo ($current_page == 'FormMahasiswa.php') ? 'active' : ''; ?>">
                                <a href="User/FormMahasiswa.php" class="submenu-link"
                                >Tambah Data</a>
                            </li>
                            <li class="submenu-item <?php echo ($current_page == 'TabelMahasiswa.php') ? 'active' : ''; ?>">
                                <a href="User/TabelMahasiswa.php" class="submenu-link"
                                >Lihat Data</a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if($role === 1 || $role === 2) { ?>
                    <li class="sidebar-item has-sub">
                        <a href="#" class="sidebar-link">
                        <i class="bi bi-person-lines-fill"></i>
                        <span>Data Staff</span>
                        </a>

                        <ul class="submenu">
                            <li class="submenu-item <?php echo ($current_page == 'FormStaff.php') ? 'active' : ''; ?>">
                            <a href="User/FormStaff.php" class="submenu-link"
                                >Tambah Data</a>
                            </li>
                            <li class="submenu-item <?php echo ($current_page == 'TabelStaff.php') ? 'active' : ''; ?>">
                                <a href="User/TabelStaff.php" class="submenu-link"
                            >Lihat Data</a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if($role === 1) { ?>
                    <li class="sidebar-item has-sub">
                        <a href="#" class="sidebar-link">
                        <i class="bi bi-person-badge-fill"></i>
                        <span>Role</span>
                        </a>

                        <ul class="submenu">
                            <li class="submenu-item <?php echo ($current_page == 'FormRole.php') ? 'active' : ''; ?>">
                            <a href="Role/FormRole.php" class="submenu-link"
                                >Tambah Data</a>
                            </li>
                            <li class="submenu-item <?php echo ($current_page == 'TabelRole.php') ? 'active' : ''; ?>">
                                <a href="Role/TabelRole.php" class="submenu-link"
                            >Lihat Data</a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if ($role === 1 || $role === 2 || $role === 3 || $role === 4 || $role === 5 || $role === 6 || $role === 7) { ?>
                    <li class="sidebar-item <?php echo ($current_page == 'dashboardMHS.php') ? 'active' : ''; ?>">
                        <a href="Berkas/FormBerkas.php" class="sidebar-link">
                            <i class="bi bi-archive-fill"></i>
                            <span>Arsip Data</span>
                        </a>
                    </li>
                <?php } ?>
                <li class="sidebar-item has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-person-circle"></i>
                        <span>Akun</span>
                    </a>
                    <ul class="submenu">
                        <?php if ($role === 8) { ?>
                            <li class="submenu-item <?php echo ($current_page == 'profilMhs.php') ? 'active' : ''; ?>">
                                <a href="User/mahasiswa/ProfilMhs.php" class="submenu-link">Profil Saya</a>
                            </li>
                        <?php } else {?>
                            <li class="submenu-item <?php echo ($current_page == 'profilStaff.php') ? 'active' : ''; ?>">
                                <a href="User/admin/profilStaff.php" class="submenu-link">Profil Saya</a>
                            </li>
                        <?php } ?>
                        <li class="submenu-item <?php echo ($current_page == 'ubahPassword.php') ? 'active' : ''; ?>">
                            <a href="User/mahasiswa/ubahPassword.php" class="submenu-link">Ubah Password</a>
                        </li>
                        <li class="submenu-item <?php echo ($current_page == 'dashboardMHS.php') ? 'active' : ''; ?>">
                            <a href="Login/Logout.php" class="submenu-link">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
