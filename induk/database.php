<?php
class Database {
    private $pdo;
    private $db_file = "database.db";
    
    public function __construct() {
        try {
            $this->pdo = new PDO("sqlite:" . $this->db_file);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->createTables();
        } catch(PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }
    
    private function createTables() {
        // Users table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(20) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Students table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS students (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nis VARCHAR(20) UNIQUE NOT NULL,
            nisn VARCHAR(20),
            nama VARCHAR(100) NOT NULL,
            tempat_lahir VARCHAR(50),
            tanggal_lahir DATE,
            jenis_kelamin VARCHAR(10),
            agama VARCHAR(20),
            alamat TEXT,
            foto VARCHAR(255),
            tahun_masuk YEAR,
            kelas VARCHAR(10),
            jurusan VARCHAR(50),
            status VARCHAR(20) DEFAULT 'Aktif',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Insert default users if not exists
        $this->createDefaultUsers();
    }
    
    private function createDefaultUsers() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users");
        $stmt->execute();
        if($stmt->fetchColumn() == 0) {
            $users = [
                ['admin', password_hash('admin123', PASSWORD_DEFAULT), 'Admin'],
                ['operator', password_hash('operator123', PASSWORD_DEFAULT), 'Operator']
            ];
            
            $stmt = $this->pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            foreach($users as $user) {
                $stmt->execute($user);
            }
        }
    }
    
    public function getConnection() {
        return $this->pdo;
    }
}
?>