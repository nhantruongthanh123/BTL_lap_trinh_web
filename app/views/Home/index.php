<div class="p-4 p-md-5 mb-4 rounded text-bg-dark" style="background: linear-gradient(45deg, #0d6efd, #0dcaf0);">
    <div class="col-md-6 px-0">
        <h1 class="display-4 fst-italic">Sách hay mỗi ngày</h1>
        <p class="lead my-3">Khám phá những tựa sách bán chạy nhất và nâng cao tri thức của bạn ngay hôm nay.</p>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h3 class="fw-bold text-primary"><i class="fas fa-fire me-2"></i>Sách Mới Nổi Bật</h3>
        <a href="<?php echo WEBROOT; ?>/product" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
    </div>
</div>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
    
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
                            <div class="position-relative" style="height: 300px; overflow: hidden;">
                                <img src="<?php echo htmlspecialchars($imgPath); ?>" 
                                    class="card-img-top w-100 h-100 object-fit-cover" 
                                    alt="<?php echo htmlspecialchars($book['title']); ?>"
                                    onerror="this.src='<?php echo WEBROOT; ?>/public/images/default-book.jpg'">
                                
                                <?php if ($hasDiscount): ?>
                                    <span class="position-absolute top-0 start-0 badge bg-danger m-2">
                                        Giảm giá
                                    </span>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title text-truncate" title="<?php echo $book['title']; ?>">
                            <a href="<?php echo WEBROOT; ?>/product/detail/<?php echo $book['book_id']; ?>" class="text-decoration-none text-dark fw-bold">
                                <?php echo $book['title']; ?>
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
                                    <?php else: ?>
                                        <span></span>
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
            <div class="alert alert-warning text-center">
                Hiện tại chưa có cuốn sách nào trong kho!
            </div>
        </div>
    <?php endif; ?>
    
</div>