<?php
include '../dao/user_dao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        addUser($_POST['ten_nguoi_dung'], $_POST['mat_khau']);
    } elseif (isset($_POST['update'])) {
        updateUser($_POST['ten_nguoi_dung'], $_POST['mat_khau']);
    } elseif (isset($_POST['delete'])) {
        deleteUser($_POST['ten_nguoi_dung']);
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$userList = getAllUsers();
?>

<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mt-4 text-uppercase text-center">Danh sách Người Dùng</h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Thêm mới</button>
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Tên Người Dùng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userList as $user): ?>
            <tr>
                <td><?php echo $user['ten_nguoi_dung']; ?></td>
                <td>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateModal" data-ten_nguoi_dung="<?php echo $user['ten_nguoi_dung']; ?>">Sửa</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-ten_nguoi_dung="<?php echo $user['ten_nguoi_dung']; ?>">Xóa</button>
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
                    <h5 class="modal-title" id="addModalLabel">Thêm Người Dùng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ten_nguoi_dung">Tên Người Dùng</label>
                        <input type="text" class="form-control" id="ten_nguoi_dung" name="ten_nguoi_dung" required>
                    </div>
                    <div class="form-group">
                        <label for="mat_khau">Mật Khẩu</label>
                        <input type="password" class="form-control" id="mat_khau" name="mat_khau" required>
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
                    <h5 class="modal-title" id="updateModalLabel">Cập Nhật Người Dùng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="ten_nguoi_dung_update" name="ten_nguoi_dung">
                    <div class="form-group">
                        <label for="mat_khau_update">Mật Khẩu</label>
                        <input type="password" class="form-control" id="mat_khau_update" name="mat_khau" required>
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
                    <h5 class="modal-title" id="deleteModalLabel">Xóa Người Dùng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa người dùng này không?</p>
                    <input type="hidden" id="ten_nguoi_dung_delete" name="ten_nguoi_dung">
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
        var ten_nguoi_dung = button.data('ten_nguoi_dung');
        var modal = $(this);
        modal.find('.modal-body #ten_nguoi_dung_update').val(ten_nguoi_dung);
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var ten_nguoi_dung = button.data('ten_nguoi_dung');
        var modal = $(this);
        modal.find('.modal-body #ten_nguoi_dung_delete').val(ten_nguoi_dung);
    });
});
</script>

<?php include 'footer.php'; ?>

