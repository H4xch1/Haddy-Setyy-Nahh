<?php
require_once 'config.php';

$id = $Nama_Lengkap = $NIS = $Kelas = $Jurusan = '';
$isEdit = false;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM Siswa WHERE id = ?");
    $stmt->execute([$id]);
    $siswa = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($siswa) {
        $Nama_Lengkap = $siswa['Nama_Lengkap'];
        $NIS = $siswa['NIS'];
        $Kelas = $siswa['Kelas'];
        $Jurusan = $siswa['Jurusan'];
        $isEdit = true;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Nama_Lengkap = $_POST['Nama_Lengkap'];
    $NIS = $_POST['NIS'];
    $Kelas = $_POST['Kelas'];
    $Jurusan = $_POST['Jurusan'];
    
    try {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $id = $_POST['id'];
            $stmt = $pdo->prepare("UPDATE Siswa SET Nama_Lengkap = ?, NIS = ?, Kelas = ?, Jurusan = ? WHERE id = ?");
            $stmt->execute([$Nama_Lengkap, $NIS, $Kelas, $Jurusan, $id]);
            $message = "Data siswa updated successfully!";
        } else {
            $stmt = $pdo->prepare("INSERT INTO Siswa (Nama_Lengkap, NIS, Kelas, Jurusan) VALUES (?, ?, ?, ?)");
            $stmt->execute([$Nama_Lengkap, $NIS, $Kelas, $Jurusan]);
            $message = "Data siswa added successfully!";
        }
        
        header("Location: index.php?message=" . urlencode($message));
        exit();
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>
/'preset dari github'/
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Edit' : 'Add' ?> Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><?= $isEdit ? 'Edit' : 'Add New' ?> Data Siswa</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="POST" action="form.php">
                            <?php if ($isEdit): ?>
                                <input type="hidden" name="id" value="<?= $id ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="Nama_Lengkap" class="form-label">Nama Lengkap, jangan asal asalan loh yaaa</label>
                                <input type="text" class="form-control" id="Nama_Lengkap" name="Nama_Lengkap" 
                                       value="<?= htmlspecialchars($Nama_Lengkap) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="NIS" class="form-label">NIS</label>
                                <input type="text" class="form-control" id="NIS" name="NIS" 
                                       value="<?= htmlspecialchars($NIS) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="Kelas" class="form-label">Kelas....</label>
                                <select class="form-control" id="Kelas" name="Kelas" required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="10" <?= $Kelas == '10' ? 'selected' : '' ?>>10</option>
                                    <option value="11" <?= $Kelas == '11' ? 'selected' : '' ?>>11</option>
                                    <option value="12" <?= $Kelas == '12' ? 'selected' : '' ?>>12</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="Jurusan" class="form-label">Jurusan</label>
                                <select class="form-control" id="Jurusan" name="Jurusan" required>
                                    <option value="">Pilih Jurusan</option>
                                    <option value="11 PPLG 1" <?= $Jurusan == '11 PPLG 1' ? 'selected' : '' ?>>11 PPLG 1</option>
                                    <option value="11 PPLG 2" <?= $Jurusan == '11 PPLG 2' ? 'selected' : '' ?>>11 PPLG 2</option>
                                    <option value="11 DKV+" <?= $Jurusan == '11 DKV+' ? 'selected' : '' ?>>11 DKV+</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <?= $isEdit ? 'Update' : 'Save' ?> Data
                                </button>
                                <a href="index.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>