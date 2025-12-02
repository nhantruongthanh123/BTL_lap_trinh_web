<div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom bg-white shadow-sm">
    <h2 class="fw-bold mb-0">Chỉnh sửa sách</h2>
    <a href="<?php echo WEBROOT; ?>/admin/books" class="btn btn-outline-secondary">
        <i class="ti ti-arrow-left me-1"></i>Quay lại
    </a>
</div>

<div class="container-xl mt-4">
    
    <!-- THÔNG BÁO -->
    <?php if (!empty($success)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check me-2"></i><?php echo htmlspecialchars($success); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-alert-circle me-2"></i><?php echo htmlspecialchars($error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center mb-2">
                <i class="ti ti-alert-triangle me-2 fs-3"></i>
                <strong>Có <?php echo count($errors); ?> lỗi cần sửa:</strong>
            </div>
            <ul class="mb-0 ps-4">
                <?php foreach ($errors as $field => $message): ?>
                    <li>
                        <strong><?php echo ucfirst(str_replace('_', ' ', $field)); ?>:</strong> 
                        <?php echo htmlspecialchars($message); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- FORM CẬP NHẬT SÁCH -->
    <form action="<?php echo WEBROOT; ?>/admin/editBookProcess/<?php echo $book['book_id']; ?>" method="POST" enctype="multipart/form-data">
        <div class="row">
            
            <!-- CỘT TRÁI - THÔNG TIN CHÍNH -->
            <div class="col-lg-8">
                
                <!-- CARD 1: Thông tin cơ bản -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin cơ bản</h3>
                    </div>
                    <div class="card-body">
                        
                        <!-- Tên sách -->
                        <div class="mb-3">
                            <label class="form-label required">Tên sách</label>
                            <input type="text" 
                                   class="form-control <?php echo isset($errors['title']) ? 'is-invalid' : ''; ?>" 
                                   name="title" 
                                   placeholder="Nhập tên sách"
                                   value="<?php echo htmlspecialchars($old['title'] ?? $book['title']); ?>"
                                   required>
                            <?php if (isset($errors['title'])): ?>
                                <div class="invalid-feedback"><?php echo htmlspecialchars($errors['title']); ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Tác giả -->
                        <div class="mb-3">
                            <label class="form-label required">Tác giả</label>
                            <select class="form-select <?php echo isset($errors['author_id']) ? 'is-invalid' : ''; ?>" 
                                    name="author_id"
                                    required>
                                <option value="">-- Chọn tác giả --</option>
                                <?php if (!empty($authors)): ?>
                                    <?php 
                                    $selectedAuthorId = $old['author_id'] ?? $book['author_id'];
                                    foreach ($authors as $author): 
                                    ?>
                                        <option value="<?php echo $author['author_id']; ?>"
                                            <?php echo ($selectedAuthorId == $author['author_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($author['author_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <?php if (isset($errors['author_id'])): ?>
                                <div class="invalid-feedback d-block"><?php echo htmlspecialchars($errors['author_id']); ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- ISBN -->
                        <div class="mb-3">
                            <label class="form-label">ISBN (Mã sách)</label>
                            <input type="text" 
                                   class="form-control <?php echo isset($errors['isbn']) ? 'is-invalid' : ''; ?>" 
                                   name="isbn" 
                                   placeholder="VD: 978-3-16-148410-0"
                                   value="<?php echo htmlspecialchars($old['isbn'] ?? $book['isbn']); ?>">
                            <?php if (isset($errors['isbn'])): ?>
                                <div class="invalid-feedback"><?php echo htmlspecialchars($errors['isbn']); ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Nhà xuất bản -->
                        <div class="mb-3">
                            <label class="form-label">Nhà xuất bản</label>
                            <select class="form-select <?php echo isset($errors['publisher_id']) ? 'is-invalid' : ''; ?>" 
                                    name="publisher_id">
                                <option value="">-- Chọn nhà xuất bản --</option>
                                <?php if (!empty($publishers)): ?>
                                    <?php 
                                    $selectedPublisherId = $old['publisher_id'] ?? $book['publisher_id'];
                                    foreach ($publishers as $pub): 
                                    ?>
                                        <option value="<?php echo $pub['publisher_id']; ?>"
                                            <?php echo ($selectedPublisherId == $pub['publisher_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($pub['publisher_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <?php if (isset($errors['publisher_id'])): ?>
                                <div class="invalid-feedback d-block"><?php echo htmlspecialchars($errors['publisher_id']); ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Mô tả -->
                        <div class="mb-3">
                            <label class="form-label">Mô tả sách</label>
                            <textarea class="form-control" 
                                      name="description" 
                                      rows="5" 
                                      placeholder="Nhập mô tả chi tiết về cuốn sách..."><?php echo htmlspecialchars($old['description'] ?? $book['description']); ?></textarea>
                        </div>

                    </div>
                </div>

                <!-- CARD 2: Giá và tồn kho -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Giá và tồn kho</h3>
                    </div>
                    <div class="card-body">
                        
                        <div class="row">
                            <!-- Giá bán -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Giá bán (VNĐ)</label>
                                <input type="number" 
                                       class="form-control <?php echo isset($errors['price']) ? 'is-invalid' : ''; ?>" 
                                       name="price" 
                                       placeholder="0"
                                       min="0"
                                       step="1000"
                                       value="<?php echo htmlspecialchars($old['price'] ?? $book['price']); ?>"
                                       required>
                                <?php if (isset($errors['price'])): ?>
                                    <div class="invalid-feedback"><?php echo htmlspecialchars($errors['price']); ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Giá giảm -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Giá giảm (VNĐ)</label>
                                <input type="number" 
                                       class="form-control <?php echo isset($errors['discount_price']) ? 'is-invalid' : ''; ?>" 
                                       name="discount_price" 
                                       placeholder="0"
                                       min="0"
                                       step="1000"
                                       value="<?php echo htmlspecialchars($old['discount_price'] ?? $book['discount_price']); ?>">
                                <?php if (isset($errors['discount_price'])): ?>
                                    <div class="invalid-feedback"><?php echo htmlspecialchars($errors['discount_price']); ?></div>
                                <?php endif; ?>
                                <small class="form-hint">Để trống nếu không có giảm giá</small>
                            </div>

                            <!-- Số lượng -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Số lượng</label>
                                <input type="number" 
                                       class="form-control <?php echo isset($errors['stock_quantity']) ? 'is-invalid' : ''; ?>" 
                                       name="stock_quantity" 
                                       placeholder="0"
                                       min="0"
                                       value="<?php echo htmlspecialchars($old['stock_quantity'] ?? $book['stock_quantity']); ?>"
                                       required>
                                <?php if (isset($errors['stock_quantity'])): ?>
                                    <div class="invalid-feedback"><?php echo htmlspecialchars($errors['stock_quantity']); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- CỘT PHẢI - THÔNG TIN PHỤ -->
            <div class="col-lg-4">
                
                <!-- CARD 3: Danh mục -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Danh mục</h3>
                    </div>
                    <div class="card-body">
                        <label class="form-label required">Chọn danh mục</label>
                        <select class="form-select <?php echo isset($errors['category_id']) ? 'is-invalid' : ''; ?>" 
                                name="category_id" 
                                required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php if (!empty($categories)): ?>
                                <?php 
                                $selectedCategoryId = $old['category_id'] ?? $book['category_id'];
                                foreach ($categories as $category): 
                                ?>
                                    <option value="<?php echo $category['category_id']; ?>"
                                            <?php echo ($selectedCategoryId == $category['category_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category['category_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <?php if (isset($errors['category_id'])): ?>
                            <div class="invalid-feedback d-block"><?php echo htmlspecialchars($errors['category_id']); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- CARD 4: Ảnh bìa -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Ảnh bìa sách</h3>
                    </div>
                    <div class="card-body">
                        
                        <!-- Preview ảnh -->
                        <div class="mb-3 text-center">
                            <?php 
                            $currentImage = $book['cover_image'] 
                                ? WEBROOT . '/public/images/' . $book['cover_image']
                                : WEBROOT . '/public/images/default-book.png';
                            ?>
                            <img src="<?php echo $currentImage; ?>" 
                                 alt="Preview" 
                                 id="cover-preview"
                                 class="img-thumbnail"
                                 style="max-width: 100%; max-height: 300px; object-fit: cover;">
                        </div>

                        <!-- Input file -->
                        <div class="mb-3">
                            <label class="form-label">Thay đổi ảnh bìa</label>
                            <input type="file" 
                                   class="form-control <?php echo isset($errors['cover_image']) ? 'is-invalid' : ''; ?>" 
                                   name="cover_image" 
                                   id="cover-input"
                                   accept="image/jpeg,image/png,image/jpg,image/gif">
                            <?php if (isset($errors['cover_image'])): ?>
                                <div class="invalid-feedback"><?php echo htmlspecialchars($errors['cover_image']); ?></div>
                            <?php endif; ?>
                            <small class="form-hint">Để trống nếu giữ ảnh hiện tại. JPG, PNG, GIF (tối đa 5MB)</small>
                        </div>
                    </div>
                </div>

                <!-- CARD 5: Trạng thái -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Trạng thái</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-2">
                            <?php 
                            $isActive = $old['is_active'] ?? $book['is_active'];
                            ?>
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="is_active" 
                                   id="is_active"
                                   value="1"
                                   <?php echo $isActive ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="is_active">
                                Kích hoạt (hiển thị trên website)
                            </label>
                        </div>

                        <div class="form-check form-switch">
                            <?php 
                            $isFeatured = $old['is_featured'] ?? $book['is_featured'];
                            ?>
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="is_featured" 
                                   id="is_featured"
                                   value="1"
                                   <?php echo $isFeatured ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="is_featured">
                                Sách nổi bật (hiển thị trang chủ)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- NÚT HÀNH ĐỘNG -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>Cập nhật sách
                            </button>
                            <a href="<?php echo WEBROOT; ?>/admin/books" class="btn btn-outline-secondary">
                                <i class="ti ti-x me-1"></i>Hủy bỏ
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const coverInput = document.getElementById('cover-input');
    const coverPreview = document.getElementById('cover-preview');
    
    if (coverInput && coverPreview) {
        coverInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (!file) {
                return;
            }
            
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                alert('Chỉ chấp nhận file ảnh JPG, PNG, GIF!');
                this.value = '';
                return;
            }
            
            if (file.size > 5 * 1024 * 1024) {
                alert('Kích thước file không được vượt quá 5MB!');
                this.value = '';
                return;
            }
            
            // Preview ảnh
            const reader = new FileReader();
            reader.onload = function(e) {
                coverPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    }

    // Scroll đến lỗi đầu tiên
    <?php if (!empty($errors)): ?>
    const firstError = document.querySelector('.is-invalid');
    if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstError.focus();
    }
    <?php endif; ?>
});
</script>