<?php

include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $tanggal_lahir = $_POST["tanggal_lahir"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $orangtua_id = isset($_POST["orangtua_id"]) ? $_POST["orangtua_id"] : null; // Tambahkan cek isset
    $pasangan_id = isset($_POST["pasangan_id"]) ? $_POST["pasangan_id"] : null; // Tambahkan cek isset
    $anak_id = isset($_POST["anak_id"]) ? $_POST["anak_id"] : null; // Tambahkan cek isset

    $query = "INSERT INTO anggota_keluarga (nama, tanggal_lahir, jenis_kelamin, orangtua_id, pasangan_id, anak_id)
            VALUES ('$nama', '$tanggal_lahir', '$jenis_kelamin', '$orangtua_id', '$pasangan_id', '$anak_id' )";
    
    $result = mysqli_query($koneksiku, $query);

    if ($result) {
        echo "Data Anggota Keluarga berhasil dimasukkan.";
        header('Location: index.php'); // Perbaiki pengalihan halaman
        exit;
    } else {
        echo "Gagal menyimpan data, Anda tidak masuk Kartu Keluarga.";
    }
}
?>
