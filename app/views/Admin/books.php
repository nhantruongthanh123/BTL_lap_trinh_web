<div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom bg-white shadow-sm">
    <h2 class="fw-bold mb-0">Quản lý sách</h2>
</div>


<div class="card border-0 shadow-sm">
    <div class="card-header border-bottom-0">
        <h3 class="card-title">Danh sách sách</h3>
        <div class="card-actions d-flex gap-2 align-items-center">
        <a href="<?php echo WEBROOT; ?>/admin/bookAdd" class="btn btn-primary">
            <i class="ti ti-plus me-2"></i> Thêm mới
        </a>

        <div class="input-icon">
            <span class="input-icon-addon"><i class="ti ti-search"></i></span>
            <input type="text" class="form-control form-control-rounded" placeholder="Tìm kiếm sách...">
        </div>
        </div>

    </div>
    
    <div class="table-responsive">
        <table class="table table-vcenter card-table table-nowrap">
            <thead>
                <tr class="text-muted text-uppercase fs-6">
                    <th class="w-1">Sản phẩm</th> <th>Danh mục</th>
                    <th>Giá bán</th>
                    <th>Trạng thái</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($books)): ?>
                    <?php foreach($books as $book): ?>
                    <tr class="align-middle">
                        
                        <td>
                            <div class="d-flex py-1 align-items-center">
                                <?php 
                                    $imgName = !empty($book['cover_image']) ? $book['cover_image'] : 'default-book.jpg';
                                    $imgPath = WEBROOT . '/public/images/' . $imgName;
                                ?>
                                <span class="avatar avatar-lg me-3 rounded shadow-sm" 
                                      style="background-image: url(<?php echo $imgPath; ?>)"></span>
                                <div class="flex-fill">
                                    <div class="font-weight-bold text-dark mb-1"><?php echo htmlspecialchars($book['title']); ?></div>
                                    <div class="text-muted small">
                                        ID: <span class="text-primary">#<?php echo $book['book_id']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-blue-lt me-2"> <?php echo htmlspecialchars($book['category_name'] ?? 'Chưa phân loại'); ?></span>
                            </div>
                        </td>

                        <td>
                            <?php if($book['discount_price'] < $book['price']): ?>
                                <div class="fw-bold text-danger"><?php echo number_format($book['discount_price']); ?> ₫</div>
                                <div class="text-muted text-decoration-line-through small"><?php echo number_format($book['price']); ?> ₫</div>
                            <?php else: ?>
                                <div class="fw-bold text-dark"><?php echo number_format($book['price']); ?> ₫</div>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if($book['is_active'] == 1): ?>
                                <span class="badge bg-green-lt">
                                    <i class="ti ti-check me-1"></i> Hiển thị
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary-lt">
                                    <i class="ti ti-eye-off me-1"></i> Đã ẩn
                                </span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <div class="dropdown">
                                <button class="btn btn-action dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                    Thao tác
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="<?php echo WEBROOT; ?>/admin/book_edit/<?php echo $book['book_id']; ?>">
                                        <i class="ti ti-pencil me-2 text-primary"></i> Chỉnh sửa
                                    </a>
                                    <a class="dropdown-item text-danger" href="<?php echo WEBROOT; ?>/admin/book_delete/<?php echo $book['book_id']; ?>" onclick="return confirm('Xóa sách này?');">
                                        <i class="ti ti-trash me-2"></i> Xóa bỏ
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center text-muted py-5">Không có dữ liệu</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-muted">Hiển thị <span><?php echo count($books); ?></span> sách</p>
        <ul class="pagination m-0 ms-auto">
            <li class="page-item disabled"><a class="page-link" href="#">Trước</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">Sau</a></li>
        </ul>
    </div>
</div>