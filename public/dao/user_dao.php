<?php
include 'db.php';

function getAllUsers() {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function addUser($ten_nguoi_dung, $mat_khau) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO users (ten_nguoi_dung, mat_khau) VALUES (:ten_nguoi_dung, :mat_khau)");
        $stmt->bindParam(':ten_nguoi_dung', $ten_nguoi_dung);
        $stmt->bindParam(':mat_khau', password_hash($mat_khau, PASSWORD_DEFAULT));
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function updateUser($ten_nguoi_dung, $mat_khau) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE users SET mat_khau = :mat_khau WHERE ten_nguoi_dung = :ten_nguoi_dung");
        $stmt->bindParam(':ten_nguoi_dung', $ten_nguoi_dung);
        $stmt->bindParam(':mat_khau', password_hash($mat_khau, PASSWORD_DEFAULT));
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function deleteUser($ten_nguoi_dung) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM users WHERE ten_nguoi_dung = :ten_nguoi_dung");
        $stmt->bindParam(':ten_nguoi_dung', $ten_nguoi_dung);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}
?>
