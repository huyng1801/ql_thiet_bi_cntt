<?php
include 'db.php';

function getAllBuuCuc() {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT buu_cuc.*, quan_huyen.ten_quan_huyen FROM buu_cuc JOIN quan_huyen ON buu_cuc.ma_quan_huyen = quan_huyen.ma_quan_huyen");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function addBuuCuc($ma_buu_cuc, $ten_buu_cuc, $ma_quan_huyen) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO buu_cuc (ma_buu_cuc, ten_buu_cuc, ma_quan_huyen) VALUES (:ma_buu_cuc, :ten_buu_cuc, :ma_quan_huyen)");
        $stmt->bindParam(':ma_buu_cuc', $ma_buu_cuc);
        $stmt->bindParam(':ten_buu_cuc', $ten_buu_cuc);
        $stmt->bindParam(':ma_quan_huyen', $ma_quan_huyen);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function updateBuuCuc($ma_buu_cuc, $ten_buu_cuc, $ma_quan_huyen) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE buu_cuc SET ten_buu_cuc = :ten_buu_cuc, ma_quan_huyen = :ma_quan_huyen WHERE ma_buu_cuc = :ma_buu_cuc");
        $stmt->bindParam(':ma_buu_cuc', $ma_buu_cuc);
        $stmt->bindParam(':ten_buu_cuc', $ten_buu_cuc);
        $stmt->bindParam(':ma_quan_huyen', $ma_quan_huyen);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function deleteBuuCuc($ma_buu_cuc) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM buu_cuc WHERE ma_buu_cuc = :ma_buu_cuc");
        $stmt->bindParam(':ma_buu_cuc', $ma_buu_cuc);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function getAllQuanHuyen() {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM quan_huyen");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}
?>
