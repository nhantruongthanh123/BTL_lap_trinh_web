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

        <button id="resetFilter" class="btn btn-secondary btn-sm" style="display: none;">
            <i class="ti ti-x"></i> 
        </button>

        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-vcenter card-table table-nowrap">
            <thead>
                <tr class="text-muted text-uppercase fs-6">
                    <th class="w-1" style="width: 35%; min-width: 250px;">Sản phẩm</th> 
                    <th style=" width: 20%; min-width: 160px;">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    <i class="ti ti-category me-1"></i> Danh mục
                                </span>
                                <i class="ti ti-filter text-primary" style="font-size: 0.8rem;" title="Lọc theo danh mục"></i>
                            </div>

                            <select id="categoryFilter" 
                                    class="form-select form-select-sm border-0 bg-light text-primary fw-bold shadow-none" 
                                    style="font-size: 0.85rem; cursor: pointer;">
                                <option value="" class="text-dark">⚡ Tất cả danh mục</option>
                                
                                <?php if (!empty($categories)): ?>
                                    <?php foreach($categories as $cat): ?>
                                        <option value="<?php echo htmlspecialchars($cat['category_name']); ?>" class="text-dark">
                                            <?php echo htmlspecialchars($cat['category_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </th>
                    <th style="width: 20%; min-width: 150px;">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    <i class="ti ti-coin me-1"></i> Giá bán
                                </span>
                                <i class="ti ti-filter text-primary" style="font-size: 0.8rem;"></i>
                            </div>

                            <select id="priceFilter" 
                                    class="form-select form-select-sm border-0 bg-light text-primary fw-bold shadow-none" 
                                    style="font-size: 0.85rem; cursor: pointer;">
                                <option value="" class="text-dark">⚡ Tất cả mức giá</option>
                                <option value="0-50000" class="text-dark">&lt; 50K</option>
                                <option value="50000-100000" class="text-dark">50K - 100K</option>
                                <option value="100000-200000" class="text-dark">100K - 200K</option>
                                <option value="200000-500000" class="text-dark">200K - 500K</option>
                                <option value="500000-999999999" class="text-dark">&gt; 500K</option>
                            </select>
                        </div>
                    </th>
                    <th style="width: 20%;">Trạng thái</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($paginatedBooks)): ?>
                    <?php foreach($paginatedBooks as $book): ?>
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
            Hiển thị <span><?php echo count($books); ?></span> / <strong><?php echo $totalBooks; ?></strong> sách
        </p>
        
        <ul class="pagination m-0 ms-auto">
            
            <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo WEBROOT; ?>/admin/books?page=<?php echo $currentPage - 1; ?>" tabindex="-1">
                    <i class="ti ti-chevron-left"></i>
                </a>
            </li>

            <?php
                $range = 2; 
                
                for ($i = 1; $i <= $totalPages; $i++) {
                
                    if ($i == 1 || $i == $totalPages || ($i >= $currentPage - $range && $i <= $currentPage + $range)) {
                        ?>
                        <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                            <a class="page-link" href="<?php echo WEBROOT; ?>/admin/books?page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                        <?php
                    } 
                    elseif ($i == $currentPage - $range - 1 || $i == $currentPage + $range + 1) {
                        ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php
                    }
                }
            ?>

            <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo WEBROOT; ?>/admin/books?page=<?php echo $currentPage + 1; ?>">
                    <i class="ti ti-chevron-right"></i>
                </a>
            </li>
            
        </ul>
    </div>
</div>



<script>
    // 1. Hàm xóa dấu tiếng Việt
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

    // 2. Lưu dữ liệu
    const allBooks = <?php echo json_encode($books); ?>;
    
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const priceFilter = document.getElementById('priceFilter');
    const resetBtn = document.getElementById('resetFilter');
    const tableBody = document.querySelector('table tbody');
    const pagination = document.querySelector('.card-footer');
    
    // 3. State cho filters
    let currentFilters = {
        search: '',
        category: '',
        priceRange: ''
    };
    
    // 4. Hàm áp dụng tất cả filters
    function applyFilters() {
        let filtered = allBooks;
        
        // Filter theo search
        if (currentFilters.search !== '') {
            const keyword = removeVietnameseTones(currentFilters.search);
            filtered = filtered.filter(book => {
                const searchText = removeVietnameseTones(
                    book.title + ' ' + 
                    (book.category_name || '') + ' ' + 
                    (book.author_name || '') + ' ' +
                    (book.publisher_name || '') + ' ' +
                    book.book_id
                );
                return searchText.includes(keyword);
            });
        }
        
        // Filter theo category
        if (currentFilters.category !== '') {
            filtered = filtered.filter(book => 
                book.category_name === currentFilters.category
            );
        }
        
        // Filter theo giá
        if (currentFilters.priceRange !== '') {
            const [min, max] = currentFilters.priceRange.split('-').map(Number);
            filtered = filtered.filter(book => {
                const price = book.discount_price < book.price ? book.discount_price : book.price;
                return price >= min && price <= max;
            });
        }
        
        // Kiểm tra có filter nào active không
        const hasActiveFilter = currentFilters.search !== '' || 
                               currentFilters.category !== '' || 
                               currentFilters.priceRange !== '';
        
        // Hiển thị/ẩn nút reset và pagination
        if (hasActiveFilter) {
            resetBtn.style.display = 'inline-block';
            pagination.style.display = 'none';
        } else {
            resetBtn.style.display = 'none';
            pagination.style.display = 'flex';
        }
        
        renderBooks(filtered);
    }
    
    // 5. Event listeners
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            currentFilters.search = e.target.value;
            applyFilters();
        });
    }
    
    if (categoryFilter) {
        categoryFilter.addEventListener('change', function(e) {
            currentFilters.category = e.target.value;
            applyFilters();
        });
    }
    
    if (priceFilter) {
        priceFilter.addEventListener('change', function(e) {
            currentFilters.priceRange = e.target.value;
            applyFilters();
        });
    }
    
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            currentFilters = { search: '', category: '', priceRange: '' };
            searchInput.value = '';
            categoryFilter.value = '';
            priceFilter.value = '';
            location.reload();
        });
    }
    
    // 6. Hàm render sách
    function renderBooks(books) {
        if (books.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-5">Không tìm thấy sách phù hợp</td></tr>';
            return;
        }
        
        let html = '';
        books.forEach(book => {
            const imgName = book.cover_image || 'default-book.jpg';
            const imgPath = '<?php echo WEBROOT; ?>/public/images/' + imgName;
            const isDiscount = book.discount_price < book.price;
            const isActive = book.is_active == 1;
            
            html += `
                <tr class="align-middle">
                    <td>
                        <div class="d-flex py-1 align-items-center">
                            <span class="avatar avatar-lg me-3 rounded shadow-sm" 
                                style="background-image: url(${imgPath})"></span>
                            <div class="flex-fill">
                                <div class="font-weight-bold text-dark mb-1">${escapeHtml(book.title)}</div>
                                <div class="text-muted small">
                                    ID: <span class="text-primary">#${book.book_id}</span>
                                    ${book.author_name ? ' • ' + escapeHtml(book.author_name) : ''}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-blue-lt me-2">${escapeHtml(book.category_name || 'Chưa phân loại')}</span>
                        </div>
                    </td>
                    <td>
                        ${isDiscount ? `
                            <div class="fw-bold text-danger">${formatPrice(book.discount_price)} ₫</div>
                            <div class="text-muted text-decoration-line-through small">${formatPrice(book.price)} ₫</div>
                        ` : `
                            <div class="fw-bold text-dark">${formatPrice(book.price)} ₫</div>
                        `}
                    </td>
                    <td>
                        ${isActive ? `
                            <span class="badge bg-green-lt">
                                <i class="ti ti-check me-1"></i> Hiển thị
                            </span>
                        ` : `
                            <span class="badge bg-secondary-lt">
                                <i class="ti ti-eye-off me-1"></i> Đã ẩn
                            </span>
                        `}
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-action dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                Thao tác
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="<?php echo WEBROOT; ?>/admin/editBook/${book.book_id}">
                                    <i class="ti ti-pencil me-2 text-primary"></i> Chỉnh sửa
                                </a>
                                <a class="dropdown-item text-danger" href="<?php echo WEBROOT; ?>/admin/deleteBook/${book.book_id}" onclick="return confirm('Xóa sách này?');">
                                    <i class="ti ti-trash me-2"></i> Xóa bỏ
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            `;
        });
        
        tableBody.innerHTML = html;
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN').format(price);
    }
</script>