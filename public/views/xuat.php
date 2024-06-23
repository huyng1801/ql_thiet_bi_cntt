<?php
include '../dao/xuat_dao.php';
include '../dao/buu_cuc_dao.php';
include '../dao/user_dao.php';
include '../dao/danh_muc_thiet_bi_dao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $ma_xuat = addXuat($_POST['noi_nhan'], $_POST['ma_buu_cuc'], $_POST['user_xuat']);
        if ($ma_xuat) {
            foreach ($_POST['chi_tiet'] as $chi_tiet) {
                addChiTietXuat($ma_xuat, $chi_tiet['ten_thiet_bi'], $chi_tiet['xuat_xu'], $chi_tiet['ma_danh_muc'], $chi_tiet['ma_sn']);
            }
        }
    } elseif (isset($_POST['delete'])) {
        deleteXuat($_POST['ma_xuat']);
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$xuatList = getAllXuat();
$buuCucList = getAllBuuCuc();
$userList = getAllUsers();
$danhMucThietBiList = getAllDanhMucThietBi();

function getXuatDetails($ma_xuat) {
    $xuatDetails = getXuatById($ma_xuat);
    $chiTietXuat = getChiTietXuatById($ma_xuat);
    $xuatDetails['chi_tiet'] = $chiTietXuat;
    return $xuatDetails;
}

$viewXuat = null;
if (isset($_GET['view'])) {
    $viewXuat = getXuatDetails($_GET['view']);
}
?>

<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mt-4 text-uppercase text-center">Xuất Thiết Bị</h1>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Thêm mới</button>

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Mã Xuất</th>
                <th>Thời Gian Xuất</th>
                <th>Nơi Nhận</th>
                <th>Bưu Cục</th>
                <th>Người Xuất</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($xuatList as $xuat): ?>
            <tr>
                <td><?php echo $xuat['ma_xuat']; ?></td>
                <td><?php echo $xuat['thoi_gian_xuat']; ?></td>
                <td><?php echo $xuat['noi_nhan']; ?></td>
                <td><?php echo $xuat['ten_buu_cuc']; ?></td>
                <td><?php echo $xuat['ten_nguoi_dung']; ?></td>
                <td>
                    <a href="?view=<?php echo $xuat['ma_xuat']; ?>" class="btn btn-info">Xem</a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-ma_xuat="<?php echo $xuat['ma_xuat']; ?>">Xóa</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Thêm Xuất Thiết Bị</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="noi_nhan">Nơi Nhận</label>
                        <input type="text" class="form-control" id="noi_nhan" name="noi_nhan" required>
                    </div>
                    <div class="form-group">
                        <label for="ma_buu_cuc">Bưu Cục</label>
                        <select class="form-control" id="ma_buu_cuc" name="ma_buu_cuc" required>
                            <?php foreach ($buuCucList as $buuCuc): ?>
                            <option value="<?php echo $buuCuc['ma_buu_cuc']; ?>"><?php echo $buuCuc['ten_buu_cuc']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="user_xuat">Người Xuất</label>
                        <select class="form-control" id="user_xuat" name="user_xuat" required>
                            <?php foreach ($userList as $user): ?>
                            <option value="<?php echo $user['ten_nguoi_dung']; ?>"><?php echo $user['ten_nguoi_dung']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <hr>
                    <h5>Chi Tiết Thiết Bị</h5>
                    <table class="table" id="chiTietTable">
                        <thead>
                            <tr>
                                <th>Tên Thiết Bị</th>
                             
                                <th>Xuất Xứ</th>
                                <th>Danh Mục</th>
                                <th>Số SN</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" name="chi_tiet[0][ten_thiet_bi]" required></td>
                        
                                <td><input type="text" class="form-control" name="chi_tiet[0][xuat_xu]" required></td>
                                <td>
                                    <select class="form-control" name="chi_tiet[0][ma_danh_muc]" required>
                                        <?php foreach ($danhMucThietBiList as $danhMuc): ?>
                                        <option value="<?php echo $danhMuc['ma_danh_muc']; ?>"><?php echo $danhMuc['ten_danh_muc']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="chi_tiet[0][ma_sn]" required></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-row">Xóa</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success" id="addRow">Thêm Chi Tiết</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="add" class="btn btn-primary">Lưu Xuất Kho</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Modal -->
<?php if ($viewXuat): ?>
<div class="modal fade show" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true" style="display: block;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Chi Tiết Xuất Thiết Bị</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>'">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="view_noi_nhan">Nơi Nhận</label>
                    <input type="text" class="form-control" id="view_noi_nhan" name="noi_nhan" value="<?php echo $viewXuat['noi_nhan']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="view_ma_buu_cuc">Bưu Cục</label>
                    <input type="text" class="form-control" id="view_ma_buu_cuc" name="ma_buu_cuc" value="<?php echo $viewXuat['ten_buu_cuc']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="view_user_xuat">Người Xuất</label>
                    <input type="text" class="form-control" id="view_user_xuat" name="user_xuat" value="<?php echo $viewXuat['ten_nguoi_dung']; ?>" readonly>
                </div>
                <hr>
                <h5>Chi Tiết Thiết Bị</h5>
                <table class="table" id="viewChiTietTable">
                    <thead>
                        <tr>
                            <th>Tên Thiết Bị</th>
                        
                            <th>Xuất Xứ</th>
                            <th>Danh Mục</th>
                            <th>Số SN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($viewXuat['chi_tiet'] as $chi_tiet): ?>
                        <tr>
                            <td><?php echo $chi_tiet['ten_thiet_bi']; ?></td>
                
                            <td><?php echo $chi_tiet['xuat_xu']; ?></td>
                            <td><?php echo $chi_tiet['ten_danh_muc']; ?></td>
                            <td><?php echo $chi_tiet['ma_sn']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>'">Đóng</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Xóa Xuất Thiết Bị</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa xuất thiết bị này không?</p>
                    <input type="hidden" id="ma_xuat_delete" name="ma_xuat">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="delete" class="btn btn-danger">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let rowCount = 1;
    $('#addRow').click(function () {
        const newRow = `
            <tr>
                <td><input type="text" class="form-control" name="chi_tiet[${rowCount}][ten_thiet_bi]" required></td>
            
                <td><input type="text" class="form-control" name="chi_tiet[${rowCount}][xuat_xu]" required></td>
                <td>
                    <select class="form-control" name="chi_tiet[${rowCount}][ma_danh_muc]" required>
                        <?php foreach ($danhMucThietBiList as $danhMuc): ?>
                        <option value="<?php echo $danhMuc['ma_danh_muc']; ?>"><?php echo $danhMuc['ten_danh_muc']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="chi_tiet[${rowCount}][ma_sn]" required></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row">Xóa</button></td>
            </tr>`;
        $('#chiTietTable tbody').append(newRow);
        rowCount++;
    });

    $('#chiTietTable').on('click', '.remove-row', function () {
        $(this).closest('tr').remove();
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var ma_xuat = button.data('ma_xuat');
        var modal = $(this);
        modal.find('.modal-body #ma_xuat_delete').val(ma_xuat);
    });

    <?php if ($viewXuat): ?>
    $('#viewModal').modal('show');
    <?php endif; ?>
});
</script>

<?php include 'footer.php'; ?>

