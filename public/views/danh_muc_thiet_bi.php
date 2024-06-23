<?php
include '../dao/danh_muc_thiet_bi_dao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        addDanhMucThietBi($_POST['ten_danh_muc']);
    } elseif (isset($_POST['update'])) {
        updateDanhMucThietBi($_POST['ma_danh_muc'], $_POST['ten_danh_muc']);
    } elseif (isset($_POST['delete'])) {
        deleteDanhMucThietBi($_POST['ma_danh_muc']);
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$danhMucThietBiList = getAllDanhMucThietBi();
?>

<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mt-4 text-uppercase text-center">Danh sách Danh Mục Thiết Bị</h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Thêm mới</button>
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Mã Danh Mục</th>
                <th>Tên Danh Mục</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($danhMucThietBiList as $danhMuc): ?>
            <tr>
                <td><?php echo $danhMuc['ma_danh_muc']; ?></td>
                <td><?php echo $danhMuc['ten_danh_muc']; ?></td>
                <td>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateModal" data-ma_danh_muc="<?php echo $danhMuc['ma_danh_muc']; ?>" data-ten_danh_muc="<?php echo $danhMuc['ten_danh_muc']; ?>">Sửa</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-ma_danh_muc="<?php echo $danhMuc['ma_danh_muc']; ?>">Xóa</button>
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
                    <h5 class="modal-title" id="addModalLabel">Thêm Danh Mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ten_danh_muc">Tên Danh Mục</label>
                        <input type="text" class="form-control" id="ten_danh_muc" name="ten_danh_muc" required>
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
                    <h5 class="modal-title" id="updateModalLabel">Cập Nhật Danh Mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ma_danh_muc_update">Mã Danh Mục</label>
                        <input type="text" class="form-control" id="ma_danh_muc_update" name="ma_danh_muc" readonly>
                    </div>
                    <div class="form-group">
                        <label for="ten_danh_muc_update">Tên Danh Mục</label>
                        <input type="text" class="form-control" id="ten_danh_muc_update" name="ten_danh_muc" required>
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
                    <h5 class="modal-title" id="deleteModalLabel">Xóa Danh Mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa danh mục này không?</p>
                    <input type="hidden" id="ma_danh_muc_delete" name="ma_danh_muc">
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
        var ma_danh_muc = button.data('ma_danh_muc');
        var ten_danh_muc = button.data('ten_danh_muc');
        var modal = $(this);
        modal.find('.modal-body #ma_danh_muc_update').val(ma_danh_muc);
        modal.find('.modal-body #ten_danh_muc_update').val(ten_danh_muc);
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var ma_danh_muc = button.data('ma_danh_muc');
        var modal = $(this);
        modal.find('.modal-body #ma_danh_muc_delete').val(ma_danh_muc);
    });
});
</script>

<?php include 'footer.php'; ?>
