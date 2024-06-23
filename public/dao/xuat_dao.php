<?php
include 'db.php';
function getAllXuatFiltered($filterDate = '', $filterSession = '') {
    global $conn;
    try {
        $query = "SELECT xuat.*, buu_cuc.ten_buu_cuc, users.ten_nguoi_dung FROM xuat 
                  JOIN buu_cuc ON xuat.ma_buu_cuc = buu_cuc.ma_buu_cuc
                  JOIN users ON xuat.user_xuat = users.ten_nguoi_dung
                  WHERE 1=1";

        if ($filterDate) {
            $query .= " AND DATE(thoi_gian_xuat) = :filterDate";
        }

        if ($filterSession) {
            if ($filterSession == 'morning') {
                $query .= " AND TIME(thoi_gian_xuat) BETWEEN '00:00:00' AND '11:59:59'";
            } elseif ($filterSession == 'afternoon') {
                $query .= " AND TIME(thoi_gian_xuat) BETWEEN '12:00:00' AND '23:59:59'";
            }
        }

        $stmt = $conn->prepare($query);

        if ($filterDate) {
            $stmt->bindParam(':filterDate', $filterDate);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}
function getAllXuat() {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT xuat.*, buu_cuc.ten_buu_cuc, users.ten_nguoi_dung FROM xuat 
                                JOIN buu_cuc ON xuat.ma_buu_cuc = buu_cuc.ma_buu_cuc
                                JOIN users ON xuat.user_xuat = users.ten_nguoi_dung");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function addXuat($noi_nhan, $ma_buu_cuc, $user_xuat) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO xuat (noi_nhan, ma_buu_cuc, user_xuat) VALUES (:noi_nhan, :ma_buu_cuc, :user_xuat)");
        $stmt->bindParam(':noi_nhan', $noi_nhan);
        $stmt->bindParam(':ma_buu_cuc', $ma_buu_cuc);
        $stmt->bindParam(':user_xuat', $user_xuat);
        $stmt->execute();
        return $conn->lastInsertId();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function deleteXuat($ma_xuat) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM xuat WHERE ma_xuat = :ma_xuat");
        $stmt->bindParam(':ma_xuat', $ma_xuat);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function addChiTietXuat($ma_xuat, $ten_thiet_bi, $xuat_xu, $ma_danh_muc, $ma_sn) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO chi_tiet_xuat (ma_xuat, ten_thiet_bi, xuat_xu, ma_danh_muc, ma_sn) VALUES (:ma_xuat, :ten_thiet_bi, :xuat_xu, :ma_danh_muc, :ma_sn)");
        $stmt->bindParam(':ma_xuat', $ma_xuat);
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

function getXuatById($ma_xuat) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT xuat.*, buu_cuc.ten_buu_cuc, users.ten_nguoi_dung 
                                FROM xuat 
                                JOIN buu_cuc ON xuat.ma_buu_cuc = buu_cuc.ma_buu_cuc
                                JOIN users ON xuat.user_xuat = users.ten_nguoi_dung
                                WHERE xuat.ma_xuat = :ma_xuat");
        $stmt->bindParam(':ma_xuat', $ma_xuat);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}


function getChiTietXuatById($ma_xuat) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT chi_tiet_xuat.*, danh_muc_thiet_bi.ten_danh_muc 
                                FROM chi_tiet_xuat 
                                JOIN danh_muc_thiet_bi ON chi_tiet_xuat.ma_danh_muc = danh_muc_thiet_bi.ma_danh_muc 
                                WHERE chi_tiet_xuat.ma_xuat = :ma_xuat");
        $stmt->bindParam(':ma_xuat', $ma_xuat);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

?>
