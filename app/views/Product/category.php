<div class="container">
    <nav aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo WEBROOT; ?>" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?php echo WEBROOT; ?>/product" class="text-decoration-none">Sản phẩm</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo isset($title) ? $title : 'Danh mục'; ?></li>
        </ol>
    </nav>

    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-primary border-bottom pb-2">
                <i class="fas fa-book me-2"></i><?php echo isset($title) ? $title : 'Danh mục sản phẩm'; ?>
            </h2>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
        <?php if (!empty($paginatedProducts)): ?>
            <?php foreach ($paginatedProducts as $book): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        
                        <div class="position-relative" style="height: 300px; overflow: hidden;">
                            <?php 
                                $imgName = !empty($book['cover_image']) ? $book['cover_image'] : 'default-book.jpg';
                                $imgPath = WEBROOT . '/public/images/' . $imgName;

                                $hasDiscount = isset($book['discount_price']) && $book['discount_price'] !== null && (float)$book['discount_price'] < (float)$book['price'];
                                $finalPrice = $hasDiscount ? $book['discount_price'] : $book['price'];
                            ?>
                            <a href="<?php echo WEBROOT; ?>/product/detail/<?php echo (int)$book['book_id']; ?>" class="text-decoration-none d-block">
                                <img src="<?php echo htmlspecialchars($imgPath); ?>" 
                                     class="card-img-top w-100 h-100 object-fit-cover" 
                                     alt="<?php echo htmlspecialchars($book['title']); ?>"
                                     onerror="this.src='<?php echo WEBROOT; ?>/public/images/default-book.jpg'">
                                
                                <?php if ($hasDiscount): ?>
                                    <span class="position-absolute top-0 start-0 badge bg-danger m-2">
                                        Giảm giá
                                    </span>
                                <?php endif; ?>
                            </a>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title text-truncate" title="<?php echo htmlspecialchars($book['title']); ?>">
                                <a href="<?php echo WEBROOT; ?>/product/detail/<?php echo (int)$book['book_id']; ?>" class="text-decoration-none text-dark fw-bold">
                                    <?php echo htmlspecialchars($book['title']); ?>
                                </a>
                            </h6>
                            
                            <small class="text-muted mb-2">
                                Tác giả: <?php echo !empty($book['author_name']) ? htmlspecialchars($book['author_name']) : 'Đang cập nhật'; ?>
                            </small>

                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="text-start">
                                        <span class="fs-5 fw-bold text-danger"><?php echo number_format($finalPrice, 0, ',', '.'); ?>đ</span>
                                    </div>
                                    <div class="text-end">
                                        <?php if ($hasDiscount): ?>
                                            <small class="text-decoration-line-through text-muted">
                                                <?php echo number_format((float)$book['price'], 0, ',', '.'); ?>đ
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <form action="<?php echo WEBROOT; ?>/cart/add" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo (int)$book['book_id']; ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    
                                    <?php if (isset($book['stock_quantity']) && $book['stock_quantity'] > 0): ?>
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-cart-plus me-1"></i> Thêm giỏ hàng
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                <i class="fas fa-ban me-1"></i> Hết hàng
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-box-open fa-3x mb-3"></i><br>
                    Hiện tại chưa có sản phẩm nào trong danh mục này.
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if ($totalPage > 1): ?>
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">
                <!-- Nút Previous -->
                <li class="page-item <?php echo ($currentPage == 1) ? 'disabled' : ''; ?>">
                    <?php if ($currentPage > 1): ?>
                        <a class="page-link" href="<?php echo WEBROOT; ?>/product/category/<?php echo $categorySlug; ?>?page=<?php echo $currentPage - 1; ?>">
                            <i class="fas fa-chevron-left"></i> Trước
                        </a>
                    <?php else: ?>
                        <span class="page-link">
                            <i class="fas fa-chevron-left"></i> Trước
                        </span>
                    <?php endif; ?>
                </li>

                <?php
                // Hiển thị trang đầu
                if ($currentPage > 3) {
                    echo '<li class="page-item"><a class="page-link" href="' . WEBROOT . '/product/category/' . $categorySlug . '?page=1">1</a></li>';
                    if ($currentPage > 4) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                }

                // Hiển thị các trang xung quanh trang hiện tại
                for ($i = max(1, $currentPage - 2); $i <= min($totalPage, $currentPage + 2); $i++) {
                    if ($i == $currentPage) {
                        echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="' . WEBROOT . '/product/category/' . $categorySlug . '?page=' . $i . '">' . $i . '</a></li>';
                    }
                }

                // Hiển thị trang cuối
                if ($currentPage < $totalPage - 2) {
                    if ($currentPage < $totalPage - 3) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                    echo '<li class="page-item"><a class="page-link" href="' . WEBROOT . '/product/category/' . $categorySlug . '?page=' . $totalPage . '">' . $totalPage . '</a></li>';
                }
                ?>

                <!-- Nút Next -->
                <li class="page-item <?php echo ($currentPage == $totalPage) ? 'disabled' : ''; ?>">
                    <?php if ($currentPage < $totalPage): ?>
                        <a class="page-link" href="<?php echo WEBROOT; ?>/product/category/<?php echo $categorySlug; ?>?page=<?php echo $currentPage + 1; ?>">
                            Sau <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php else: ?>
                        <span class="page-link">
                            Sau <i class="fas fa-chevron-right"></i>
                        </span>
                    <?php endif; ?>
                </li>
            </ul>
            
            <!-- Thông tin trang -->
            <div class="text-center text-muted mt-2">
                Trang <?php echo $currentPage; ?> / <?php echo $totalPage; ?> 
                (Tổng <?php echo $totalProducts; ?> sản phẩm)
            </div>
        </nav>
    <?php endif; ?>
</div>