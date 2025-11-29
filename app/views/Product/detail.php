<?php 
$book = $data['book'];
$relatedBooks = $data['relatedBooks'];

// Xử lý ảnh
$imgName = !empty($book['cover_image']) ? $book['cover_image'] : 'default-book.jpg';
$imgPath = WEBROOT . '/public/images/' . $imgName;

// Tính giá
$hasDiscount = isset($book['discount_price']) && $book['discount_price'] !== null && (float)$book['discount_price'] < (float)$book['price'];
$finalPrice = $hasDiscount ? $book['discount_price'] : $book['price'];

?>

<div class="container my-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo WEBROOT; ?>">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?php echo WEBROOT; ?>/product">Sản phẩm</a></li>
            <li class="breadcrumb-item">
                <a href="<?php echo WEBROOT; ?>/product/category/<?php echo htmlspecialchars($book['category_slug']); ?>">
                    <?php echo htmlspecialchars($book['category_name']); ?>
                </a>
            </li>
            <li class="breadcrumb-item active"><?php echo htmlspecialchars($book['title']); ?></li>
        </ol>
    </nav>

    <!-- Chi tiết sản phẩm -->
    <div class="row g-4">
        <!-- Hình ảnh -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="<?php echo $imgPath; ?>" 
                     class="card-img-top" 
                     alt="<?php echo htmlspecialchars($book['title']); ?>"
                     onerror="this.src='<?php echo WEBROOT; ?>/public/images/default-book.jpg'">
            </div>
        </div>

        <!-- Thông tin sách -->
        <div class="col-md-5">
            <h1 class="h3 fw-bold text-primary mb-3"><?php echo htmlspecialchars($book['title']); ?></h1>
            
            <div class="mb-3">
                <span class="text-muted">Tác giả:</span>
                <strong class="text-dark"><?php echo htmlspecialchars($book['author_name']); ?></strong>
            </div>

            <div class="mb-3">
                <span class="text-muted">Nhà xuất bản:</span>
                <strong class="text-dark"><?php echo htmlspecialchars($book['publisher_name']); ?></strong>
            </div>

            <div class="mb-3">
                <span class="text-muted">Thể loại:</span>
                <a href="<?php echo WEBROOT; ?>/product/category/<?php echo htmlspecialchars($book['category_slug']); ?>" 
                   class="badge bg-primary text-decoration-none">
                    <?php echo htmlspecialchars($book['category_name']); ?>
                </a>
            </div>

            <?php if (!empty($book['isbn'])): ?>
            <div class="mb-3">
                <span class="text-muted">ISBN:</span>
                <code><?php echo htmlspecialchars($book['isbn']); ?></code>
            </div>
            <?php endif; ?>

            <div class="mb-3">
                <span class="text-muted">Tình trạng:</span>
                <?php if ($book['stock_quantity'] > 0): ?>
                    <span class="badge bg-success">Còn hàng (<?php echo $book['stock_quantity']; ?>)</span>
                <?php else: ?>
                    <span class="badge bg-danger">Hết hàng</span>
                <?php endif; ?>
            </div>

            <!-- Giá -->
            <div class="card bg-light border-0 mb-4">
                <div class="card-body">
                    <?php if ($hasDiscount): ?>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <h2 class="text-danger fw-bold mb-0"><?php echo number_format($finalPrice, 0, ',', '.'); ?>đ</h2>
                            <span class="badge bg-danger"><?php echo "Giảm giá"; ?></span>
                        </div>
                        <del class="text-muted"><?php echo number_format($book['price'], 0, ',', '.'); ?>đ</del>
                    <?php else: ?>
                        <h2 class="text-danger fw-bold mb-0"><?php echo number_format($finalPrice, 0, ',', '.'); ?>đ</h2>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Mô tả ngắn -->
            <?php if (!empty($book['description'])): ?>
            <div class="mb-4">
                <h5 class="fw-bold">Mô tả</h5>
                <p class="text-muted"><?php echo nl2br(htmlspecialchars($book['description'])); ?></p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Form mua hàng -->
        <div class="col-md-3">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h5 class="card-title mb-3">Thêm vào giỏ hàng</h5>
                    
                    <form action="<?php echo WEBROOT; ?>/cart/add" method="POST">
                        <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Số lượng</label>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button" onclick="decreaseQty()">-</button>
                                <input type="number" class="form-control text-center" name="quantity" 
                                       id="quantity" value="1" min="1" max="<?php echo $book['stock_quantity']; ?>">
                                <button class="btn btn-outline-secondary" type="button" onclick="increaseQty()">+</button>
                            </div>
                        </div>

                        <?php if ($book['stock_quantity'] > 0): ?>
                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-cart-plus me-2"></i>Thêm vào giỏ
                            </button>
                            <button type="button" class="btn btn-danger w-100">
                                <i class="fas fa-shopping-bag me-2"></i>Mua ngay
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-secondary w-100" disabled>
                                Hết hàng
                            </button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sách liên quan -->
    <?php if (!empty($relatedBooks)): ?>
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold text-primary border-bottom pb-2 mb-4">
                <i class="fas fa-book me-2"></i>Sách liên quan
            </h3>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php foreach ($relatedBooks as $relatedBook): ?>
            <?php 
                $relatedImgName = !empty($relatedBook['cover_image']) ? $relatedBook['cover_image'] : 'default-book.jpg';
                $relatedImgPath = WEBROOT . '/public/images/' . $relatedImgName;
                
                $relatedHasDiscount = isset($relatedBook['discount_price']) && $relatedBook['discount_price'] !== null && (float)$relatedBook['discount_price'] < (float)$relatedBook['price'];
                $relatedFinalPrice = $relatedHasDiscount ? $relatedBook['discount_price'] : $relatedBook['price'];
                $relatedOriginalPrice = isset($relatedBook['price']) ? (float)$relatedBook['price'] : 0;
            ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <a href="<?php echo WEBROOT; ?>/product/detail/<?php echo (int)$relatedBook['book_id']; ?>" class="text-decoration-none">
                        <div class="position-relative overflow-hidden" style="height: 300px;">
                            <img src="<?php echo htmlspecialchars($relatedImgPath, ENT_QUOTES); ?>" 
                                class="card-img-top w-100 h-100 object-fit-cover" 
                                alt="<?php echo htmlspecialchars($relatedBook['title']); ?>"
                                onerror="this.src='<?php echo WEBROOT; ?>/public/images/default-book.jpg'">
                            <?php if ($relatedHasDiscount): ?>
                                <span class="position-absolute top-0 start-0 badge bg-danger m-2">Giảm giá</span>
                            <?php endif; ?>
                        </div>
                    </a>
                    <div class="card-body">
                        <h6 class="card-title text-truncate">
                            <a href="<?php echo WEBROOT; ?>/product/detail/<?php echo (int)$relatedBook['book_id']; ?>" 
                            class="text-decoration-none text-dark fw-bold">
                                <?php echo htmlspecialchars($relatedBook['title']); ?>
                            </a>
                        </h6>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-danger fw-bold">
                                <?php echo number_format($relatedFinalPrice, 0, ',', '.'); ?>đ
                            </span>
                            <?php if ($relatedHasDiscount): ?>
                                <small class="text-decoration-line-through text-muted">
                                    <?php echo number_format($relatedOriginalPrice, 0, ',', '.'); ?>đ
                                </small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

