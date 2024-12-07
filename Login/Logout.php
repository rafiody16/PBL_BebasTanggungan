<?php
// Mulai sesi
session_start();

// Hancurkan semua sesi
session_unset();
session_destroy();

// Redirect pengguna ke halaman login setelah logout
header("Location: Login.php");
exit();
?>
