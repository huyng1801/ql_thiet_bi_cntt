<?php
include 'db.php';
function getAllCapThietBiFiltered($filterDate = '', $filterSession = '') {
    global $conn;
    try {
        $query = "SELECT cap_thiet_bi.*, buu_cuc.ten_buu_cuc, users.ten_nguoi_dung 
                  FROM cap_thiet_bi 
                  JOIN buu_cuc ON cap_thiet_bi.ma_buu_cuc = buu_cuc.ma_buu_cuc
                  JOIN users ON cap_thiet_bi.user_cap = users.ten_nguoi_dung
                  WHERE 1=1";

        if ($filterDate) {
            $query .= " AND DATE(thoi_gian_cap) = :filterDate";
        }

        if ($filterSession) {
            if ($filterSession == 'morning') {
                $query .= " AND TIME(thoi_gian_cap) BETWEEN '00:00:00' AND '11:59:59'";
            } elseif ($filterSession == 'afternoon') {
                $query .= " AND TIME(thoi_gian_cap) BETWEEN '12:00:00' AND '23:59:59'";
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
function getAllCapThietBi() {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT cap_thiet_bi.*, buu_cuc.ten_buu_cuc, users.ten_nguoi_dung FROM cap_thiet_bi 
                                JOIN buu_cuc ON cap_thiet_bi.ma_buu_cuc = buu_cuc.ma_buu_cuc
                                JOIN users ON cap_thiet_bi.user_cap = users.ten_nguoi_dung");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function addCapThietBi($noi_cap, $ma_buu_cuc, $user_cap) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO cap_thiet_bi (noi_cap, ma_buu_cuc, user_cap) VALUES (:noi_cap, :ma_buu_cuc, :user_cap)");
        $stmt->bindParam(':noi_cap', $noi_cap);
        $stmt->bindParam(':ma_buu_cuc', $ma_buu_cuc);
        $stmt->bindParam(':user_cap', $user_cap);
        $stmt->execute();
        return $conn->lastInsertId();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function deleteCapThietBi($ma_cap_thiet_bi) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM cap_thiet_bi WHERE ma_cap_thiet_bi = :ma_cap_thiet_bi");
        $stmt->bindParam(':ma_cap_thiet_bi', $ma_cap_thiet_bi);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function addChiTietCapThietBi($ma_cap_thiet_bi, $ten_thiet_bi, $xuat_xu, $ma_danh_muc, $ma_sn) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO chi_tiet_cap_thiet_bi (ma_cap_thiet_bi, ten_thiet_bi, xuat_xu, ma_danh_muc, ma_sn) VALUES (:ma_cap_thiet_bi, :ten_thiet_bi, :xuat_xu, :ma_danh_muc, :ma_sn)");
        $stmt->bindParam(':ma_cap_thiet_bi', $ma_cap_thiet_bi);
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

function getCapThietBiById($ma_cap_thiet_bi) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT cap_thiet_bi.*, buu_cuc.ten_buu_cuc, users.ten_nguoi_dung 
                                FROM cap_thiet_bi 
                                JOIN buu_cuc ON cap_thiet_bi.ma_buu_cuc = buu_cuc.ma_buu_cuc
                                JOIN users ON cap_thiet_bi.user_cap = users.ten_nguoi_dung
                                WHERE cap_thiet_bi.ma_cap_thiet_bi = :ma_cap_thiet_bi");
        $stmt->bindParam(':ma_cap_thiet_bi', $ma_cap_thiet_bi);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}

function getChiTietCapThietBiById($ma_cap_thiet_bi) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT chi_tiet_cap_thiet_bi.*, danh_muc_thiet_bi.ten_danh_muc 
                                FROM chi_tiet_cap_thiet_bi 
                                JOIN danh_muc_thiet_bi ON chi_tiet_cap_thiet_bi.ma_danh_muc = danh_muc_thiet_bi.ma_danh_muc 
                                WHERE chi_tiet_cap_thiet_bi.ma_cap_thiet_bi = :ma_cap_thiet_bi");
        $stmt->bindParam(':ma_cap_thiet_bi', $ma_cap_thiet_bi);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function getCapThietBiDetails($ma_cap_thiet_bi) {
    $capThietBiDetails = getCapThietBiById($ma_cap_thiet_bi);
    $chiTietCapThietBi = getChiTietCapThietBiById($ma_cap_thiet_bi);
    $capThietBiDetails['chi_tiet'] = $chiTietCapThietBi;
    return $capThietBiDetails;
}
?>
