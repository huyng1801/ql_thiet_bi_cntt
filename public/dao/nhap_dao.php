<?php
include 'db.php';

function getAllNhap() {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT nhap.*, buu_cuc.ten_buu_cuc, users.ten_nguoi_dung FROM nhap 
                                JOIN buu_cuc ON nhap.ma_buu_cuc = buu_cuc.ma_buu_cuc
                                JOIN users ON nhap.user_nhan = users.ten_nguoi_dung");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function addNhap($noi_xuat, $ma_buu_cuc, $user_nhan) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO nhap (noi_xuat, ma_buu_cuc, user_nhan) VALUES (:noi_xuat, :ma_buu_cuc, :user_nhan)");
        $stmt->bindParam(':noi_xuat', $noi_xuat);
        $stmt->bindParam(':ma_buu_cuc', $ma_buu_cuc);
        $stmt->bindParam(':user_nhan', $user_nhan);
        $stmt->execute();
        return $conn->lastInsertId();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function deleteNhap($ma_nhap) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM nhap WHERE ma_nhap = :ma_nhap");
        $stmt->bindParam(':ma_nhap', $ma_nhap);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function addChiTietNhap($ma_nhap, $ten_thiet_bi, $xuat_xu, $ma_danh_muc, $ma_sn) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO chi_tiet_nhap (ma_nhap, ten_thiet_bi, xuat_xu, ma_danh_muc, ma_sn) VALUES (:ma_nhap, :ten_thiet_bi, :xuat_xu, :ma_danh_muc, :ma_sn)");
        $stmt->bindParam(':ma_nhap', $ma_nhap);
        $stmt->bindParam(':ten_thiet_bi', $ten_thiet_bi);
        $stmt->bindParam(':xuat_xu', $xuat_xu);
        $stmt->bindParam(':ma_danh_muc', $ma_danh_muc);
        $stmt->bindParam(':ma_sn', $ma_sn);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}



function getNhapById($ma_nhap) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT nhap.*, buu_cuc.ten_buu_cuc, users.ten_nguoi_dung 
                                FROM nhap 
                                JOIN buu_cuc ON nhap.ma_buu_cuc = buu_cuc.ma_buu_cuc
                                JOIN users ON nhap.user_nhan = users.ten_nguoi_dung
                                WHERE nhap.ma_nhap = :ma_nhap");
        $stmt->bindParam(':ma_nhap', $ma_nhap);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}

function getChiTietNhapById($ma_nhap) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT chi_tiet_nhap.*, danh_muc_thiet_bi.ten_danh_muc 
                                FROM chi_tiet_nhap 
                                JOIN danh_muc_thiet_bi ON chi_tiet_nhap.ma_danh_muc = danh_muc_thiet_bi.ma_danh_muc 
                                WHERE chi_tiet_nhap.ma_nhap = :ma_nhap");
        $stmt->bindParam(':ma_nhap', $ma_nhap);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}
?>
