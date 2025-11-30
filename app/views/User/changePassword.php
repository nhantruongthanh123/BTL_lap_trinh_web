
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-key me-2 text-primary"></i>Đổi mật khẩu
                    </h5>
                    <small class="text-muted">Để bảo mật tài khoản, vui lòng không chia sẻ mật khẩu cho người khác</small>
                </div>
                
                <div class="card-body p-4">
                    
                    <!-- Thông báo thành công -->
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($success); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Thông báo lỗi chung -->
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Hướng dẫn -->
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Lưu ý:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Mật khẩu phải có ít nhất 6 ký tự</li>
                            <li>Nên sử dụng kết hợp chữ hoa, chữ thường, số và ký tự đặc biệt</li>
                            <li>Không sử dụng mật khẩu quá đơn giản như: 123456, password...</li>
                        </ul>
                    </div>

                    <!-- FORM ĐỔI MẬT KHẨU -->
                    <form action="<?php echo WEBROOT; ?>/user/changePasswordProcess" method="POST">
                        
                        <!-- Mật khẩu hiện tại -->
                        <div class="row mb-3">
                            <label for="current_password" class="col-md-4 col-form-label text-end">
                                Mật khẩu hiện tại <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="password" 
                                       class="form-control <?php echo isset($errors['current_password']) ? 'is-invalid' : ''; ?>" 
                                       id="current_password" 
                                       name="current_password"
                                       placeholder="Nhập mật khẩu hiện tại"
                                       required>
                                <?php if (isset($errors['current_password'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo htmlspecialchars($errors['current_password']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Mật khẩu mới -->
                        <div class="row mb-3">
                            <label for="new_password" class="col-md-4 col-form-label text-end">
                                Mật khẩu mới <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="password" 
                                       class="form-control <?php echo isset($errors['new_password']) ? 'is-invalid' : ''; ?>" 
                                       id="new_password" 
                                       name="new_password"
                                       placeholder="Nhập mật khẩu mới (tối thiểu 6 ký tự)"
                                       minlength="6"
                                       required>
                                <?php if (isset($errors['new_password'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo htmlspecialchars($errors['new_password']); ?>
                                    </div>
                                <?php endif; ?>
                                <!-- Password strength indicator -->
                                <div class="form-text">
                                    <small id="password-strength"></small>
                                </div>
                            </div>
                        </div>

                        <!-- Xác nhận mật khẩu mới -->
                        <div class="row mb-4">
                            <label for="confirm_password" class="col-md-4 col-form-label text-end">
                                Xác nhận mật khẩu mới <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="password" 
                                       class="form-control <?php echo isset($errors['confirm_password']) ? 'is-invalid' : ''; ?>" 
                                       id="confirm_password" 
                                       name="confirm_password"
                                       placeholder="Nhập lại mật khẩu mới"
                                       required>
                                <?php if (isset($errors['confirm_password'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo htmlspecialchars($errors['confirm_password']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Nút submit -->
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Đổi mật khẩu
                                </button>
                                <a href="<?php echo WEBROOT; ?>/user/profile" class="btn btn-outline-secondary btn-lg ms-2">
                                    <i class="fas fa-times me-2"></i>Hủy
                                </a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>


<script>
document.getElementById('new_password').addEventListener('input', function() {
    const password = this.value;
    const strengthText = document.getElementById('password-strength');
    
    let strength = 0;
    if (password.length >= 6) strength++;
    if (password.length >= 10) strength++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[^a-zA-Z0-9]/.test(password)) strength++;
    
    const strengthLevels = [
        '<span class="text-danger">Rất yếu</span>',
        '<span class="text-warning">Yếu</span>',
        '<span class="text-info">Trung bình</span>',
        '<span class="text-success">Mạnh</span>',
        '<span class="text-success fw-bold">Rất mạnh</span>'
    ];
    
    if (password.length === 0) {
        strengthText.innerHTML = '';
    } else {
        strengthText.innerHTML = 'Độ mạnh mật khẩu: ' + strengthLevels[strength];
    }
});


document.getElementById('confirm_password').addEventListener('input', function() {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = this.value;
    
    if (confirmPassword && newPassword !== confirmPassword) {
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
    }
});
</script>