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
            <div class="card shadow-sm sticky-top border-0" style="top: 100px; z-index: 100;">
                <div class="card-body">
                    <h5 class="card-title mb-3 fw-bold">Mua hàng</h5>
                    
                    <form action="<?php echo WEBROOT; ?>/cart/add" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo (int)$book['book_id']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Số lượng:</label>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                    <i class="fas fa-minus small"></i>
                                </button>
                                
                                <input type="number" class="form-control text-center fw-bold" name="quantity" 
                                    id="quantityInput" value="1" min="1" max="<?php echo $book['stock_quantity']; ?>">
                                    
                                <button class="btn btn-outline-secondary" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                    <i class="fas fa-plus small"></i>
                                </button>
                            </div>
                            <div class="form-text small mt-1 text-muted">
                                Kho: <?php echo $book['stock_quantity']; ?> sản phẩm
                            </div>
                        </div>

                        <?php if ($book['stock_quantity'] > 0): ?>
                            <button type="submit" class="btn btn-outline-primary w-100 mb-2 py-2">
                                <i class="fas fa-cart-plus me-2"></i>Thêm vào giỏ
                            </button>
                            
                            <button type="submit" name="action" value="buy_now" class="btn btn-danger w-100 py-2 fw-bold">
                                Mua ngay
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-secondary w-100 py-2" disabled>
                                <i class="fas fa-ban me-2"></i>Hết hàng
                            </button>
                            <small class="text-danger d-block text-center mt-2">Vui lòng quay lại sau</small>
                        <?php endif; ?>
                    </form>
                    
                    <hr class="my-3">
                    
                    <div class="small text-muted">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-truck me-2 text-success"></i> Giao hàng toàn quốc
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-shield-alt me-2 text-success"></i> Bảo hành đổi trả
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2 text-success"></i> Sách chính hãng 100%
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    
    <!-- Reviews List -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" 
                            data-bs-target="#description" type="button" role="tab">
                        <i class="fas fa-info-circle me-2"></i>Mô tả chi tiết
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specs-tab" data-bs-toggle="tab" 
                            data-bs-target="#specs" type="button" role="tab">
                        <i class="fas fa-list-ul me-2"></i>Thông số
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" 
                            data-bs-target="#reviews" type="button" role="tab">
                        <i class="fas fa-star me-2"></i>Đánh giá 
                        <span class="badge bg-primary"><?php echo $totalReviews; ?></span>
                    </button>
                </li>
            </ul>
            
            <div class="tab-content border border-top-0 p-4" id="productTabsContent">
                <!-- Tab Mô tả -->
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <?php if (!empty($book['description'])): ?>
                        <p class="text-muted"><?php echo nl2br(htmlspecialchars($book['description'])); ?></p>
                    <?php else: ?>
                        <p class="text-muted fst-italic">Chưa có mô tả chi tiết cho sản phẩm này.</p>
                    <?php endif; ?>
                </div>
                
                <!-- Tab Thông số -->
                <div class="tab-pane fade" id="specs" role="tabpanel">
                    <table class="table table-bordered">
                        <tbody>
                            <?php if (!empty($book['isbn'])): ?>
                            <tr>
                                <td class="fw-bold" style="width: 30%;">ISBN</td>
                                <td><?php echo htmlspecialchars($book['isbn']); ?></td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <td class="fw-bold">Tác giả</td>
                                <td><?php echo htmlspecialchars($book['author_name']); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Nhà xuất bản</td>
                                <td><?php echo htmlspecialchars($book['publisher_name']); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Thể loại</td>
                                <td><?php echo htmlspecialchars($book['category_name']); ?></td>
                            </tr>
                            <?php if (!empty($book['pages'])): ?>
                            <tr>
                                <td class="fw-bold">Số trang</td>
                                <td><?php echo htmlspecialchars($book['pages']); ?> trang</td>
                            </tr>
                            <?php endif; ?>
                            <?php if (!empty($book['language'])): ?>
                            <tr>
                                <td class="fw-bold">Ngôn ngữ</td>
                                <td><?php echo htmlspecialchars($book['language']); ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if (!empty($book['format'])): ?>
                            <tr>
                                <td class="fw-bold">Định dạng</td>
                                <td><?php echo htmlspecialchars($book['format']); ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if (!empty($book['publication_date'])): ?>
                            <tr>
                                <td class="fw-bold">Năm xuất bản</td>
                                <td><?php echo date('Y', strtotime($book['publication_date'])); ?></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Tab Đánh giá -->
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    <?php if ($totalReviews > 0): ?>
                        <!-- Thống kê đánh giá -->
                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <h2 class="display-4 fw-bold text-warning">
                                    <?php echo number_format($ratingStats['average_rating'], 1); ?>
                                </h2>
                                <div class="mb-2">
                                    <?php 
                                    $avgRating = round($ratingStats['average_rating']);
                                    for ($i = 1; $i <= 5; $i++): 
                                    ?>
                                        <i class="fas fa-star <?php echo $i <= $avgRating ? 'text-warning' : 'text-muted'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="text-muted"><?php echo $totalReviews; ?> đánh giá</p>
                            </div>
                            <div class="col-md-8">
                                <?php
                                $stars = [5, 4, 3, 2, 1];
                                foreach ($stars as $star):
                                    $count = $ratingStats[$star == 5 ? 'five_star' : ($star == 4 ? 'four_star' : ($star == 3 ? 'three_star' : ($star == 2 ? 'two_star' : 'one_star')))];
                                    $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                ?>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="me-2" style="width: 60px;"><?php echo $star; ?> sao</span>
                                    <div class="progress flex-grow-1" style="height: 8px;">
                                        <div class="progress-bar bg-warning" role="progressbar" 
                                             style="width: <?php echo $percentage; ?>%"></div>
                                    </div>
                                    <span class="ms-2 text-muted" style="width: 50px;"><?php echo $count; ?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <hr>
                    <?php endif; ?>
                    
                    <!-- Form viết đánh giá -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($canReview): ?>
                        <div class="card mb-4 border-primary">
                            <div class="card-body">
                                <h5 class="card-title mb-3">
                                    <i class="fas fa-pen me-2"></i>Viết đánh giá của bạn
                                </h5>
                                <form id="reviewForm">
                                    <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                                    
                                    <!-- Star rating -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Đánh giá của bạn <span class="text-danger">*</span></label>
                                        <div class="star-rating">
                                            <input type="radio" name="rating" value="5" id="star5" required>
                                            <label for="star5"><i class="fas fa-star"></i></label>
                                            
                                            <input type="radio" name="rating" value="4" id="star4">
                                            <label for="star4"><i class="fas fa-star"></i></label>
                                            
                                            <input type="radio" name="rating" value="3" id="star3">
                                            <label for="star3"><i class="fas fa-star"></i></label>
                                            
                                            <input type="radio" name="rating" value="2" id="star2">
                                            <label for="star2"><i class="fas fa-star"></i></label>
                                            
                                            <input type="radio" name="rating" value="1" id="star1">
                                            <label for="star1"><i class="fas fa-star"></i></label>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nội dung <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="comment" rows="4" 
                                                  placeholder="Chia sẻ trải nghiệm của bạn về cuốn sách này..." required></textarea>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-2"></i>Gửi đánh giá
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Bạn đã đánh giá sách này rồi. Bạn có thể chỉnh sửa đánh giá của mình bên dưới.
                        </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Vui lòng <a href="<?php echo WEBROOT; ?>/user/login">đăng nhập</a> để viết đánh giá
                        </div>
                    <?php endif; ?>
                    
                    <!-- Danh sách đánh giá -->
                    <h5 class="mb-3 fw-bold">
                        <i class="fas fa-comments me-2"></i>Đánh giá từ khách hàng
                    </h5>
                    
                    <?php if (empty($reviews)): ?>
                        <p class="text-muted fst-italic">Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá sản phẩm này!</p>
                    <?php else: ?>
                        <?php foreach ($reviews as $review): ?>
                        <div class="card mb-3 <?php echo isset($_SESSION['user_id']) && $review['user_id'] == $_SESSION['user_id'] ? 'border-primary' : ''; ?>">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo WEBROOT . '/public/assets/Clients/avatars/' . ($review['avatar'] ?? 'default-avatar.png'); ?>" 
                                             class="rounded-circle me-3" width="50" height="50" alt="Avatar">
                                        <div>
                                            <h6 class="mb-0 fw-bold">
                                                <?php echo htmlspecialchars($review['full_name']); ?>
                                                <?php if ($review['is_verified_purchase']): ?>
                                                    <span class="badge bg-success ms-2" style="font-size: 0.7em;">
                                                        <i class="fas fa-check-circle"></i> Đã mua hàng
                                                    </span>
                                                <?php endif; ?>
                                            </h6>
                                            <div class="text-warning">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="fas fa-star <?php echo $i <= $review['rating'] ? '' : 'text-muted'; ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        <?php echo date('d/m/Y H:i', strtotime($review['created_at'])); ?>
                                    </small>
                                </div>
                                
                                <p class="mb-2"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                                
                                <!-- Nút sửa/xóa nếu là review của user -->
                                <?php if (isset($_SESSION['user_id']) && $review['user_id'] == $_SESSION['user_id']): ?>
                                <div class="mt-2">
                                    <button class="btn btn-sm btn-outline-primary edit-review-btn" 
                                            data-review-id="<?php echo $review['review_id']; ?>"
                                            data-rating="<?php echo $review['rating']; ?>"
                                            data-comment="<?php echo htmlspecialchars($review['comment']); ?>">
                                        <i class="fas fa-edit"></i> Chỉnh sửa
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-review-btn" 
                                            data-review-id="<?php echo $review['review_id']; ?>">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                        <!-- Pagination cho reviews -->
                        <?php if ($totalReviewPages > 1): ?>
                        <nav>
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $totalReviewPages; $i++): ?>
                                <li class="page-item <?php echo $i == $currentReviewPage ? 'active' : ''; ?>">
                                    <a class="page-link" href="?review_page=<?php echo $i; ?>#reviews">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal sửa review -->
    <div class="modal fade" id="editReviewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chỉnh sửa đánh giá</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editReviewForm">
                        <input type="hidden" name="review_id" id="editReviewId">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Đánh giá <span class="text-danger">*</span></label>
                            <div class="star-rating">
                                <input type="radio" name="rating" value="5" id="editStar5" required>
                                <label for="editStar5"><i class="fas fa-star"></i></label>
                                
                                <input type="radio" name="rating" value="4" id="editStar4">
                                <label for="editStar4"><i class="fas fa-star"></i></label>
                                
                                <input type="radio" name="rating" value="3" id="editStar3">
                                <label for="editStar3"><i class="fas fa-star"></i></label>
                                
                                <input type="radio" name="rating" value="2" id="editStar2">
                                <label for="editStar2"><i class="fas fa-star"></i></label>
                                
                                <input type="radio" name="rating" value="1" id="editStar1">
                                <label for="editStar1"><i class="fas fa-star"></i></label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nội dung <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="comment" id="editComment" rows="4" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="saveEditReview">Lưu thay đổi</button>
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


<!-- CSS cho star rating -->
<style>
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 5px;
    }
    
    .star-rating input[type="radio"] {
        display: none;
    }
    
    .star-rating label {
        cursor: pointer;
        font-size: 2rem;
        color: #ddd;
        transition: color 0.2s;
    }
    
    .star-rating input[type="radio"]:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #ffc107;
    }
</style>

<!-- JavaScript cho reviews -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const webroot = '<?php echo WEBROOT; ?>';
    
    // Submit form đánh giá mới
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch(webroot + '/product/addReview', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra, vui lòng thử lại');
            });
        });
    }
    
    // Mở modal sửa review
    const editBtns = document.querySelectorAll('.edit-review-btn');
    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const reviewId = this.dataset.reviewId;
            const rating = this.dataset.rating;
            const comment = this.dataset.comment;
            
            document.getElementById('editReviewId').value = reviewId;
            document.getElementById('editStar' + rating).checked = true;
            document.getElementById('editComment').value = comment;
            
            const modal = new bootstrap.Modal(document.getElementById('editReviewModal'));
            modal.show();
        });
    });
    
    // Lưu chỉnh sửa review
    const saveEditBtn = document.getElementById('saveEditReview');
    if (saveEditBtn) {
        saveEditBtn.addEventListener('click', function() {
            const form = document.getElementById('editReviewForm');
            const formData = new FormData(form);
            
            fetch(webroot + '/product/updateReview', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra, vui lòng thử lại');
            });
        });
    }
    
    // Xóa review
    const deleteBtns = document.querySelectorAll('.delete-review-btn');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm('Bạn có chắc muốn xóa đánh giá này?')) return;
            
            const reviewId = this.dataset.reviewId;
            const formData = new FormData();
            formData.append('review_id', reviewId);
            
            fetch(webroot + '/product/deleteReview', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra, vui lòng thử lại');
            });
        });
    });
});
</script>

