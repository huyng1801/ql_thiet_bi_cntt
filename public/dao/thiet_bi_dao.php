<?php
include 'db.php';

function getAllThietBi() {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT thiet_bi.*, danh_muc_thiet_bi.ten_danh_muc, buu_cuc.ten_buu_cuc 
                                FROM thiet_bi 
                                LEFT JOIN danh_muc_thiet_bi ON thiet_bi.ma_danh_muc = danh_muc_thiet_bi.ma_danh_muc
                                LEFT JOIN buu_cuc ON thiet_bi.ma_buu_cuc = buu_cuc.ma_buu_cuc");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function addThietBi($ten_thiet_bi, $ma_sn, $hinh_anh, $ma_buu_cuc, $ghi_chu, $ma_danh_muc) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO thiet_bi (ten_thiet_bi, ma_sn, hinh_anh, ma_buu_cuc, ghi_chu, ma_danh_muc) 
                                VALUES (:ten_thiet_bi, :ma_sn, :hinh_anh, :ma_buu_cuc, :ghi_chu, :ma_danh_muc)");
        $stmt->bindParam(':ten_thiet_bi', $ten_thiet_bi);
        $stmt->bindParam(':ma_sn', $ma_sn);
        $stmt->bindParam(':hinh_anh', $hinh_anh);
        $stmt->bindParam(':ma_buu_cuc', $ma_buu_cuc);
        $stmt->bindParam(':ghi_chu', $ghi_chu);
        $stmt->bindParam(':ma_danh_muc', $ma_danh_muc);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function updateThietBi($ma_thiet_bi, $ten_thiet_bi, $ma_sn, $hinh_anh, $ma_buu_cuc, $ghi_chu, $ma_danh_muc) {
    global $conn;
    try {
        if ($hinh_anh) {
            $stmt = $conn->prepare("UPDATE thiet_bi 
                                    SET ten_thiet_bi = :ten_thiet_bi, ma_sn = :ma_sn, hinh_anh = :hinh_anh, ma_buu_cuc = :ma_buu_cuc, ghi_chu = :ghi_chu, ma_danh_muc = :ma_danh_muc 
                                    WHERE ma_thiet_bi = :ma_thiet_bi");
            $stmt->bindParam(':hinh_anh', $hinh_anh);
        } else {
            $stmt = $conn->prepare("UPDATE thiet_bi 
                                    SET ten_thiet_bi = :ten_thiet_bi, ma_sn = :ma_sn, ma_buu_cuc = :ma_buu_cuc, ghi_chu = :ghi_chu, ma_danh_muc = :ma_danh_muc 
                                    WHERE ma_thiet_bi = :ma_thiet_bi");
        }
        $stmt->bindParam(':ten_thiet_bi', $ten_thiet_bi);
        $stmt->bindParam(':ma_sn', $ma_sn);
        $stmt->bindParam(':ma_buu_cuc', $ma_buu_cuc);
        $stmt->bindParam(':ghi_chu', $ghi_chu);
        $stmt->bindParam(':ma_danh_muc', $ma_danh_muc);
        $stmt->bindParam(':ma_thiet_bi', $ma_thiet_bi);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function deleteThietBi($ma_thiet_bi) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM thiet_bi WHERE ma_thiet_bi = :ma_thiet_bi");
        $stmt->bindParam(':ma_thiet_bi', $ma_thiet_bi);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

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

function getAllBuuCuc() {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM buu_cuc");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}
?>
