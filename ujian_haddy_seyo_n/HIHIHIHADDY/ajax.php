<?php
// copy dari perulangan dari Stein;Gate waktu itu.
require_once 'config.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

switch ($action) {
  case 'create':
    $stmt = $pdo->prepare("INSERT INTO Siswa (Nama_Lengkap, NIS, Kelas, Jurusan) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['Nama_Lengkap'], $_POST['NIS'], $_POST['Kelas'], $_POST['Jurusan']]);
    echo json_encode(['success' => true]);
    break;

  case 'update':
    $stmt = $pdo->prepare("UPDATE Siswa SET Nama_Lengkap = ?, NIS = ?, Kelas = ?, Jurusan = ? WHERE id = ?");
    $stmt->execute([$_POST['Nama_Lengkap'], $_POST['NIS'], $_POST['Kelas'], $_POST['Jurusan'], $_POST['id']]);
    echo json_encode(['success' => true]);
    break;

  case 'delete':
    $stmt = $pdo->prepare("DELETE FROM Siswa WHERE id = ?");
    $stmt->execute([$_POST['id']]);
    echo json_encode(['success' => true]);
    break;

  default:
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}