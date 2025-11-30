<div class="container my-4">
    <div class="row">
        
        <div class="col-md-3">
            <div class="card border-0 mb-3">
                <div class="card-body d-flex align-items-center border-bottom pb-3">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                         style="width: 50px; height: 50px; font-size: 1.5rem; font-weight: bold;">
                        <?php 
                            $fullName = $_SESSION['username'];
                            $avatar = $_SESSION['avatar'] ?? null;
                            $avatarPath = $avatar ? WEBROOT . '/public/assets/Clients/avatars/' . $avatar : null;
                            $firstLetter = mb_substr($fullName, 0, 1, 'UTF-8');
                        ?>

                        <?php if (!empty($avatar)): ?>
                            <!-- Hiển thị ảnh avatar -->
                            <img src="<?php echo $avatarPath; ?>" 
                                alt="Avatar" 
                                class="rounded-circle" 
                                style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #fff;">
                        <?php else: ?>
                            <!-- Hiển thị chữ cái đầu nếu không có ảnh -->
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                                style="width: 50px; height: 50px; font-size: 1.5rem; font-weight: bold;">
                                <?php echo strtoupper($firstLetter); ?>
                            </div>
                        <?php endif; ?>

                    </div>

                    
                    <div style="overflow: hidden;">
                        <div class="fw-bold text-truncate"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
                        <a href="<?php echo WEBROOT; ?>/user/profile" class="text-decoration-none text-muted small"><i class="fas fa-pen me-1"></i>Sửa hồ sơ</a>
                    </div>
                </div>

                
                <div class="mt-3">
                    <ul class="list-unstyled">
                        
                        <li class="mb-3">
                            <a href="#" class="text-decoration-none text-dark fw-bold d-flex align-items-center">
                                <i class="fas fa-user text-primary me-2" style="width: 20px;"></i> 
                                <span>Thông tin tài khoản</span> 
                            </a>
                            <ul class="list-unstyled ms-4 mt-2">
                                <li class="mb-2">
                                    <a href="<?php echo WEBROOT; ?>/user/profile" 
                                    class="text-decoration-none <?php echo (isset($active_tab) && $active_tab == 'profile') ? 'text-danger fw-bold' : 'text-secondary'; ?>">
                                    Hồ sơ cá nhân
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="<?php echo WEBROOT; ?>/user/changePassword" 
                                    class="text-decoration-none <?php echo (isset($active_tab) && $active_tab == 'password') ? 'text-danger fw-bold' : 'text-secondary'; ?>">
                                    Đổi mật khẩu
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="mb-3">
                            <a href="<?php echo WEBROOT; ?>/order/history" 
                            class="text-decoration-none d-flex align-items-center <?php echo (isset($active_tab) && $active_tab == 'order') ? 'text-danger fw-bold' : 'text-dark'; ?>">
                                <i class="fas fa-file-invoice-dollar text-primary me-2" style="width: 20px;"></i>
                                <span>Đơn hàng của tôi</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo WEBROOT; ?>/user/logout" class="text-decoration-none text-dark d-flex align-items-center">
                                <i class="fas fa-sign-out-alt text-danger me-2" style="width: 20px;"></i>
                                <span>Đăng xuất</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>