
<!-- HEADER -->
<div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom bg-white shadow-sm">
    <div>
        <h2 class="fw-bold mb-0">Tác giả</h2>
        <p class="text-muted mb-0 small"> Các tác giả sách hiện có</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAuthorModal">
        <i class="ti ti-plus me-1"></i>Thêm tác giả
    </button>
</div>

<div class="container-xl mt-4">
    
    <!-- THÔNG BÁO -->
    <?php if (!empty($success)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check me-2"></i><?php echo htmlspecialchars($success); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-alert-circle me-2"></i><?php echo htmlspecialchars($error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- BẢNG tác giả -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="card-title mb-0">Danh sách tác giả</h3>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0" 
                               id="searchInput"
                               placeholder="Tìm kiếm tác giả...">
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="authorTable">
                <thead class="bg-light">
                    <tr>
                        <th>Tên tác giả</th>
                        <th style="width: 300px;"> Quốc gia </th>
                        <th style="width: 120px;" class="text-center">Ngày sinh</th>
                        <th style="width: 100px;" class="text-center">Số sách</th>
                        <th style="width: 150px;" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($authors)): ?>
                        <?php foreach ($authors as $author): ?>
                            <tr data-author-id="<?php echo $author['author_id']; ?>">

                                <!-- TÊN tác giả -->
                                <td>
                                    <div class="fw-bold"><?php echo htmlspecialchars($author['author_name']); ?></div>
                                    <?php if (!empty($author['biography'])): ?>
                                        <div class="text-muted small text-truncate" style="max-width: 300px;">
                                            <?php echo htmlspecialchars($author['biography']); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>


                                <!-- QUỐC TỊCH -->
                                <td>
                                    <?php if (!empty($author['nationality'])): ?>
                                        <span class="badge bg-info-lt">
                                            <?php echo htmlspecialchars($author['nationality']); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted small">Chưa cập nhật</span>
                                    <?php endif; ?>
                                </td>

                                <!-- NGÀY SINH -->
                                <td class="text-center">
                                    <?php if (!empty($author['birth_date'])): ?>
                                        <small><?php echo date('d/m/Y', strtotime($author['birth_date'])); ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>

                                <!-- SỐ SÁCH -->
                                <td class="text-center">
                                    <span class="badge bg-info-lt fs-6">
                                        <?php echo $author['book_count'] ?? 0; ?> sách
                                    </span>
                                </td>


                                <!-- THAO TÁC -->
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <!-- Sửa -->
                                        <button type="button" 
                                                class="btn btn-sm btn-icon btn-outline-primary"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editAuthorModal"
                                                onclick="editAuthor(<?php echo htmlspecialchars(json_encode($author)); ?>)"
                                                title="Sửa">
                                            <i class="ti ti-edit"></i>
                                        </button>

                                        <!-- Xóa -->
                                        <button type="button" 
                                                class="btn btn-sm btn-icon btn-outline-danger"
                                                onclick="deleteAuthor(<?php echo $author['author_id']; ?>, '<?php echo htmlspecialchars($author['author_name']); ?>')"
                                                title="Xóa">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty">
                                    <div class="empty-img">
                                        <i class="ti ti-folder-x" style="font-size: 4rem; opacity: 0.3;"></i>
                                    </div>
                                    <p class="empty-title">Chưa có tác giả nào</p>
                                    <p class="empty-subtitle text-muted">
                                        Nhấn nút "Thêm tác giả" để tạo tác giả mới
                                    </p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION (Nếu cần) -->
        <?php if (!empty($authors) && count($authors) > 10): ?>
        <div class="card-footer d-flex align-items-center">
            <p class="m-0 text-muted">Hiển thị <span>1</span> đến <span>10</span> trong tổng số <strong><?php echo count($authors); ?></strong> tác giả</p>
            <ul class="pagination m-0 ms-auto">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">
                        <i class="ti ti-chevron-left"></i> Trước
                    </a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">
                        Sau <i class="ti ti-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </div>
        <?php endif; ?>

    </div>

</div>

<!-- ========================================
     MODAL THÊM TÁC GIẢ
     ======================================== -->
<div class="modal fade" id="addAuthorModal" tabindex="-1" aria-labelledby="addAuthorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo WEBROOT; ?>/admin/authorAddProcess" method="POST">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="addAuthorModalLabel">
                        <i class="ti ti-user-plus me-2"></i>Thêm tác giả mới
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    
                    <!-- Tên tác giả -->
                    <div class="mb-3">
                        <label class="form-label required">Tên tác giả</label>
                        <input type="text" 
                               class="form-control" 
                               name="author_name" 
                               placeholder="VD: Nguyễn Nhật Ánh"
                               required>
                    </div>

                    <div class="row">
                        <!-- Quốc tịch -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quốc tịch</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="nationality" 
                                   placeholder="VD: Việt Nam">
                        </div>

                        <!-- Ngày sinh -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ngày sinh</label>
                            <input type="date" 
                                   class="form-control" 
                                   name="birth_date">
                        </div>
                    </div>

                    <!-- Tiểu sử -->
                    <div class="mb-3">
                        <label class="form-label">Tiểu sử</label>
                        <textarea class="form-control" 
                                  name="biography" 
                                  rows="4"
                                  placeholder="Nhập tiểu sử ngắn gọn về tác giả..."></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i>Hủy
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i>Lưu tác giả
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- ========================================
     MODAL SỬA TÁC GIẢ
     ======================================== -->
<div class="modal fade" id="editAuthorModal" tabindex="-1" aria-labelledby="editAuthorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo WEBROOT; ?>/admin/authorUpdateProcess" method="POST" id="editAuthorForm">
                
                <input type="hidden" name="author_id" id="editAuthorId">

                <div class="modal-header">
                    <h5 class="modal-title" id="editAuthorModalLabel">
                        <i class="ti ti-edit me-2"></i>Chỉnh sửa tác giả
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    
                    <!-- Tên tác giả -->
                    <div class="mb-3">
                        <label class="form-label required">Tên tác giả</label>
                        <input type="text" 
                               class="form-control" 
                               name="author_name" 
                               id="editAuthorName"
                               required>
                    </div>

                    <div class="row">
                        <!-- Quốc tịch -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quốc tịch</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="nationality" 
                                   id="editAuthorNationality">
                        </div>

                        <!-- Ngày sinh -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ngày sinh</label>
                            <input type="date" 
                                   class="form-control" 
                                   name="birth_date"
                                   id="editAuthorBirthDate">
                        </div>
                    </div>

                    <!-- Tiểu sử -->
                    <div class="mb-3">
                        <label class="form-label">Tiểu sử</label>
                        <textarea class="form-control" 
                                  name="biography" 
                                  rows="4"
                                  id="editAuthorBiography"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i>Hủy
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i>Cập nhật
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- ========================================
     JAVASCRIPT
     ======================================== -->
<script>
// HÀM ĐIỀN DỮ LIỆU VÀO FORM SỬA
function editAuthor(author) {
    document.getElementById('editAuthorId').value = author.author_id;
    document.getElementById('editAuthorName').value = author.author_name;
    document.getElementById('editAuthorNationality').value = author.nationality || '';
    document.getElementById('editAuthorBirthDate').value = author.birth_date || '';
    document.getElementById('editAuthorBiography').value = author.biography || '';
}

// HÀM XÓA TÁC GIẢ
function deleteAuthor(id, name) {
    if (confirm(`Bạn có chắc muốn xóa tác giả "${name}"?\n\nLưu ý: Không thể xóa nếu tác giả có sách.`)) {
        window.location.href = '<?php echo WEBROOT; ?>/admin/authorDelete/' + id;
    }
}

// HÀM XÓA DẤU TIẾNG VIỆT
function removeVietnameseTones(str) {
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a"); 
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e"); 
    str = str.replace(/ì|í|ị|ỉ|ĩ/g,"i"); 
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o"); 
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u"); 
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y"); 
    str = str.replace(/đ/g,"d");
    str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
    str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
    str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
    str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
    str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
    str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
    str = str.replace(/Đ/g, "D");
    return str.toLowerCase().trim();
}

// TÌM KIẾM TÁC GIẢ
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    const keyword = removeVietnameseTones(e.target.value);
    const rows = document.querySelectorAll('#authorTable tbody tr');
    
    rows.forEach(row => {
        const nameCol = row.cells[0]?.innerText || '';
        const nationalityCol = row.cells[1]?.innerText || '';
        
        const rowText = removeVietnameseTones(nameCol + " " + nationalityCol);
        
        if (rowText.includes(keyword)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

<style>
.btn-icon {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.table > tbody > tr > td {
    vertical-align: middle;
}

.empty-img i {
    color: #cbd5e1;
}
</style>