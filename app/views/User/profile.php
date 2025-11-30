        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold">Hồ sơ cá nhân</h5>
                    <small class="text-muted">Quản lý thông tin hồ sơ để bảo mật tài khoản</small>
                </div>
                
                <div class="card-body p-4">
                    
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo WEBROOT; ?>/user/updateProfile" method="POST">
                        
                        <div class="row mb-3 align-items-center">
                            <label class="col-md-3 text-start text-muted">Tên đăng nhập</label>
                            <div class="col-md-9">
                                <span class="fw-bold"><?php echo htmlspecialchars($user['username']); ?></span>
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center">
                            <label class="col-md-3 text-start text-muted">Họ và Tên <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>">
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center">
                            <label class="col-md-3 text-start text-muted">Email <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center">
                            <label class="col-md-3 text-start text-muted">Số điện thoại</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" placeholder="Thêm số điện thoại">
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center">
                            <label class="col-md-3 text-start text-muted">Địa Chỉ</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" placeholder="Thêm địa chỉ">
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center">
                            <label class="col-md-3 text-start text-muted">Giới tính</label>
                            <div class="col-md-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" 
                                        <?php echo (isset($user['gender']) && $user['gender'] == 'male') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="male">Nam</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female"
                                        <?php echo (isset($user['gender']) && $user['gender'] == 'female') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="female">Nữ</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="other" value="other"
                                        <?php echo (isset($user['gender']) && $user['gender'] == 'other') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="other">Khác</label>
                                </div>
                            </div>
                        </div>

                        <?php
                            $y = 0; $m = 0; $d = 0;
                            
                            if (!empty($user['birthday'])) {
                                $parts = explode('-', $user['birthday']); 
                                
                                if (count($parts) == 3) {
                                    $y = (int)$parts[0]; 
                                    $m = (int)$parts[1]; 
                                    $d = (int)$parts[2]; 
                                }
                            }
                        ?>

                        <div class="row mb-4 align-items-center">
                            <label class="col-md-3 text-start text-muted">Ngày sinh</label>
                            <div class="col-md-9 d-flex gap-2">
                                
                                <select class="form-select" name="day" style="width: 30%;">
                                    <option value="">Ngày</option>
                                    <?php for($i=1; $i<=31; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo ($d == $i) ? 'selected' : ''; ?>>
                                            <?php echo $i; ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                
                                <select class="form-select" name="month" style="width: 30%;">
                                    <option value="">Tháng</option>
                                    <?php for($i=1; $i<=12; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo ($m == $i) ? 'selected' : ''; ?>>
                                            Tháng <?php echo $i; ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                
                                <select class="form-select" name="year" style="width: 30%;">
                                    <option value="">Năm</option>
                                    <?php for($i=date('Y'); $i>=1950; $i--): ?>
                                        <option value="<?php echo $i; ?>" <?php echo ($y == $i) ? 'selected' : ''; ?>>
                                            <?php echo $i; ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Cập nhật thông tin
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>