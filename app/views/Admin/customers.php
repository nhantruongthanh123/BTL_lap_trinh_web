<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Quản lý Khách hàng</h2>
        <div class="text-muted mt-1">Danh sách tất cả khách hàng đã đăng ký</div>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <span class="badge bg-blue-lt fs-5">
          <i class="ti ti-users me-1"></i>
          Tổng: <?php echo count($customers); ?> khách hàng
        </span>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">

    <!-- THÔNG BÁO -->
    <?php if (!empty($success)): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="ti ti-check me-2"></i><?php echo htmlspecialchars($success); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="ti ti-alert-circle me-2"></i><?php echo htmlspecialchars($error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white">
        <h3 class="card-title">Danh sách khách hàng</h3>
        <div class="card-actions">
          <div class="input-icon">
            <span class="input-icon-addon">
              <i class="ti ti-search"></i>
            </span>
            <input type="text" 
                   class="form-control" 
                   placeholder="Tìm tên, email, SĐT..." 
                   id="searchInput">
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-vcenter table-hover align-middle mb-0" id="customerTable">
          <thead class="bg-light">
            <tr>
              <th style="width: 80px;"></th>
              <th>Thông tin khách hàng</th>
              <th style="width: 150px;">Tên đăng nhập</th>
              <th style="width: 130px;" class="text-center">Số đơn hàng</th>
              <th style="width: 150px;" class="text-center">Tổng chi tiêu</th>
              <th style="width: 120px;" class="text-center">Trạng thái</th>
              <th style="width: 150px;" class="text-center">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($customers)): ?>
              <?php foreach ($customers as $customer): ?>
                <tr>
                  <!-- AVATAR -->
                  <td>
                    <?php 
                    $avatarUrl = !empty($customer['avatar']) 
                        ? WEBROOT . '/public/assets/Clients/avatars/' . $customer['avatar']
                        : WEBROOT . '/public/assets/Clients/avatars/default-avatar.png';
                    ?>
                    <span class="avatar avatar-md rounded" 
                          style="background-image: url('<?php echo $avatarUrl; ?>')">
                    </span>
                  </td>

                  <!-- THÔNG TIN KHÁCH HÀNG -->
                  <td>
                    <div>
                      <div class="fw-bold"><?php echo htmlspecialchars($customer['full_name'] ?? 'Chưa cập nhật'); ?></div>
                      <div class="text-muted small">
                        <i class="ti ti-mail me-1"></i>
                        <?php echo htmlspecialchars($customer['email']); ?>
                      </div>
                      <?php if (!empty($customer['phone'])): ?>
                      <div class="text-muted small">
                        <i class="ti ti-phone me-1"></i>
                        <?php echo htmlspecialchars($customer['phone']); ?>
                      </div>
                      <?php endif; ?>
                    </div>
                  </td>

                  <!-- USERNAME -->
                  <td>
                    <code class="text-muted"><?php echo htmlspecialchars($customer['username']); ?></code>
                  </td>

                  <!-- SỐ ĐƠN HÀNG -->
                  <td class="text-center">
                    <?php if ($customer['total_orders'] > 0): ?>
                        <i class="ti ti-shopping-cart me-1"></i>
                        <?php echo $customer['total_orders']; ?>
                      </a>
                    <?php else: ?>
                      <span class="text-muted">0</span>
                    <?php endif; ?>
                  </td>

                  <!-- TỔNG CHI TIÊU -->
                  <td class="text-center">
                    <?php if ($customer['total_spent'] > 0): ?>
                      <span class="fw-bold text-success">
                        <?php echo number_format($customer['total_spent'], 0, ',', '.'); ?> ₫
                      </span>
                    <?php else: ?>
                      <span class="text-muted">0 ₫</span>
                    <?php endif; ?>
                  </td>

                  <!-- TRẠNG THÁI -->
                  <td class="text-center">
                    <?php if ($customer['is_active']): ?>
                      <span class="badge bg-success-lt">
                        <i class="ti ti-check me-1"></i>Hoạt động
                      </span>
                    <?php else: ?>
                      <span class="badge bg-danger-lt">
                        <i class="ti ti-lock me-1"></i>Bị khóa
                      </span>
                    <?php endif; ?>
                  </td>

                  <!-- THAO TÁC -->
                  <td class="text-center">
                    <div class="btn-group" role="group">
                      
                      <!-- Khóa/Mở khóa -->
                      <button type="button" 
                              class="btn btn-sm btn-icon <?php echo $customer['is_active'] ? 'btn-outline-warning' : 'btn-outline-success'; ?>"
                              onclick="toggleStatus(<?php echo $customer['user_id']; ?>, '<?php echo htmlspecialchars($customer['full_name']); ?>', <?php echo $customer['is_active']; ?>)"
                              title="<?php echo $customer['is_active'] ? 'Khóa tài khoản' : 'Mở khóa tài khoản'; ?>"
                              <?php echo ($customer['user_id'] == $_SESSION['user_id']) ? 'disabled' : ''; ?>>
                        <i class="ti <?php echo $customer['is_active'] ? 'ti-lock' : 'ti-lock-open'; ?>"></i>
                      </button>

                      <!-- Xem đơn hàng -->
                      <a href="<?php echo WEBROOT; ?>/admin/orders?user=<?php echo $customer['user_id']; ?>" 
                         class="btn btn-sm btn-icon btn-outline-info"
                         title="Xem đơn hàng">
                        <i class="ti ti-shopping-cart"></i>
                      </a>

                    </div>
                  </td>

                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center py-5">
                  <div class="empty">
                    <div class="empty-img">
                      <i class="ti ti-users-off" style="font-size: 4rem; opacity: 0.3;"></i>
                    </div>
                    <p class="empty-title">Chưa có khách hàng nào</p>
                    <p class="empty-subtitle text-muted">
                      Khách hàng sẽ xuất hiện sau khi đăng ký
                    </p>
                  </div>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- FOOTER -->
      <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-muted">
          Hiển thị <strong><?php echo count($customers); ?></strong> khách hàng
        </p>
      </div>

    </div>

  </div>
</div>

<!-- JAVASCRIPT -->
<script>
// TOGGLE TRẠNG THÁI
function toggleStatus(userId, fullName, currentStatus) {
    const action = currentStatus ? 'khóa' : 'mở khóa';
    const message = `Bạn có chắc muốn ${action} tài khoản "${fullName}"?`;
    
    if (confirm(message)) {
        window.location.href = '<?php echo WEBROOT; ?>/admin/toggleCustomerStatus/' + userId;
    }
}


// HÀM XÓA DẤU TIẾNG VIỆT
function removeVietnameseTones(str) {
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a"); 
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e"); 
    str = str.replace(/ì|í|ị|ỉ|ĩ/g,"i"); 
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o"); 
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u"); 
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y"); 
    str = str.replace(/đ/g,"d");
    str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
    str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
    str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
    str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
    str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
    str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
    str = str.replace(/Đ/g, "D");
    return str.toLowerCase().trim();
}

// TÌM KIẾM KHÁCH HÀNG
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    const keyword = removeVietnameseTones(e.target.value);
    const rows = document.querySelectorAll('#customerTable tbody tr');
    
    rows.forEach(row => {
        const cells = row.cells;
        if (!cells || cells.length < 4) return;
        
        const fullName = cells[2]?.innerText || '';
        const username = cells[3]?.innerText || '';
        
        const rowText = removeVietnameseTones(fullName + " " + username);
        
        if (rowText.includes(keyword)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

<style>
.btn-icon {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.table > tbody > tr > td {
    vertical-align: middle;
}

.empty-img i {
    color: #cbd5e1;
}
</style>