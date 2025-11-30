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

                    <form action="<?php echo WEBROOT; ?>/user/updateProfile" method="POST" enctype="multipart/form-data">
                        
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

                        <div class="row mb-4 align-items-center">
                            <label class="col-md-3 text-start text-muted fw-bold">Ảnh đại diện</label>
                            <div class="col-md-9">
                                <div class="d-flex align-items-center gap-4">
                                    <!-- Preview Avatar -->
                                    <?php 
                                        $avatar = $user['avatar'] ?? 'default-avatar.png';
                                        $avatarPath = WEBROOT . '/public/assets/Clients/avatars/' . $avatar;
                                    ?>
                                    <img src="<?php echo $avatarPath; ?>" 
                                         alt="Avatar Preview" 
                                         id="avatar-preview"
                                         class="rounded-circle border border-3 border-primary shadow" 
                                         style="width: 100px; height: 100px; object-fit: cover;">
                                    
                                    <!-- Input File -->
                                    <div class="flex-grow-1">
                                        <input type="file" 
                                               class="form-control mb-2" 
                                               id="avatar-input" 
                                               name="avatar" 
                                               accept="image/jpeg,image/png,image/jpg,image/gif">
                                        <small class="text-muted d-block">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Chọn ảnh JPG, PNG, GIF (tối đa 2MB)
                                        </small>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger mt-2" 
                                                id="remove-avatar">
                                            <i class="fas fa-trash me-1"></i>Xóa ảnh
                                        </button>
                                    </div>
                                </div>
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



<!-- JavaScript Preview Avatar -->
<script>
// Preview ảnh khi chọn file
document.getElementById('avatar-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Kiểm tra loại file
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Chỉ chấp nhận file ảnh JPG, PNG, GIF!');
            this.value = '';
            return;
        }
        
        // Kiểm tra kích thước (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Kích thước file không được vượt quá 2MB!');
            this.value = '';
            return;
        }
        
        // Hiển thị preview
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('remove-avatar').addEventListener('click', function() {
    if (confirm('Bạn có chắc muốn xóa ảnh đại diện?')) {
        document.getElementById('avatar-preview').src = '<?php echo WEBROOT; ?>/public/assets/Clients/avatars/default-avatar.png';
        document.getElementById('avatar-input').value = '';
        
        fetch('<?php echo WEBROOT; ?>/user/removeAvatar', {
            method: 'POST'
        }).then(() => {
            location.reload();
        });
    }
});
</script>