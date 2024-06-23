<?php
include '../dao/thiet_bi_dao.php';
include '../dao/buu_cuc_dao.php';
include '../dao/quan_huyen_dao.php';
include '../dao/danh_muc_thiet_bi_dao.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $hinh_anh = '';
        if (!empty($_FILES['hinh_anh']['name'])) {
            $hinh_anh = hash_file('md5', $_FILES['hinh_anh']['tmp_name']) . '.' . pathinfo($_FILES['hinh_anh']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['hinh_anh']['tmp_name'], "../uploads/" . $hinh_anh);
        }
        addThietBi($_POST['ten_thiet_bi'], $_POST['ma_sn'], $hinh_anh, $_POST['ma_buu_cuc'], $_POST['ghi_chu'], $_POST['ma_danh_muc']);
    } elseif (isset($_POST['update'])) {
        $hinh_anh = '';
        if (!empty($_FILES['hinh_anh']['name'])) {
            $hinh_anh = hash_file('md5', $_FILES['hinh_anh']['tmp_name']) . '.' . pathinfo($_FILES['hinh_anh']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['hinh_anh']['tmp_name'], "../uploads/" . $hinh_anh);
        }
        updateThietBi($_POST['ma_thiet_bi'], $_POST['ten_thiet_bi'], $_POST['ma_sn'], $hinh_anh, $_POST['ma_buu_cuc'], $_POST['ghi_chu'], $_POST['ma_danh_muc']);
    } elseif (isset($_POST['delete'])) {
        deleteThietBi($_POST['ma_thiet_bi']);
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$thietBiList = getAllThietBi();
$danhMucThietBiList = getAllDanhMucThietBi();
$buuCucList = getAllBuuCuc();
$quanHuyenList = getAllQuanHuyen();
?>

<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mt-4 text-uppercase text-center">Danh sách Thiết Bị</h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Thêm mới</button>
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Mã Thiết Bị</th>
                <th>Tên Thiết Bị</th>
                <th>Số SN</th>
                <th>Hình Ảnh</th>
                <th>Bưu Cục</th>
                <th>Ghi Chú</th>
                <th>Danh Mục</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($thietBiList as $thietBi): ?>
            <tr>
                <td><?php echo $thietBi['ma_thiet_bi']; ?></td>
                <td><?php echo $thietBi['ten_thiet_bi']; ?></td>
                <td><?php echo $thietBi['ma_sn']; ?></td>
                <td>
                    <?php if ($thietBi['hinh_anh']): ?>
                    <img src="../uploads/<?php echo $thietBi['hinh_anh']; ?>" alt="Hình Ảnh" width="50">
                    <?php endif; ?>
                </td>
                <td><?php echo $thietBi['ten_buu_cuc']; ?></td>
                <td><?php echo $thietBi['ghi_chu']; ?></td>
                <td><?php echo $thietBi['ten_danh_muc']; ?></td>
                <td>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateModal" data-ma_thiet_bi="<?php echo $thietBi['ma_thiet_bi']; ?>" data-ten_thiet_bi="<?php echo $thietBi['ten_thiet_bi']; ?>" data-ma_sn="<?php echo $thietBi['ma_sn']; ?>" data-ma_buu_cuc="<?php echo $thietBi['ma_buu_cuc']; ?>" data-ghi_chu="<?php echo $thietBi['ghi_chu']; ?>" data-ma_danh_muc="<?php echo $thietBi['ma_danh_muc']; ?>" data-ma_quan_huyen="<?php echo $thietBi['ma_quan_huyen']; ?>">Sửa</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-ma_thiet_bi="<?php echo $thietBi['ma_thiet_bi']; ?>">Xóa</button>
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
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Thêm Thiết Bị</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ten_thiet_bi">Tên Thiết Bị</label>
                        <input type="text" class="form-control" id="ten_thiet_bi" name="ten_thiet_bi" required>
                    </div>
                    <div class="form-group">
                        <label for="ma_sn">Số SN</label>
                        <input type="text" class="form-control" id="ma_sn" name="ma_sn" required>
                    </div>
                    <div class="form-group">
                        <label for="hinh_anh">Hình Ảnh</label>
                        <input type="file" class="form-control" id="hinh_anh" name="hinh_anh">
                    </div>
                    <div class="form-group">
                        <label for="ma_quan_huyen">Quận/Huyện</label>
                        <select class="form-control" id="ma_quan_huyen" name="ma_quan_huyen" required>
                            <?php foreach ($quanHuyenList as $quanHuyen): ?>
                            <option value="<?php echo $quanHuyen['ma_quan_huyen']; ?>"><?php echo $quanHuyen['ten_quan_huyen']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ma_buu_cuc">Bưu Cục</label>
                        <select class="form-control" id="ma_buu_cuc" name="ma_buu_cuc" required>
                            <?php foreach ($buuCucList as $buuCuc): ?>
                            <option value="<?php echo $buuCuc['ma_buu_cuc']; ?>" data-ma_quan_huyen="<?php echo $buuCuc['ma_quan_huyen']; ?>"><?php echo $buuCuc['ten_buu_cuc']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ghi_chu">Ghi Chú</label>
                        <textarea class="form-control" id="ghi_chu" name="ghi_chu"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="ma_danh_muc">Danh Mục</label>
                        <select class="form-control" id="ma_danh_muc" name="ma_danh_muc" required>
                            <?php foreach ($danhMucThietBiList as $danhMuc): ?>
                            <option value="<?php echo $danhMuc['ma_danh_muc']; ?>"><?php echo $danhMuc['ten_danh_muc']; ?></option>
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
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Cập Nhật Thiết Bị</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="ma_thiet_bi_update" name="ma_thiet_bi">
                    <div class="form-group">
                        <label for="ten_thiet_bi_update">Tên Thiết Bị</label>
                        <input type="text" class="form-control" id="ten_thiet_bi_update" name="ten_thiet_bi" required>
                    </div>
                    <div class="form-group">
                        <label for="ma_sn_update">Số SN</label>
                        <input type="text" class="form-control" id="ma_sn_update" name="ma_sn" required>
                    </div>
                    <div class="form-group">
                        <label for="hinh_anh_update">Hình Ảnh</label>
                        <input type="file" class="form-control" id="hinh_anh_update" name="hinh_anh">
                    </div>
                    <div class="form-group">
                        <label for="ma_quan_huyen_update">Quận/Huyện</label>
                        <select class="form-control" id="ma_quan_huyen_update" name="ma_quan_huyen" required>
                            <?php foreach ($quanHuyenList as $quanHuyen): ?>
                            <option value="<?php echo $quanHuyen['ma_quan_huyen']; ?>"><?php echo $quanHuyen['ten_quan_huyen']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ma_buu_cuc_update">Bưu Cục</label>
                        <select class="form-control" id="ma_buu_cuc_update" name="ma_buu_cuc" required>
                            <?php foreach ($buuCucList as $buuCuc): ?>
                            <option value="<?php echo $buuCuc['ma_buu_cuc']; ?>" data-ma_quan_huyen="<?php echo $buuCuc['ma_quan_huyen']; ?>"><?php echo $buuCuc['ten_buu_cuc']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ghi_chu_update">Ghi Chú</label>
                        <textarea class="form-control" id="ghi_chu_update" name="ghi_chu"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="ma_danh_muc_update">Danh Mục</label>
                        <select class="form-control" id="ma_danh_muc_update" name="ma_danh_muc" required>
                            <?php foreach ($danhMucThietBiList as $danhMuc): ?>
                            <option value="<?php echo $danhMuc['ma_danh_muc']; ?>"><?php echo $danhMuc['ten_danh_muc']; ?></option>
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
                    <h5 class="modal-title" id="deleteModalLabel">Xóa Thiết Bị</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa thiết bị này không?</p>
                    <input type="hidden" id="ma_thiet_bi_delete" name="ma_thiet_bi">
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
    $(document).ready(function() {
    // Function to filter buu_cuc options based on selected quan_huyen
    function filterBuuCucOptions(quanHuyenElement, buuCucElement, selectedBuuCuc) {
        var selectedQuanHuyen = quanHuyenElement.val();
        buuCucElement.empty();
        <?php foreach ($buuCucList as $buuCuc): ?>
        if ('<?php echo $buuCuc['ma_quan_huyen']; ?>' === selectedQuanHuyen) {
            buuCucElement.append('<option value="<?php echo $buuCuc['ma_buu_cuc']; ?>"' + 
                                 ('<?php echo $buuCuc['ma_buu_cuc']; ?>' == selectedBuuCuc ? ' selected' : '') + 
                                 '><?php echo $buuCuc['ten_buu_cuc']; ?></option>');
        }
        <?php endforeach; ?>
    }

    // Handle showing the update modal and setting initial values
    $('#updateModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var ma_thiet_bi = button.data('ma_thiet_bi');
        var ten_thiet_bi = button.data('ten_thiet_bi');
        var ma_sn = button.data('ma_sn');
        var ma_buu_cuc = button.data('ma_buu_cuc');
        var ghi_chu = button.data('ghi_chu');
        var ma_danh_muc = button.data('ma_danh_muc');
        var ma_quan_huyen = button.data('ma_quan_huyen');
        var modal = $(this);

        modal.find('.modal-body #ma_thiet_bi_update').val(ma_thiet_bi);
        modal.find('.modal-body #ten_thiet_bi_update').val(ten_thiet_bi);
        modal.find('.modal-body #ma_sn_update').val(ma_sn);
        modal.find('.modal-body #ghi_chu_update').val(ghi_chu);
        modal.find('.modal-body #ma_danh_muc_update').val(ma_danh_muc);
        modal.find('.modal-body #ma_quan_huyen_update').val(ma_quan_huyen);

        // Populate and select buu_cuc options based on selected quan_huyen
        var buuCucDropdown = modal.find('.modal-body #ma_buu_cuc_update');
        filterBuuCucOptions(modal.find('.modal-body #ma_quan_huyen_update'), buuCucDropdown, ma_buu_cuc);
    });

    // Filter buu_cuc options based on selected quan_huyen in Add Modal
    $('#ma_quan_huyen, #ma_quan_huyen_update').on('change', function () {
        var form = $(this).closest('form');
        var buuCucDropdown = form.find('#ma_buu_cuc, #ma_buu_cuc_update');
        filterBuuCucOptions($(this), buuCucDropdown, null);
    });

    // Trigger change event to set initial state of buu_cuc dropdown in Add Modal
    $('#ma_quan_huyen').trigger('change');
});

});
</script>

<?php include 'footer.php'; ?>
