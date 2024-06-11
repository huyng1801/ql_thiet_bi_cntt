<?php
include '../dao/buu_cuc_dao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        addBuuCuc($_POST['ma_buu_cuc'], $_POST['ten_buu_cuc'], $_POST['ma_quan_huyen']);
    } elseif (isset($_POST['update'])) {
        updateBuuCuc($_POST['ma_buu_cuc'], $_POST['ten_buu_cuc'], $_POST['ma_quan_huyen']);
    } elseif (isset($_POST['delete'])) {
        deleteBuuCuc($_POST['ma_buu_cuc']);
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$buuCucList = getAllBuuCuc();
$quanHuyenList = getAllQuanHuyen();
?>

<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mt-4">Danh sách Bưu Cục</h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Thêm Bưu Cục</button>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Mã Bưu Cục</th>
                <th>Tên Bưu Cục</th>
                <th>Quận Huyện</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($buuCucList as $buuCuc): ?>
            <tr>
                <td><?php echo $buuCuc['ma_buu_cuc']; ?></td>
                <td><?php echo $buuCuc['ten_buu_cuc']; ?></td>
                <td><?php echo $buuCuc['ten_quan_huyen']; ?></td>
                <td>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateModal" data-ma_buu_cuc="<?php echo $buuCuc['ma_buu_cuc']; ?>" data-ten_buu_cuc="<?php echo $buuCuc['ten_buu_cuc']; ?>" data-ma_quan_huyen="<?php echo $buuCuc['ma_quan_huyen']; ?>">Sửa</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-ma_buu_cuc="<?php echo $buuCuc['ma_buu_cuc']; ?>">Xóa</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Thêm Bưu Cục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ma_buu_cuc">Mã Bưu Cục</label>
                        <input type="text" class="form-control" id="ma_buu_cuc" name="ma_buu_cuc" required>
                    </div>
                    <div class="form-group">
                        <label for="ten_buu_cuc">Tên Bưu Cục</label>
                        <input type="text" class="form-control" id="ten_buu_cuc" name="ten_buu_cuc" required>
                    </div>
                    <div class="form-group">
                        <label for="ma_quan_huyen">Quận Huyện</label>
                        <select class="form-control" id="ma_quan_huyen" name="ma_quan_huyen" required>
                            <?php foreach ($quanHuyenList as $quanHuyen): ?>
                            <option value="<?php echo $quanHuyen['ma_quan_huyen']; ?>"><?php echo $quanHuyen['ten_quan_huyen']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="add" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Cập Nhật Bưu Cục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ma_buu_cuc_update">Mã Bưu Cục</label>
                        <input type="text" class="form-control" id="ma_buu_cuc_update" name="ma_buu_cuc" readonly>
                    </div>
                    <div class="form-group">
                        <label for="ten_buu_cuc_update">Tên Bưu Cục</label>
                        <input type="text" class="form-control" id="ten_buu_cuc_update" name="ten_buu_cuc" required>
                    </div>
                    <div class="form-group">
                        <label for="ma_quan_huyen_update">Quận Huyện</label>
                        <select class="form-control" id="ma_quan_huyen_update" name="ma_quan_huyen" required>
                            <?php foreach ($quanHuyenList as $quanHuyen): ?>
                            <option value="<?php echo $quanHuyen['ma_quan_huyen']; ?>"><?php echo $quanHuyen['ten_quan_huyen']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="update" class="btn btn-primary">Cập Nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Xóa Bưu Cục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa bưu cục này không?</p>
                    <input type="hidden" id="ma_buu_cuc_delete" name="ma_buu_cuc">
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
    $('#updateModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var ma_buu_cuc = button.data('ma_buu_cuc');
        var ten_buu_cuc = button.data('ten_buu_cuc');
        var ma_quan_huyen = button.data('ma_quan_huyen');
        var modal = $(this);
        modal.find('.modal-body #ma_buu_cuc_update').val(ma_buu_cuc);
        modal.find('.modal-body #ten_buu_cuc_update').val(ten_buu_cuc);
        modal.find('.modal-body #ma_quan_huyen_update').val(ma_quan_huyen);
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var ma_buu_cuc = button.data('ma_buu_cuc');
        var modal = $(this);
        modal.find('.modal-body #ma_buu_cuc_delete').val(ma_buu_cuc);
    });
});
</script>

<?php include 'footer.php'; ?>
