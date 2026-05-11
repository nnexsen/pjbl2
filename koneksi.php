<?php
    session_start();
    $conn = mysqli_connect("localhost", "root", "", "web_sekolah");
    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }