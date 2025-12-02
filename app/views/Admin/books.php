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
                                    <a class="dropdown-item" href="<?php echo WEBROOT; ?>/admin/editBook/<?php echo $book['book_id']; ?>">
                                        <i class="ti ti-pencil me-2 text-primary"></i> Chỉnh sửa
                                    </a>
                                    <a class="dropdown-item text-danger" href="<?php echo WEBROOT; ?>/admin/deleteBook/<?php echo $book['book_id']; ?>" onclick="return confirm('Xóa sách này?');">
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
        <p class="m-0 text-muted">
            Hiển thị <span><?php echo count($books); ?></span> / <strong><?php echo $total_books; ?></strong> sách
        </p>
        
        <ul class="pagination m-0 ms-auto">
            
            <li class="page-item <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo WEBROOT; ?>/admin/books?page=<?php echo $current_page - 1; ?>" tabindex="-1">
                    <i class="ti ti-chevron-left"></i>
                </a>
            </li>

            <?php
                $range = 2; 
                
                for ($i = 1; $i <= $total_pages; $i++) {
                
                    if ($i == 1 || $i == $total_pages || ($i >= $current_page - $range && $i <= $current_page + $range)) {
                        ?>
                        <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                            <a class="page-link" href="<?php echo WEBROOT; ?>/admin/books?page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                        <?php
                    } 
                    elseif ($i == $current_page - $range - 1 || $i == $current_page + $range + 1) {
                        ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php
                    }
                }
            ?>

            <li class="page-item <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo WEBROOT; ?>/admin/books?page=<?php echo $current_page + 1; ?>">
                    <i class="ti ti-chevron-right"></i>
                </a>
            </li>
            
        </ul>
    </div>
</div>



<script>
    // 1. Hàm xóa dấu tiếng Việt (Tái sử dụng)
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
        str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, ""); 
        return str.toLowerCase().trim();
    }

    const searchInput = document.querySelector('input[placeholder="Tìm kiếm sách..."]');
    
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const keyword = removeVietnameseTones(e.target.value);
            const tableBody = document.querySelector('table tbody');
            const rows = tableBody.querySelectorAll('tr');
            
            rows.forEach(row => {
                const rowText = removeVietnameseTones(row.innerText);
                
                if (rowText.includes(keyword)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
</script>