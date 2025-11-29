<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5 text-center">
                    
                    <!-- Icon thành công -->
                    <div class="mb-4">
                        <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center" 
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-check fa-3x text-white"></i>
                        </div>
                    </div>

                    <!-- Tiêu đề -->
                    <h2 class="fw-bold text-success mb-3">
                        Đăng ký thành công!
                    </h2>

                    <!-- Thông tin tài khoản -->
                    <div class="alert alert-info text-start mb-4">
                        <h5 class="mb-3"><i class="fas fa-user-check me-2"></i>Thông tin tài khoản</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-user me-2 text-primary"></i>
                                <strong>Họ tên:</strong> <?php echo htmlspecialchars($user_info['full_name']); ?>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-id-badge me-2 text-primary"></i>
                                <strong>Tên đăng nhập:</strong> <?php echo htmlspecialchars($user_info['username']); ?>
                            </li>
                            <li>
                                <i class="fas fa-envelope me-2 text-primary"></i>
                                <strong>Email:</strong> <?php echo htmlspecialchars($user_info['email']); ?>
                            </li>
                        </ul>
                    </div>

                    <!-- Thông báo -->
                    <p class="text-muted mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        Tài khoản của bạn đã được tạo thành công.<br>
                        Vui lòng đăng nhập để bắt đầu mua sắm!
                    </p>

                    <!-- Nút hành động -->
                    <div class="d-grid gap-2">
                        <a href="<?php echo WEBROOT; ?>/user/login" class="btn btn-success btn-lg fw-bold">
                            <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập ngay
                        </a>
                        <a href="<?php echo WEBROOT; ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-2"></i>Về trang chủ
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
