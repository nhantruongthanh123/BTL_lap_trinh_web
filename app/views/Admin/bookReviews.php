<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo WEBROOT; ?>/admin/reviews">Quản lý đánh giá</a></li>
            <li class="breadcrumb-item active"><?php echo htmlspecialchars($book['title']); ?></li>
          </ol>
        </nav>
        <h2 class="page-title">Đánh giá: <?php echo htmlspecialchars($book['title']); ?></h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    
    <?php if (!empty($success)): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ti ti-check me-2"></i><?php echo $success; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="ti ti-alert-triangle me-2"></i><?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- Thống kê -->
    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body text-center">
            <h2 class="display-4 fw-bold text-warning mb-0">
              <?php echo number_format($ratingStats['average_rating'], 1); ?>
            </h2>
            <div class="text-warning mb-2">
              <?php 
              $avgRating = round($ratingStats['average_rating']);
              for ($i = 1; $i <= 5; $i++): 
              ?>
                <i class="ti ti-star-filled <?php echo $i <= $avgRating ? '' : 'text-muted'; ?>"></i>
              <?php endfor; ?>
            </div>
            <p class="text-muted"><?php echo $totalReviews; ?> đánh giá</p>
          </div>
        </div>
      </div>
      
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <?php
            $stars = [5, 4, 3, 2, 1];
            foreach ($stars as $star):
                $count = $ratingStats[$star == 5 ? 'five_star' : ($star == 4 ? 'four_star' : ($star == 3 ? 'three_star' : ($star == 2 ? 'two_star' : 'one_star')))];
                $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
            ?>
            <div class="d-flex align-items-center mb-2">
                <span class="me-2" style="width: 60px;"><?php echo $star; ?> sao</span>
                <div class="progress flex-grow-1" style="height: 10px;">
                    <div class="progress-bar bg-warning" role="progressbar" 
                         style="width: <?php echo $percentage; ?>%"></div>
                </div>
                <span class="ms-2 text-muted" style="width: 50px;"><?php echo $count; ?></span>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Danh sách reviews -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Danh sách đánh giá (<?php echo $totalReviews; ?>)</h3>
      </div>

      <div class="list-group list-group-flush">
        <?php if (empty($paginatedReviews)): ?>
          <div class="list-group-item text-center text-muted py-5">
            <i class="ti ti-inbox fs-1 mb-2"></i>
            <p>Chưa có đánh giá nào</p>
          </div>
        <?php else: ?>
          <?php foreach ($paginatedReviews as $review): ?>
          <div class="list-group-item">
            <div class="row align-items-start">
              <div class="col-auto">
                <img src="<?php echo WEBROOT . '/public/assets/Clients/avatars/' . ($review['avatar'] ?? 'default-avatar.png'); ?>" 
                     class="avatar rounded-circle" alt="">
              </div>
              
              <div class="col">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <div>
                    <strong><?php echo htmlspecialchars($review['full_name']); ?></strong>
                    <?php if ($review['is_verified_purchase']): ?>
                      <span class="badge bg-success-lt ms-2">
                        <i class="ti ti-check me-1"></i>Đã mua hàng
                      </span>
                    <?php endif; ?>
                    
                    <?php if (!$review['is_approved']): ?>
                      <span class="badge bg-warning ms-2">Chờ duyệt</span>
                    <?php endif; ?>
                    
                    <div class="text-muted small mt-1">
                      <?php echo date('d/m/Y H:i', strtotime($review['created_at'])); ?>
                    </div>
                  </div>
                  
                  <div class="btn-group">                 
                    <a href="<?php echo WEBROOT; ?>/admin/deleteReview/<?php echo $review['review_id']; ?>" 
                       class="btn btn-sm btn-icon btn-danger"
                       title="Xóa"
                       onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?')">
                      <i class="ti ti-trash"></i>
                    </a>
                  </div>
                </div>
                
                <div class="text-warning mb-2">
                  <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="ti ti-star-filled <?php echo $i <= $review['rating'] ? '' : 'text-muted'; ?>"></i>
                  <?php endfor; ?>
                </div>
                
                <p class="mb-0"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- Pagination -->
      <?php if ($totalPages > 1): ?>
      <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
          Trang <?php echo $currentPage; ?> / <?php echo $totalPages; ?>
        </p>
        
        <ul class="pagination m-0 ms-auto">
          <?php if ($currentPage > 1): ?>
            <li class="page-item">
              <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>">
                <i class="ti ti-chevron-left"></i> Trước
              </a>
            </li>
          <?php endif; ?>

          <?php
          $startPage = max(1, $currentPage - 2);
          $endPage = min($totalPages, $currentPage + 2);

          for ($i = $startPage; $i <= $endPage; $i++): ?>
            <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
              <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
          <?php endfor; ?>

          <?php if ($currentPage < $totalPages): ?>
            <li class="page-item">
              <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">
                Sau <i class="ti ti-chevron-right"></i>
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
      <?php endif; ?>

    </div>
  </div>
</div>