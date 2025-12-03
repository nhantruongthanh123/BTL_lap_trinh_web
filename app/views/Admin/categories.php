
<!-- HEADER -->
<div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom bg-white shadow-sm">
    <div>
        <h2 class="fw-bold mb-0">Danh mục sách</h2>
        <p class="text-muted mb-0 small">Quản lý các danh mục sách của cửa hàng</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        <i class="ti ti-plus me-1"></i>Thêm danh mục
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

    <!-- BẢNG DANH MỤC -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="card-title mb-0">Danh sách danh mục</h3>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0" 
                               id="searchInput"
                               placeholder="Tìm kiếm danh mục...">
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="categoryTable">
                <thead class="bg-light">
                    <tr>
                        <th>Tên danh mục</th>
                        <th style="width: 200px;">Slug (URL)</th>
                        <th style="width: 200px;" class="text-center">Số sách</th>
                        <th style="width: 120px;" class="text-center">Trạng thái</th>
                        <th style="width: 200px;" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <tr data-category-id="<?php echo $category['category_id']; ?>">

                                <!-- TÊN DANH MỤC -->
                                <td>
                                    <div class="fw-bold"><?php echo htmlspecialchars($category['category_name']); ?></div>
                                    <?php if (!empty($category['description'])): ?>
                                        <div class="text-muted small text-truncate" style="max-width: 300px;">
                                            <?php echo htmlspecialchars($category['description']); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>


                                <!-- SLUG -->
                                <td>
                                    <code class="text-muted small"><?php echo htmlspecialchars($category['slug']); ?></code>
                                </td>

                                <!-- SỐ SÁCH -->
                                <td class="text-center">
                                    <span class="badge bg-info-lt fs-6">
                                        <?php echo $category['book_count'] ?? 0; ?> sách
                                    </span>
                                </td>

                                <!-- TRẠNG THÁI -->
                                <td class="text-center">
                                    <?php if ($category['is_active']): ?>
                                        <span class="badge bg-success">
                                            <i class="ti ti-check me-1"></i>Hiển thị
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">
                                            <i class="ti ti-x me-1"></i>Ẩn
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <!-- THAO TÁC -->
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <!-- Sửa -->
                                        <button type="button" 
                                                class="btn btn-sm btn-icon btn-outline-primary"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editCategoryModal"
                                                onclick="editCategory(<?php echo htmlspecialchars(json_encode($category)); ?>)"
                                                title="Sửa">
                                            <i class="ti ti-edit"></i>
                                        </button>

                                        <!-- Xem sách -->
                                        <a href="<?php echo WEBROOT; ?>/admin/books?category=<?php echo $category['category_id']; ?>" 
                                           class="btn btn-sm btn-icon btn-outline-info"
                                           title="Xem sách">
                                            <i class="ti ti-eye"></i>
                                        </a>

                                        <!-- Xóa -->
                                        <button type="button" 
                                                class="btn btn-sm btn-icon btn-outline-danger"
                                                onclick="deleteCategory(<?php echo $category['category_id']; ?>, '<?php echo htmlspecialchars($category['category_name']); ?>')"
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
                                    <p class="empty-title">Chưa có danh mục nào</p>
                                    <p class="empty-subtitle text-muted">
                                        Nhấn nút "Thêm danh mục" để tạo danh mục mới
                                    </p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION (Nếu cần) -->
        <?php if (!empty($categories) && count($categories) > 10): ?>
        <div class="card-footer d-flex align-items-center">
            <p class="m-0 text-muted">Hiển thị <span>1</span> đến <span>10</span> trong tổng số <strong><?php echo count($categories); ?></strong> danh mục</p>
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
     MODAL THÊM DANH MỤC
     ======================================== -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo WEBROOT; ?>/admin/categoryAddProcess" method="POST" enctype="multipart/form-data">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">
                        <i class="ti ti-folder-plus me-2"></i>Thêm danh mục mới
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        
                        <!-- CỘT TRÁI -->
                        <div class="col-md-8">
                            
                            <!-- Tên danh mục -->
                            <div class="mb-3">
                                <label class="form-label required">Tên danh mục</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="category_name" 
                                       placeholder="VD: Văn học nước ngoài"
                                       required
                                       id="categoryNameInput">
                            </div>

                            <!-- Slug -->
                            <div class="mb-3">
                                <label class="form-label">Slug (URL thân thiện)</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="slug" 
                                       placeholder="van-hoc-nuoc-ngoai"
                                       id="categorySlugInput">
                                <small class="form-hint">Tự động tạo nếu bỏ trống</small>
                            </div>

                            <!-- Mô tả -->
                            <div class="mb-3">
                                <label class="form-label">Mô tả</label>
                                <textarea class="form-control" 
                                          name="description" 
                                          rows="3"
                                          placeholder="Nhập mô tả ngắn về danh mục..."></textarea>
                            </div>

                        </div>

                        <!-- CỘT PHẢI -->
                        <div class="col-md-4">

                            <!-- Trạng thái -->
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="is_active" 
                                       id="addIsActive"
                                       value="1"
                                       checked>
                                <label class="form-check-label" for="addIsActive">
                                    Hiển thị trên website
                                </label>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i>Hủy
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i>Lưu danh mục
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- ========================================
     MODAL SỬA DANH MỤC
     ======================================== -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo WEBROOT; ?>/admin/categoryUpdateProcess" method="POST" enctype="multipart/form-data" id="editCategoryForm">
                
                <input type="hidden" name="category_id" id="editCategoryId">

                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">
                        <i class="ti ti-edit me-2"></i>Chỉnh sửa danh mục
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        
                        <!-- CỘT TRÁI -->
                        <div class="col-md-8">
                            
                            <!-- Tên danh mục -->
                            <div class="mb-3">
                                <label class="form-label required">Tên danh mục</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="category_name" 
                                       id="editCategoryName"
                                       required>
                            </div>

                            <!-- Slug -->
                            <div class="mb-3">
                                <label class="form-label">Slug (URL thân thiện)</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="slug" 
                                       id="editCategorySlug">
                            </div>

                            <!-- Mô tả -->
                            <div class="mb-3">
                                <label class="form-label">Mô tả</label>
                                <textarea class="form-control" 
                                          name="description" 
                                          rows="3"
                                          id="editCategoryDescription"></textarea>
                            </div>

                        </div>

                        <!-- CỘT PHẢI -->
                        <div class="col-md-4">
                            <!-- Trạng thái -->
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="is_active" 
                                       id="editIsActive"
                                       value="1">
                                <label class="form-check-label" for="editIsActive">
                                    Hiển thị trên website
                                </label>
                            </div>

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
// TỰ ĐỘNG TẠO SLUG KHI NHẬP TÊN
document.getElementById('categoryNameInput')?.addEventListener('input', function(e) {
    const name = e.target.value;
    const slug = createSlug(name);
    document.getElementById('categorySlugInput').value = slug;
});

// HÀM TẠO SLUG
function createSlug(text) {
    const from = "àáãảạăằắẳẵặâầấẩẫậèéẻẽẹêềếểễệđùúủũụưừứửữựòóỏõọôồốổỗộơờớởỡợìíỉĩịäëïîöüûñçýỳỹỵỷ";
    const to   = "aaaaaaaaaaaaaaaaaeeeeeeeeeeeduuuuuuuuuuuoooooooooooooooooiiiiiaeiiouuncyyyyy";
    
    for (let i = 0, l = from.length; i < l; i++) {
        text = text.replace(new RegExp(from[i], "gi"), to[i]);
    }
    
    return text.toLowerCase()
        .trim()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
}


// HÀM ĐIỀN DỮ LIỆU VÀO FORM SỬA
function editCategory(category) {
    document.getElementById('editCategoryId').value = category.category_id;
    document.getElementById('editCategoryName').value = category.category_name;
    document.getElementById('editCategorySlug').value = category.slug || '';
    document.getElementById('editCategoryDescription').value = category.description || '';
    document.getElementById('editIsActive').checked = category.is_active == 1;
    
}

// HÀM XÓA DANH MỤC
function deleteCategory(id, name) {
    if (confirm(`Bạn có chắc muốn xóa danh mục "${name}"?\n\nLưu ý: Các sách thuộc danh mục này sẽ không bị xóa.`)) {
        window.location.href = '<?php echo WEBROOT; ?>/admin/categoryDelete/' + id;
    }
}


    // Hàm xóa dấu tiếng Việt để tìm kiếm thông minh
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
        str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, ""); // 
        return str.toLowerCase().trim();
    }

    document.getElementById('searchInput')?.addEventListener('input', function(e) {
        const keyword = removeVietnameseTones(e.target.value); 
        const table = document.querySelector('.table tbody');
        const rows = table.querySelectorAll('tr');
        
        rows.forEach(row => {
            
            const nameCol = row.cells[0]?.innerText || ''; 
            const slugCol = row.cells[1]?.innerText || '';
            
            const rowText = removeVietnameseTones(nameCol + " " + slugCol);
            
            if (rowText.includes(keyword)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<style>
/* CUSTOM STYLES */
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

code {
    background-color: #f1f3f5;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 0.85em;
}

.empty-img i {
    color: #cbd5e1;
}
</style>