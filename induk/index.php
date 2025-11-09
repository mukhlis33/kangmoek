<?php
require_once '../config/auth.php';
require_once '../config/database.php';

$db = new Database();
$pdo = $db->getConnection();

// Search and filter logic
$search = $_GET['search'] ?? '';
$kelas = $_GET['kelas'] ?? '';
$status = $_GET['status'] ?? '';

$where = [];
$params = [];

if (!empty($search)) {
    $where[] = "(nama LIKE ? OR nis LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($kelas)) {
    $where[] = "kelas = ?";
    $params[] = $kelas;
}

if (!empty($status)) {
    $where[] = "status = ?";
    $params[] = $status;
}

$where_clause = '';
if (!empty($where)) {
    $where_clause = 'WHERE ' . implode(' AND ', $where);
}

// Get students
$stmt = $pdo->prepare("SELECT * FROM students $where_clause ORDER BY created_at DESC");
$stmt->execute($params);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - Buku Induk</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-content">
            <h1>Buku Induk Siswa</h1>
            <button class="mobile-menu-btn">☰</button>
        </div>
    </nav>

    <!-- Sidebar -->
    <?php include '../includes/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="card">
            <h2>Data Siswa</h2>
            
            <!-- Search and Filter -->
            <form method="GET" class="search-form">
                <div style="display: grid; grid-template-columns: 1fr auto auto auto; gap: 1rem; margin-bottom: 1rem;">
                    <input type="text" name="search" placeholder="Cari nama atau NIS..." 
                           value="<?= htmlspecialchars($search) ?>" class="form-control">
                    <select name="kelas" class="form-control">
                        <option value="">Semua Kelas</option>
                        <option value="X" <?= $kelas == 'X' ? 'selected' : '' ?>>X</option>
                        <option value="XI" <?= $kelas == 'XI' ? 'selected' : '' ?>>XI</option>
                        <option value="XII" <?= $kelas == 'XII' ? 'selected' : '' ?>>XII</option>
                    </select>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="Aktif" <?= $status == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="Lulus" <?= $status == 'Lulus' ? 'selected' : '' ?>>Lulus</option>
                        <option value="Pindah" <?= $status == 'Pindah' ? 'selected' : '' ?>>Pindah</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>

            <!-- Students Table -->
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($students as $student): ?>
                        <tr>
                            <td>
                                <?php if($student['foto']): ?>
                                    <img src="../assets/uploads/<?= $student['foto'] ?>" 
                                         alt="Foto" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                <?php else: ?>
                                    <div style="width: 50px; height: 50px; background: #e2e8f0; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                                        <span>No Photo</span>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($student['nis']) ?></td>
                            <td><?= htmlspecialchars($student['nama']) ?></td>
                            <td><?= htmlspecialchars($student['kelas']) ?></td>
                            <td>
                                <span style="padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; 
                                    background: <?= $student['status'] == 'Aktif' ? '#10b98120' : '#64748b20' ?>;
                                    color: <?= $student['status'] == 'Aktif' ? '#10b981' : '#64748b' ?>;">
                                    <?= $student['status'] ?>
                                </span>
                            </td>
                            <td>
                                <a href="view.php?id=<?= $student['id'] ?>" class="btn" style="background: #10b981; color: white; padding: 0.25rem 0.5rem; margin-right: 0.25rem;">Lihat</a>
                                <a href="edit.php?id=<?= $student['id'] ?>" class="btn" style="background: #f59e0b; color: white; padding: 0.25rem 0.5rem; margin-right: 0.25rem;">Edit</a>
                                <a href="delete.php?id=<?= $student['id'] ?>" class="btn" style="background: #ef4444; color: white; padding: 0.25rem 0.5rem;" 
                                   onclick="return confirm('Hapus data siswa?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Add Student Button -->
            <div style="margin-top: 1rem;">
                <a href="add.php" class="btn btn-primary">Tambah Siswa Baru</a>
            </div>
        </div>
    </main>

    <script src="../assets/js/script.js"></script>
</body>
</html>