<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle">Quản lý</div>
        <h2 class="page-title">Đánh giá sản phẩm</h2>
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

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Sách có đánh giá (<?php echo $totalBooks; ?>)</h3>
        
        <!-- Search box -->
        <div class="ms-auto">
          <div class="input-group">
            <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm sách...">
            <button class="btn btn-icon" type="button" id="resetBtn" style="display:none;">
              <i class="ti ti-x"></i>
            </button>
          </div>
        </div>
      </div>

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 p-4" id="bookGrid">
        <?php if (empty($paginatedBooks)): ?>
          <div class="col-12 text-center text-muted py-5">
            <i class="ti ti-inbox fs-1 mb-2"></i>
            <p>Chưa có sách nào được đánh giá</p>
          </div>
        <?php else: ?>
          <?php foreach ($paginatedBooks as $book): ?>
          <div class="col" data-book-id="<?php echo $book['book_id']; ?>">
            <div class="card h-100 shadow-sm hover-shadow">
              <a href="<?php echo WEBROOT; ?>/admin/bookReviews/<?php echo $book['book_id']; ?>">
                <div class="position-relative" style="height: 250px; overflow: hidden;">
                  <img src="<?php echo WEBROOT . '/public/images/' . ($book['cover_image'] ?? 'default-book.jpg'); ?>" 
                       class="card-img-top w-100 h-100 object-fit-cover" 
                       alt="<?php echo htmlspecialchars($book['title']); ?>"
                       onerror="this.src='<?php echo WEBROOT; ?>/public/images/default-book.jpg'">
                  
                  <!-- Badge số reviews chờ duyệt -->
                  <?php if ($book['pending_reviews'] > 0): ?>
                    <span class="position-absolute top-0 end-0 badge bg-warning m-2">
                      <?php echo $book['pending_reviews']; ?> chờ duyệt
                    </span>
                  <?php endif; ?>
                </div>
              </a>
              
              <div class="card-body">
                <h6 class="card-title mb-2">
                  <a href="<?php echo WEBROOT; ?>/admin/bookReviews/<?php echo $book['book_id']; ?>" 
                     class="text-decoration-none text-dark">
                    <?php echo htmlspecialchars($book['title']); ?>
                  </a>
                </h6>
                
                <p class="text-muted small mb-2">
                  <i class="ti ti-user me-1"></i><?php echo htmlspecialchars($book['author_name']); ?>
                </p>
                
                <div class="d-flex align-items-center justify-content-between">
                  <div class="text-warning">
                    <?php 
                    $avgRating = round($book['average_rating']);
                    for ($i = 1; $i <= 5; $i++): 
                    ?>
                      <i class="ti ti-star-filled <?php echo $i <= $avgRating ? '' : 'text-muted'; ?>"></i>
                    <?php endfor; ?>
                    <small class="text-muted ms-1"><?php echo number_format($book['average_rating'], 1); ?></small>
                  </div>
                  
                  <span class="badge bg-primary">
                    <i class="ti ti-message-circle me-1"></i><?php echo $book['total_reviews']; ?>
                  </span>
                </div>
              </div>
              
              <div class="card-footer">
                <a href="<?php echo WEBROOT; ?>/admin/bookReviews/<?php echo $book['book_id']; ?>" 
                   class="btn btn-sm btn-primary w-100">
                  <i class="ti ti-eye me-1"></i>Xem đánh giá
                </a>
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
          (Tổng <?php echo $totalBooks; ?> sách)
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

<style>
.hover-shadow {
  transition: box-shadow 0.3s ease;
}
.hover-shadow:hover {
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>

<!-- JavaScript Search -->
<script>
const allBooks = <?php echo json_encode($books); ?>;
const searchInput = document.getElementById('searchInput');
const resetBtn = document.getElementById('resetBtn');
const bookGrid = document.getElementById('bookGrid');

searchInput.addEventListener('input', function() {
    const keyword = removeVietnameseTones(this.value.toLowerCase().trim());
    
    if (keyword === '') {
        resetBtn.style.display = 'none';
        location.reload();
        return;
    }
    
    resetBtn.style.display = 'block';
    
    const filtered = allBooks.filter(book => {
        const title = removeVietnameseTones(book.title.toLowerCase());
        const author = removeVietnameseTones(book.author_name.toLowerCase());
        const category = removeVietnameseTones(book.category_name.toLowerCase());
        
        return title.includes(keyword) || author.includes(keyword) || category.includes(keyword);
    });
    
    renderBooks(filtered);
});

resetBtn.addEventListener('click', function() {
    searchInput.value = '';
    resetBtn.style.display = 'none';
    location.reload();
});

function renderBooks(books) {
    if (books.length === 0) {
        bookGrid.innerHTML = '<div class="col-12 text-center text-muted py-5">Không tìm thấy sách</div>';
        return;
    }
    
    let html = '';
    books.forEach(book => {
        const avgRating = Math.round(book.average_rating);
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            stars += `<i class="ti ti-star-filled ${i <= avgRating ? '' : 'text-muted'}"></i>`;
        }
        
        const pendingBadge = book.pending_reviews > 0 
            ? `<span class="position-absolute top-0 end-0 badge bg-warning m-2">${book.pending_reviews} chờ duyệt</span>`
            : '';
        
        html += `
            <div class="col">
                <div class="card h-100 shadow-sm hover-shadow">
                    <a href="<?php echo WEBROOT; ?>/admin/bookReviews/${book.book_id}">
                        <div class="position-relative" style="height: 250px; overflow: hidden;">
                            <img src="<?php echo WEBROOT; ?>/public/images/${book.cover_image || 'default-book.jpg'}" 
                                 class="card-img-top w-100 h-100 object-fit-cover" 
                                 onerror="this.src='<?php echo WEBROOT; ?>/public/images/default-book.jpg'">
                            ${pendingBadge}
                        </div>
                    </a>
                    <div class="card-body">
                        <h6 class="card-title mb-2">
                            <a href="<?php echo WEBROOT; ?>/admin/bookReviews/${book.book_id}" class="text-decoration-none text-dark">
                                ${book.title}
                            </a>
                        </h6>
                        <p class="text-muted small mb-2">
                            <i class="ti ti-user me-1"></i>${book.author_name}
                        </p>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="text-warning">
                                ${stars}
                                <small class="text-muted ms-1">${parseFloat(book.average_rating).toFixed(1)}</small>
                            </div>
                            <span class="badge bg-primary">
                                <i class="ti ti-message-circle me-1"></i>${book.total_reviews}
                            </span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo WEBROOT; ?>/admin/bookReviews/${book.book_id}" class="btn btn-sm btn-primary w-100">
                            <i class="ti ti-eye me-1"></i>Xem đánh giá
                        </a>
                    </div>
                </div>
            </div>
        `;
    });
    
    bookGrid.innerHTML = html;
}

function removeVietnameseTones(str) {
    return str.normalize('NFD')
              .replace(/[\u0300-\u036f]/g, '')
              .replace(/đ/g, 'd').replace(/Đ/g, 'D');
}
</script>