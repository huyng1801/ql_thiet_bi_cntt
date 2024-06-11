<?php
include '../dao/nhap_dao.php';
include '../dao/buu_cuc_dao.php';
include '../dao/user_dao.php';
include '../dao/danh_muc_thiet_bi_dao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $ma_nhap = addNhap($_POST['noi_xuat'], $_POST['ma_buu_cuc'], $_POST['user_nhan']);
        if ($ma_nhap) {
            foreach ($_POST['chi_tiet'] as $chi_tiet) {
                addChiTietNhap($ma_nhap, $chi_tiet['ten_thiet_bi'], $chi_tiet['xuat_xu'], $chi_tiet['ma_danh_muc'], $chi_tiet['ma_sn']);
            }
        }
    } elseif (isset($_POST['delete'])) {
        deleteNhap($_POST['ma_nhap']);
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$nhapList = getAllNhap();
$buuCucList = getAllBuuCuc();
$userList = getAllUsers();
$danhMucThietBiList = getAllDanhMucThietBi();

function getNhapDetails($ma_nhap) {
    $nhapDetails = getNhapById($ma_nhap);
    $chiTietNhap = getChiTietNhapById($ma_nhap);
    $nhapDetails['chi_tiet'] = $chiTietNhap;
    return $nhapDetails;
}

$viewNhap = null;
if (isset($_GET['view'])) {
    $viewNhap = getNhapDetails($_GET['view']);
}
?>

<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mt-4">Nhập Thiết Bị</h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Thêm Nhập Thiết Bị</button>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Mã Nhập</th>
                <th>Thời Gian Nhận</th>
                <th>Nơi Xuất</th>
                <th>Bưu Cục</th>
                <th>Người Nhận</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nhapList as $nhap): ?>
            <tr>
                <td><?php echo $nhap['ma_nhap']; ?></td>
                <td><?php echo $nhap['thoi_gian_nhan']; ?></td>
                <td><?php echo $nhap['noi_xuat']; ?></td>
                <td><?php echo $nhap['ten_buu_cuc']; ?></td>
                <td><?php echo $nhap['ten_nguoi_dung']; ?></td>
                <td>
                    <a href="?view=<?php echo $nhap['ma_nhap']; ?>" class="btn btn-info">Xem</a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-ma_nhap="<?php echo $nhap['ma_nhap']; ?>">Xóa</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Thêm Nhập Thiết Bị</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="noi_xuat">Nơi Xuất</label>
                        <input type="text" class="form-control" id="noi_xuat" name="noi_xuat" required>
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
                        <label for="user_nhan">Người Nhận</label>
                        <select class="form-control" id="user_nhan" name="user_nhan" required>
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
                    <button type="submit" name="add" class="btn btn-primary">Lưu Nhập Kho</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Modal -->
<?php if ($viewNhap): ?>
<div class="modal fade show" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true" style="display: block;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Chi Tiết Nhập Thiết Bị</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>'">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="view_noi_xuat">Nơi Xuất</label>
                    <input type="text" class="form-control" id="view_noi_xuat" name="noi_xuat" value="<?php echo $viewNhap['noi_xuat']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="view_ma_buu_cuc">Bưu Cục</label>
                    <input type="text" class="form-control" id="view_ma_buu_cuc" name="ma_buu_cuc" value="<?php echo $viewNhap['ten_buu_cuc']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="view_user_nhan">Người Nhận</label>
                    <input type="text" class="form-control" id="view_user_nhan" name="user_nhan" value="<?php echo $viewNhap['ten_nguoi_dung']; ?>" readonly>
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
                        <?php foreach ($viewNhap['chi_tiet'] as $chi_tiet): ?>
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
                    <h5 class="modal-title" id="deleteModalLabel">Xóa Nhập Thiết Bị</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa nhập thiết bị này không?</p>
                    <input type="hidden" id="ma_nhap_delete" name="ma_nhap">
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
        var ma_nhap = button.data('ma_nhap');
        var modal = $(this);
        modal.find('.modal-body #ma_nhap_delete').val(ma_nhap);
    });

    <?php if ($viewNhap): ?>
    $('#viewModal').modal('show');
    <?php endif; ?>
});
</script>

<?php include 'footer.php'; ?>
