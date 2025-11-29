<div class="container">
    <nav aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo WEBROOT; ?>" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
        </ol>
    </nav>

    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-primary border-bottom pb-2">
                <i class="fas fa-book me-2"></i><?php echo isset($data['title']) ? $data['title'] : 'Danh sách sản phẩm'; ?>
            </h2>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $book): ?>
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

                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-cart-plus me-1"></i> Thêm giỏ hàng
                                    </button>
                                </div>
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
    
    <!-- Pagination (giữ nguyên nếu cần) -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled"><a class="page-link" href="#">Trước</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Sau</a></li>
        </ul>
    </nav>
</div>