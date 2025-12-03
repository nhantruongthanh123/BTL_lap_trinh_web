
<!-- HEADER -->
<div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom bg-white shadow-sm">
    <div>
        <h2 class="fw-bold mb-0">Nhà xuất bản </h2>
        <p class="text-muted mb-0 small"> Danh sách các nhà xuất bản </p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPublisherModal">
        <i class="ti ti-plus me-1"></i>Thêm nhà xuất bản
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

    <!-- BẢNG nhà xuất bản -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="card-title mb-0">Danh sách nhà xuất bản</h3>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0" 
                               id="searchInput"
                               placeholder="Tìm kiếm nhà xuất bản...">
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="publisherTable">
                <thead class="bg-light">
                    <tr>
                        <th>Tên nhà xuất bản</th>
                        <th style="width: 300px;"> Số điện thoại </th>
                        <th style="width: 120px;" class="text-center">Email</th>
                        <th style="width: 100px;" class="text-center">Số sách</th>
                        <th style="width: 150px;" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($publishers)): ?>
                        <?php foreach ($publishers as $publisher): ?>
                            <tr data-publisher-id="<?php echo $publisher['publisher_id']; ?>">

                                <!-- TÊN nhà xuất bản -->
                                <td>
                                    <div class="fw-bold"><?php echo htmlspecialchars($publisher['publisher_name']); ?></div>
                                    <?php if (!empty($publisher['biography'])): ?>
                                        <div class="text-muted small text-truncate" style="max-width: 300px;">
                                            <?php echo htmlspecialchars($publisher['biography']); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>


                                <!-- So dien thoai -->
                                <td>
                                    <?php if (!empty($publisher['phone'])): ?>
                                        <span class="badge bg-info-lt">
                                            <?php echo htmlspecialchars($publisher['phone']); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted small">Chưa cập nhật</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Email -->
                                <td class="text-center">
                                    <?php if (!empty($publisher['email'])): ?>
                                        <small><?php echo htmlspecialchars($publisher['email']); ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>

                                <!-- SỐ SÁCH -->
                                <td class="text-center">
                                    <span class="badge bg-info-lt fs-6">
                                        <?php echo $publisher['book_count'] ?? 0; ?> sách
                                    </span>
                                </td>


                                <!-- THAO TÁC -->
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <!-- Sửa -->
                                        <button type="button" 
                                                class="btn btn-sm btn-icon btn-outline-primary"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editPublisherModal"
                                                onclick="editPublisher(<?php echo htmlspecialchars(json_encode($publisher)); ?>)"
                                                title="Sửa">
                                            <i class="ti ti-edit"></i>
                                        </button>

                                        <!-- Xóa -->
                                        <button type="button" 
                                                class="btn btn-sm btn-icon btn-outline-danger"
                                                onclick="deletePublisher(<?php echo $publisher['publisher_id']; ?>, '<?php echo htmlspecialchars($publisher['publisher_name']); ?>')"
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
                                    <p class="empty-title">Chưa có nhà xuất bản nào</p>
                                    <p class="empty-subtitle text-muted">
                                        Nhấn nút "Thêm nhà xuất bản" để tạo nhà xuất bản mới
                                    </p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION (Nếu cần) -->
        <?php if (!empty($publishers) && count($publishers) > 10): ?>
        <div class="card-footer d-flex align-items-center">
            <p class="m-0 text-muted">Hiển thị <span>1</span> đến <span>10</span> trong tổng số <strong><?php echo count($publishers); ?></strong> nhà xuất bản</p>
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
     MODAL THÊM NHÀ XUẤT BẢN
     ======================================== -->
<div class="modal fade" id="addPublisherModal" tabindex="-1" aria-labelledby="addPublisherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo WEBROOT; ?>/admin/publisherAddProcess" method="POST">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="addPublisherModalLabel">
                        <i class="ti ti-user-plus me-2"></i>Thêm nhà xuất bản mới
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    
                    <!-- Tên nhà xuất bản -->
                    <div class="mb-3">
                        <label class="form-label required">Tên nhà xuất bản</label>
                        <input type="text" 
                               class="form-control" 
                               name="publisher_name" 
                               placeholder="VD: Nhà xuất bản Trẻ"
                               required>
                    </div>

                    <div class="row">
                        <!-- Phone -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"> Số điện thoại </label>
                            <input type="text" 
                                   class="form-control" 
                                   name="phone" 
                                   placeholder="VD: 0123456789">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control" 
                                   name="email">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i>Hủy
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i>Lưu nhà xuất bản
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- ========================================
     MODAL SỬA TÁC GIẢ
     ======================================== -->
<div class="modal fade" id="editPublisherModal" tabindex="-1" aria-labelledby="editPublisherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo WEBROOT; ?>/admin/publisherUpdateProcess" method="POST" id="editPublisherForm">
                
                <input type="hidden" name="publisher_id" id="editPublisherId">

                <div class="modal-header">
                    <h5 class="modal-title" id="editPublisherModalLabel">
                        <i class="ti ti-edit me-2"></i>Chỉnh sửa nhà xuất bản
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    
                    <!-- Tên nhà xuất bản -->
                    <div class="mb-3">
                        <label class="form-label required">Tên nhà xuất bản</label>
                        <input type="text" 
                               class="form-control" 
                               name="publisher_name" 
                               id="editPublisherName"
                               required>
                    </div>

                    <div class="row">
                        <!-- Phone -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="phone" 
                                   id="editPublisherPhone">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control" 
                                   name="email"
                                   id="editPublisherEmail">
                        </div>
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
function editPublisher(publisher) {
    document.getElementById('editPublisherId').value = publisher.publisher_id;
    document.getElementById('editPublisherName').value = publisher.publisher_name;
    document.getElementById('editPublisherPhone').value = publisher.phone || '';
    document.getElementById('editPublisherEmail').value = publisher.email || '';
}

// HÀM XÓA NHÀ XUẤT BẢN
function deletePublisher(id, name) {
    if (confirm(`Bạn có chắc muốn xóa nhà xuất bản "${name}"?\n\nLưu ý: Không thể xóa nếu nhà xuất bản có sách.`)) {
        window.location.href = '<?php echo WEBROOT; ?>/admin/publisherDelete/' + id;
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
    const rows = document.querySelectorAll('#publisherTable tbody tr');
    
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