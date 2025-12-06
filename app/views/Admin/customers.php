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
          Tổng: <?php echo $totalCustomers; ?> khách hàng
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
            <?php if (!empty($paginatedCustomers)): ?>
                <?php foreach ($paginatedCustomers as $customer): ?>
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
                            <span class="badge bg-azure-lt fs-6">
                                <?php echo $customer['total_orders']; ?> đơn
                            </span>
                        </td>

                        <!-- TỔNG CHI TIÊU -->
                        <td class="text-center">
                            <span class="text-success fw-bold">
                                <?php echo number_format($customer['total_spent']); ?> ₫
                            </span>
                        </td>

                        <!-- TRẠNG THÁI -->
                        <td class="text-center">
                            <?php if ($customer['is_active']): ?>
                                <span class="badge bg-success-lt">
                                    <i class="ti ti-check me-1"></i>Hoạt động
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary-lt">
                                    <i class="ti ti-ban me-1"></i>Vô hiệu hóa
                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- THAO TÁC -->
                        <td class="text-center">
                            <a href="<?php echo WEBROOT; ?>/admin/toggleCustomerStatus/<?php echo $customer['user_id']; ?>" 
                              class="btn btn-sm btn-icon <?php echo $customer['is_active'] ? 'btn-ghost-warning' : 'btn-ghost-success'; ?>"
                              onclick="return confirm('<?php echo $customer['is_active'] ? 'Vô hiệu hóa' : 'Kích hoạt'; ?> tài khoản này?')"
                              title="<?php echo $customer['is_active'] ? 'Vô hiệu hóa' : 'Kích hoạt'; ?>">
                                <i class="ti ti-<?php echo $customer['is_active'] ? 'ban' : 'check'; ?>"></i>
                            </a>

                            <?php if ($customer['user_id'] != $_SESSION['user_id']): ?>
                                <a href="<?php echo WEBROOT; ?>/admin/deleteCustomer/<?php echo $customer['user_id']; ?>" 
                                  class="btn btn-sm btn-icon btn-ghost-danger"
                                  onclick="return confirm('Xóa khách hàng này? Không thể hoàn tác!')"
                                  title="Xóa">
                                    <i class="ti ti-trash"></i>
                                </a>
                            <?php else: ?>
                                <button class="btn btn-sm btn-icon btn-ghost-secondary" 
                                        disabled
                                        title="Không thể xóa chính mình">
                                    <i class="ti ti-lock"></i>
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">Chưa có khách hàng nào</td>
                </tr>
            <?php endif; ?>
        </tbody>
        </table>
      </div>
      
      <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-muted">
            Hiển thị <span><?php echo count($paginatedCustomers); ?></span> / <strong><?php echo $totalCustomers; ?></strong> khách hàng
        </p>
        
        <?php if ($totalPages > 1): ?>
        <ul class="pagination m-0 ms-auto">
            <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo WEBROOT; ?>/admin/customers?page=<?php echo $currentPage - 1; ?>">
                    <i class="ti ti-chevron-left"></i>
                </a>
            </li>

            <?php
                $range = 2;
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($i == 1 || $i == $totalPages || ($i >= $currentPage - $range && $i <= $currentPage + $range)) {
                        ?>
                        <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                            <a class="page-link" href="<?php echo WEBROOT; ?>/admin/customers?page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                        <?php
                    } 
                    elseif ($i == $currentPage - $range - 1 || $i == $currentPage + $range + 1) {
                        ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php
                    }
                }
            ?>

            <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo WEBROOT; ?>/admin/customers?page=<?php echo $currentPage + 1; ?>">
                    <i class="ti ti-chevron-right"></i>
                </a>
            </li>
        </ul>
        <?php endif; ?>
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
    str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, ""); 
    return str.toLowerCase().trim();
}

const allCustomers = <?php echo json_encode($customers); ?>;
const searchInput = document.getElementById('searchInput');
const tableBody = document.querySelector('#customerTable tbody');
const pagination = document.querySelector('.card-footer');

if (searchInput) {
    searchInput.addEventListener('input', function(e) {
        const keyword = removeVietnameseTones(e.target.value);
        
        if (keyword === '') {
            location.reload();
            return;
        }
        
        if (pagination) {
            pagination.style.display = 'none';
        }
        
        const filtered = allCustomers.filter(customer => {
            const searchText = removeVietnameseTones(
                (customer.full_name || '') + ' ' + 
                customer.email + ' ' + 
                customer.username + ' ' + 
                (customer.phone || '')
            );
            return searchText.includes(keyword);
        });
        
        renderCustomers(filtered);
    });
}

function renderCustomers(customers) {
    if (customers.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="7" class="text-center text-muted py-5">Không tìm thấy khách hàng phù hợp</td></tr>';
        return;
    }
    
    let html = '';
    customers.forEach(customer => {
        const avatarUrl = customer.avatar 
            ? '<?php echo WEBROOT; ?>/public/assets/Clients/avatars/' + customer.avatar
            : '<?php echo WEBROOT; ?>/public/assets/Clients/avatars/default-avatar.png';
        
        const isActive = customer.is_active == 1;
        const canDelete = customer.user_id != <?php echo $_SESSION['user_id']; ?>;
        
        html += `
            <tr>
                <td>
                    <span class="avatar avatar-md rounded" 
                          style="background-image: url('${avatarUrl}')">
                    </span>
                </td>
                <td>
                    <div>
                        <div class="fw-bold">${escapeHtml(customer.full_name || 'Chưa cập nhật')}</div>
                        <div class="text-muted small">
                            <i class="ti ti-mail me-1"></i>${escapeHtml(customer.email)}
                        </div>
                        ${customer.phone ? `<div class="text-muted small"><i class="ti ti-phone me-1"></i>${escapeHtml(customer.phone)}</div>` : ''}
                    </div>
                </td>
                <td>
                    <code class="text-muted">${escapeHtml(customer.username)}</code>
                </td>
                <td class="text-center">
                    <span class="badge bg-azure-lt fs-6">${customer.total_orders} đơn</span>
                </td>
                <td class="text-center">
                    <span class="text-success fw-bold">${formatPrice(customer.total_spent)} ₫</span>
                </td>
                <td class="text-center">
                    ${isActive ? 
                        '<span class="badge bg-success-lt"><i class="ti ti-check me-1"></i>Hoạt động</span>' : 
                        '<span class="badge bg-secondary-lt"><i class="ti ti-ban me-1"></i>Vô hiệu hóa</span>'
                    }
                </td>
                <td class="text-center">
                    <a href="<?php echo WEBROOT; ?>/admin/toggleCustomerStatus/${customer.user_id}" 
                       class="btn btn-sm btn-icon ${isActive ? 'btn-ghost-warning' : 'btn-ghost-success'}"
                       onclick="return confirm('${isActive ? 'Vô hiệu hóa' : 'Kích hoạt'} tài khoản này?')"
                       title="${isActive ? 'Vô hiệu hóa' : 'Kích hoạt'}">
                        <i class="ti ti-${isActive ? 'ban' : 'check'}"></i>
                    </a>
                    ${canDelete ? `
                        <a href="<?php echo WEBROOT; ?>/admin/deleteCustomer/${customer.user_id}" 
                           class="btn btn-sm btn-icon btn-ghost-danger"
                           onclick="return confirm('Xóa khách hàng này? Không thể hoàn tác!')"
                           title="Xóa">
                            <i class="ti ti-trash"></i>
                        </a>
                    ` : `
                        <button class="btn btn-sm btn-icon btn-ghost-secondary" 
                                disabled
                                title="Không thể xóa chính mình">
                            <i class="ti ti-lock"></i>
                        </button>
                    `}
                </td>
            </tr>
        `;
    });
    
    tableBody.innerHTML = html;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN').format(price);
}
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