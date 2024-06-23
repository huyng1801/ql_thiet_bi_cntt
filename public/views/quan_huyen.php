<?php
include '../dao/quan_huyen_dao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        addQuanHuyen($_POST['ma_quan_huyen'], $_POST['ten_quan_huyen']);
    } elseif (isset($_POST['update'])) {
        updateQuanHuyen($_POST['ma_quan_huyen'], $_POST['ten_quan_huyen']);
    } elseif (isset($_POST['delete'])) {
        deleteQuanHuyen($_POST['ma_quan_huyen']);
    }
    // Redirect to the same page to avoid resubmission on refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$quanHuyenList = getAllQuanHuyen();
?>

<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mt-4 text-uppercase text-center">Danh sách Quận Huyện</h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Thêm mới</button>
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Mã Quận Huyện</th>
                <th>Tên Quận Huyện</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($quanHuyenList as $quanHuyen): ?>
            <tr>
                <td><?php echo $quanHuyen['ma_quan_huyen']; ?></td>
                <td><?php echo $quanHuyen['ten_quan_huyen']; ?></td>
                <td>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateModal" data-ma_quan_huyen="<?php echo $quanHuyen['ma_quan_huyen']; ?>" data-ten_quan_huyen="<?php echo $quanHuyen['ten_quan_huyen']; ?>">Sửa</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-ma_quan_huyen="<?php echo $quanHuyen['ma_quan_huyen']; ?>">Xóa</button>
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
                    <h5 class="modal-title" id="addModalLabel">Thêm Quận Huyện</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ma_quan_huyen">Mã Quận Huyện</label>
                        <input type="text" class="form-control" id="ma_quan_huyen" name="ma_quan_huyen" required>
                    </div>
                    <div class="form-group">
                        <label for="ten_quan_huyen">Tên Quận Huyện</label>
                        <input type="text" class="form-control" id="ten_quan_huyen" name="ten_quan_huyen" required>
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
                <h5 class="modal-title" id="updateModalLabel">Cập Nhật Quận Huyện</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ma_quan_huyen_update">Mã Quận Huyện</label>
                        <input type="text" class="form-control" id="ma_quan_huyen_update" name="ma_quan_huyen" readonly>
                    </div>
                    <div class="form-group">
                        <label for="ten_quan_huyen_update">Tên Quận Huyện</label>
                        <input type="text" class="form-control" id="ten_quan_huyen_update" name="ten_quan_huyen" required>
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
                    <h5 class="modal-title" id="deleteModalLabel">Xóa Quận Huyện</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa quận huyện này không?</p>
                    <input type="hidden" id="ma_quan_huyen_delete" name="ma_quan_huyen">
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
        var ma_quan_huyen = button.data('ma_quan_huyen');
        var ten_quan_huyen = button.data('ten_quan_huyen');
        var modal = $(this);
        modal.find('.modal-body #ma_quan_huyen_update').val(ma_quan_huyen);
        modal.find('.modal-body #ten_quan_huyen_update').val(ten_quan_huyen);
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var ma_quan_huyen = button.data('ma_quan_huyen');
        var modal = $(this);
        modal.find('.modal-body #ma_quan_huyen_delete').val(ma_quan_huyen);
    });
});
</script>

<?php include 'footer.php'; ?>

