<?php
include 'db.php';

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

function addQuanHuyen($ma_quan_huyen, $ten_quan_huyen) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO quan_huyen (ma_quan_huyen, ten_quan_huyen) VALUES (:ma_quan_huyen, :ten_quan_huyen)");
        $stmt->bindParam(':ma_quan_huyen', $ma_quan_huyen);
        $stmt->bindParam(':ten_quan_huyen', $ten_quan_huyen);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function updateQuanHuyen($ma_quan_huyen, $ten_quan_huyen) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE quan_huyen SET ten_quan_huyen = :ten_quan_huyen WHERE ma_quan_huyen = :ma_quan_huyen");
        $stmt->bindParam(':ma_quan_huyen', $ma_quan_huyen);
        $stmt->bindParam(':ten_quan_huyen', $ten_quan_huyen);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function deleteQuanHuyen($ma_quan_huyen) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM quan_huyen WHERE ma_quan_huyen = :ma_quan_huyen");
        $stmt->bindParam(':ma_quan_huyen', $ma_quan_huyen);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}
?>
