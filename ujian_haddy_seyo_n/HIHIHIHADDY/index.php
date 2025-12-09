<?php
require_once 'config.php';

$stmt = $pdo->query("SELECT * FROM Siswa ORDER BY id DESC");
$siswa = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Data Siswa - No Page Reload</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4">Data Siswa (Single Page CRUD)</h2>

  <div class="card mb-4">
    <div class="card-header">Form Siswa</div>
    <div class="card-body">
      <form id="siswaForm">
        <input type="hidden" name="id" id="id">
        <div class="row">
          <div class="col-md-3">
            <label>Nama Lengkap</label>
            <input type="text" name="Nama_Lengkap" id="Nama_Lengkap" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label>NIS</label>
            <input type="text" name="NIS" id="NIS" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label>Kelas</label>
            <select name="Kelas" id="Kelas" class="form-select" required>
              <option value="">Pilih Kelas</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Jurusan</label>
            <select name="Jurusan" id="Jurusan" class="form-select" required>
              <option value="">Pilih Jurusan</option>
              <option value="11 PPLG 1">11 PPLG 1</option>
              <option value="11 PPLG 2">11 PPLG 2</option>
              <option value="11 DKV+">11 DKV+</option>
            </select>
          </div>
        </div>
        <div class="mt-3">
          <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
          <button type="button" class="btn btn-secondary" id="cancelBtn" style="display:none;">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nama Lengkap</th>
        <th>NIS</th>
        <th>Kelas</th>
        <th>Jurusan</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="siswaTable">
      <?php foreach ($siswa as $row): ?>
        <tr data-id="<?= $row['id'] ?>">
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['Nama_Lengkap']) ?></td>
          <td><?= htmlspecialchars($row['NIS']) ?></td>
          <td><?= htmlspecialchars($row['Kelas']) ?></td>
          <td><?= htmlspecialchars($row['Jurusan']) ?></td>
          <td>
            <button class="btn btn-sm btn-warning editBtn">Edit</button>
            <button class="btn btn-sm btn-danger deleteBtn">Delete</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
  $('#siswaForm').on('submit', function (e) {
    e.preventDefault();
    const id = $('#id').val();
    const url = id ? 'ajax.php?action=update' : 'ajax.php?action=create';
    $.post(url, $(this).serialize(), function (response) {
      if (response.success) {
        location.reload(); 
      } else {
        alert(response.message);
      }
    }, 'json');
  });

  $(document).on('click', '.editBtn', function () {
    const row = $(this).closest('tr');
    $('#id').val(row.data('id'));
    $('#Nama_Lengkap').val(row.find('td:eq(1)').text());
    $('#NIS').val(row.find('td:eq(2)').text());
    $('#Kelas').val(row.find('td:eq(3)').text());
    $('#Jurusan').val(row.find('td:eq(4)').text());
    $('#saveBtn').text('Update');
    $('#cancelBtn').show();
  });

  $('#cancelBtn').on('click', function () {
    $('#siswaForm')[0].reset();
    $('#id').val('');
    $('#saveBtn').text('Save');
    $(this).hide();
  });

  $(document).on('click', '.deleteBtn', function () {
    if (!confirm('Yakin ingin menghapus data ini?')) return;
    const id = $(this).closest('tr').data('id');
    $.post('ajax.php?action=delete', { id }, function (response) {
      if (response.success) {
        location.reload();
      } else {
        alert(response.message);
      }
    }, 'json');
  });
</script>

</body>
</html>