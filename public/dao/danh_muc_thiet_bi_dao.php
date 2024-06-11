<?php
include 'db.php';

function getAllDanhMucThietBi() {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM danh_muc_thiet_bi");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function addDanhMucThietBi($ten_danh_muc) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO danh_muc_thiet_bi (ten_danh_muc) VALUES (:ten_danh_muc)");
        $stmt->bindParam(':ten_danh_muc', $ten_danh_muc);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function updateDanhMucThietBi($ma_danh_muc, $ten_danh_muc) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE danh_muc_thiet_bi SET ten_danh_muc = :ten_danh_muc WHERE ma_danh_muc = :ma_danh_muc");
        $stmt->bindParam(':ma_danh_muc', $ma_danh_muc);
        $stmt->bindParam(':ten_danh_muc', $ten_danh_muc);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function deleteDanhMucThietBi($ma_danh_muc) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM danh_muc_thiet_bi WHERE ma_danh_muc = :ma_danh_muc");
        $stmt->bindParam(':ma_danh_muc', $ma_danh_muc);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}
?>
