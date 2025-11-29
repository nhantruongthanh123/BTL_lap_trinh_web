<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-circle fa-4x text-primary mb-3"></i>
                        <h3 class="fw-bold text-primary">Đăng nhập</h3>
                        <p class="text-muted">Đăng nhập để tiếp tục mua sắm</p>
                    </div>

                    <!-- HIỂN THỊ THÔNG BÁO THÀNH CÔNG (từ đăng ký) -->
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php echo htmlspecialchars($success); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- HIỂN THỊ LỖI ĐĂNG NHẬP -->
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php echo htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo WEBROOT; ?>/user/loginProcess" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">
                                <i class="fas fa-user me-2"></i>Tên đăng nhập hoặc Email
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="username" 
                                   name="username" 
                                   placeholder="Nhập tên đăng nhập hoặc email"
                                   required 
                                   autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">
                                <i class="fas fa-lock me-2"></i>Mật khẩu
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Nhập mật khẩu"
                                   required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-0">Chưa có tài khoản? 
                            <a href="<?php echo WEBROOT; ?>/user/register" class="text-primary fw-bold text-decoration-none">
                                Đăng ký ngay
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>