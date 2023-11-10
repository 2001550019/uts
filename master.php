<?php

include "koneksi.php";

// Menentukan metode request
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

switch($method) {
    case 'GET':
        $sql = "SELECT * FROM semarang";
        $stmt = $pdo->query($sql);
        $semarang = $stmt->fetchAll();
        echo json_encode($semarang);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->jenis_wisata) && isset($data->jumlah_wisata) && isset($data->jumlah_pekerja)) {
            $sql = "INSERT INTO semarang (jenis_wisata, jumlah_wisata, jumlah_pekerja) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->jenis_wisata, $data->jumlah_wisata, $data->jumlah_pekerja]);
            echo json_encode(['message' => 'Data berhasil ditambahkan']);
        } else {
            echo json_encode(['message' => 'Data tidak lengkap']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->id) && isset($data->jenis_wisata) && isset($data->jumlah_wisata) && isset($data->jumlah_pekerja)) {
            $sql = "UPDATE semarang SET jenis_wisata=?, jumlah_wisata=?, jumlah_pekerja=? WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->jenis_wisata, $data->jumlah_wisata, $data->jumlah_pekerja, $data->id]);
            echo json_encode(['message' => 'Data berhasil diperbarui']);
        } else {
            echo json_encode(['message' => 'Data tidak lengkap']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->id)) {
            $sql = "DELETE FROM semarang WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->id]);
            echo json_encode(['message' => 'Wisata berhasil dihapus']);
        } else {
            echo json_encode(['message' => 'ID tidak ditemukan']);
        }
        break;

    default:
        echo json_encode(['message' => 'Metode tidak dikenali']);
        break;
}

?>
