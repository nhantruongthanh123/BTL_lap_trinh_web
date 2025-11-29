
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0 fw-bold">ĐĂNG KÝ TÀI KHOẢN KHÁCH HÀNG</h4>
                </div>
                <div class="card-body p-4">
                    
                    <form action="<?php echo WEBROOT; ?>/user/registerProcess" method="POST">
                        
                        <!-- Hiển thị lỗi chung (nếu có) -->
                        <?php if (isset($errors['general'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo htmlspecialchars($errors['general']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Tên đăng nhập -->
                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">
                                Tên đăng nhập <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : ''; ?>" 
                                   id="username" 
                                   name="username" 
                                   placeholder="Tên đăng nhập không dấu" 
                                   value="<?php echo htmlspecialchars($old_input['username'] ?? ''); ?>">
                            <?php if (isset($errors['username'])): ?>
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <?php echo htmlspecialchars($errors['username']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Họ và Tên -->
                        <div class="mb-3">
                            <label for="full_name" class="form-label fw-bold">
                                Họ và Tên <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control <?php echo isset($errors['full_name']) ? 'is-invalid' : ''; ?>" 
                                   id="full_name" 
                                   name="full_name" 
                                   value="<?php echo htmlspecialchars($old_input['full_name'] ?? ''); ?>">
                            <?php if (isset($errors['full_name'])): ?>
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <?php echo htmlspecialchars($errors['full_name']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">
                                Địa chỉ Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" 
                                   id="email" 
                                   name="email" 
                                   placeholder="example@email.com"
                                   value="<?php echo htmlspecialchars($old_input['email'] ?? ''); ?>">
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <?php echo htmlspecialchars($errors['email']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Mật khẩu -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">
                                Mật khẩu <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Tối thiểu 6 ký tự">
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <?php echo htmlspecialchars($errors['password']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Xác nhận Mật khẩu -->
                        <div class="mb-4">
                            <label for="confirm_password" class="form-label fw-bold">
                                Xác nhận Mật khẩu <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control <?php echo isset($errors['confirm_password']) ? 'is-invalid' : ''; ?>" 
                                   id="confirm_password" 
                                   name="confirm_password" 
                                   placeholder="Nhập lại mật khẩu">
                            <?php if (isset($errors['confirm_password'])): ?>
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <?php echo htmlspecialchars($errors['confirm_password']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                <i class="fas fa-user-plus me-2"></i>Đăng ký
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">Đã có tài khoản? 
                            <a href="<?php echo WEBROOT; ?>/user/login" class="text-decoration-none fw-bold">Đăng nhập ngay</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>