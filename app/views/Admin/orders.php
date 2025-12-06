<?php
// filepath: d:\.code\XAMPP\xampp\htdocs\Bookstore\app\views\Admin\orders.php
?>

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Quản lý Đơn hàng</h2>
        <div class="text-muted mt-1">Theo dõi và xử lý các đơn đặt hàng</div>
      </div>
      <!-- THỐNG KÊ NHANH -->
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <span class="badge bg-warning-lt fs-5">
            <i class="ti ti-clock me-1"></i>
            <?php echo $this->orderModel->countOrdersByStatus('pending') ?? 0; ?> chờ xử lý
          </span>
          <span class="badge bg-info-lt fs-5">
            <i class="ti ti-truck me-1"></i>
            <?php echo $this->orderModel->countOrdersByStatus('shipping') ?? 0; ?> đang giao
          </span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    
    <!-- THÔNG BÁO SUCCESS -->
    <?php if(!empty($success)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check me-2"></i> <?php echo htmlspecialchars($success); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- THÔNG BÁO ERROR -->
    <?php if(!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-alert-circle me-2"></i> <?php echo htmlspecialchars($error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white">
          <h3 class="card-title">Danh sách đơn hàng</h3>
          <div class="card-actions">
            <div class="input-icon">
                <span class="input-icon-addon"><i class="ti ti-search"></i></span>
                <input type="text" class="form-control" placeholder="Tìm mã đơn, tên khách..." id="searchInput">
            </div>
          </div>
      </div>

      <div class="table-responsive">
        <table class="table table-vcenter table-hover align-middle mb-0" id="orderTable">
          <thead class="bg-light">
            <tr>
              <th style="width: 120px;">Mã đơn</th>
              <th>Khách hàng</th>
              <th style="width: 150px;">Tổng tiền</th>
              <th style="width: 130px;">Trạng thái đơn</th>
              <th style="width: 130px;">Thanh toán</th>
              <th style="width: 150px;">Ngày đặt</th>
              <th style="width: 120px;" class="text-center">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($paginatedOrders)): ?>
                <?php foreach($paginatedOrders as $order): ?>
                
                <?php 
                    // 1. Trạng thái Đơn hàng
                    $statusClass = 'secondary';
                    $statusIcon = 'ti-question-mark';
                    $statusLabel = 'Không rõ';
                    
                    switch($order['status']) {
                        case 'pending':     
                            $statusClass = 'warning'; 
                            $statusIcon = 'ti-clock';
                            $statusLabel = 'Chờ xử lý'; 
                            break;
                        case 'confirmed':   
                            $statusClass = 'info';    
                            $statusIcon = 'ti-check';
                            $statusLabel = 'Đã xác nhận'; 
                            break;
                        case 'shipping':    
                            $statusClass = 'azure';   
                            $statusIcon = 'ti-truck-delivery';
                            $statusLabel = 'Đang giao'; 
                            break;
                        case 'delivered':   
                            $statusClass = 'success'; 
                            $statusIcon = 'ti-package';
                            $statusLabel = 'Đã giao'; 
                            break;
                        case 'cancelled':   
                            $statusClass = 'danger';  
                            $statusIcon = 'ti-x';
                            $statusLabel = 'Đã hủy'; 
                            break;
                    }

                    // 2. Trạng thái Thanh toán
                    $paymentClass = 'secondary';
                    $paymentIcon = 'ti-question-mark';
                    $paymentLabel = 'Không rõ';
                    
                    switch($order['payment_status']) {
                        case 'unpaid':
                            $paymentClass = 'warning';
                            $paymentIcon = 'ti-clock';
                            $paymentLabel = 'Chưa thanh toán';
                            break;
                        case 'paid':
                            $paymentClass = 'success';
                            $paymentIcon = 'ti-check';
                            $paymentLabel = 'Đã thanh toán';
                            break;
                        case 'refunded':
                            $paymentClass = 'danger';
                            $paymentIcon = 'ti-refresh';
                            $paymentLabel = 'Đã hoàn tiền';
                            break;
                    }
                ?>

                <tr>
                    <!-- MÃ ĐơN -->
                    <td>
                        <a href="<?php echo WEBROOT; ?>/admin/orderDetail/<?php echo $order['order_id']; ?>" 
                          class="text-primary fw-bold text-decoration-none">
                            #<?php echo htmlspecialchars($order['order_number']); ?>
                        </a>
                    </td>

                    <!-- KHÁCH HÀNG -->
                    <td>
                        <div class="fw-bold"><?php echo htmlspecialchars($order['full_name']); ?></div>
                        <div class="text-muted small">
                            <i class="ti ti-phone me-1"></i>
                            <?php echo htmlspecialchars($order['phone']); ?>
                        </div>
                    </td>

                    <!-- TỔNG TIỀN -->
                    <td>
                        <span class="fw-bold text-success">
                            <?php echo number_format($order['final_amount']); ?> ₫
                        </span>
                    </td>

                    <!-- TRẠNG THÁI ĐƠN -->
                    <td>
                        <span class="badge bg-<?php echo $statusClass; ?>-lt">
                            <i class="ti <?php echo $statusIcon; ?> me-1"></i>
                            <?php echo $statusLabel; ?>
                        </span>
                    </td>

                    <!-- THANH TOÁN -->
                    <td>
                        <span class="badge bg-<?php echo $paymentClass; ?>-lt">
                            <i class="ti <?php echo $paymentIcon; ?> me-1"></i>
                            <?php echo $paymentLabel; ?>
                        </span>
                    </td>

                    <!-- NGÀY ĐẶT -->
                    <td>
                        <div><?php echo date('d/m/Y', strtotime($order['order_date'])); ?></div>
                        <div class="text-muted small">
                            <?php echo date('H:i', strtotime($order['order_date'])); ?>
                        </div>
                    </td>

                    <!-- THAO TÁC -->
                    <td class="text-center">
                        <a href="<?php echo WEBROOT; ?>/admin/orderDetail/<?php echo $order['order_id']; ?>" 
                          class="btn btn-sm btn-icon btn-ghost-primary"
                          title="Chi tiết">
                            <i class="ti ti-eye"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">Chưa có đơn hàng nào</td>
                </tr>
            <?php endif; ?>
        </tbody>
        </table>
      </div>
      

      <!-- Pagination -->
      <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-muted">
            Hiển thị <span><?php echo count($paginatedOrders); ?></span> / <strong><?php echo $totalOrders; ?></strong> đơn hàng
        </p>
        
        <?php if ($totalPages > 1): ?>
        <ul class="pagination m-0 ms-auto">
            <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo WEBROOT; ?>/admin/orders?page=<?php echo $currentPage - 1; ?>">
                    <i class="ti ti-chevron-left"></i>
                </a>
            </li>

            <?php
                $range = 2;
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($i == 1 || $i == $totalPages || ($i >= $currentPage - $range && $i <= $currentPage + $range)) {
                        ?>
                        <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                            <a class="page-link" href="<?php echo WEBROOT; ?>/admin/orders?page=<?php echo $i; ?>">
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
                <a class="page-link" href="<?php echo WEBROOT; ?>/admin/orders?page=<?php echo $currentPage + 1; ?>">
                    <i class="ti ti-chevron-right"></i>
                </a>
            </li>
        </ul>
        <?php endif; ?>
    </div>


      
    </div>
  </div>
</div>

<script>
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

const allOrders = <?php echo json_encode($orders); ?>;
const searchInput = document.getElementById('searchInput');
const tableBody = document.querySelector('#orderTable tbody');
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
        
        const filtered = allOrders.filter(order => {
            const searchText = removeVietnameseTones(
                order.order_number + ' ' + 
                (order.full_name || '') + ' ' + 
                (order.phone || '') + ' ' +
                (order.email || '')
            );
            return searchText.includes(keyword);
        });
        
        renderOrders(filtered);
    });
}

function renderOrders(orders) {
    if (orders.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="7" class="text-center text-muted py-5">Không tìm thấy đơn hàng phù hợp</td></tr>';
        return;
    }
    
    let html = '';
    orders.forEach(order => {
        // Map trạng thái
        const statusMap = {
            'pending': { class: 'warning', icon: 'ti-clock', label: 'Chờ xử lý' },
            'confirmed': { class: 'info', icon: 'ti-check', label: 'Đã xác nhận' },
            'shipping': { class: 'azure', icon: 'ti-truck-delivery', label: 'Đang giao' },
            'delivered': { class: 'success', icon: 'ti-package', label: 'Đã giao' },
            'cancelled': { class: 'danger', icon: 'ti-x', label: 'Đã hủy' }
        };
        
        const paymentMap = {
            'unpaid': { class: 'warning', icon: 'ti-clock', label: 'Chưa thanh toán' },
            'paid': { class: 'success', icon: 'ti-check', label: 'Đã thanh toán' },
            'refunded': { class: 'danger', icon: 'ti-refresh', label: 'Đã hoàn tiền' }
        };
        
        const status = statusMap[order.status] || { class: 'secondary', icon: 'ti-question-mark', label: 'Không rõ' };
        const payment = paymentMap[order.payment_status] || { class: 'secondary', icon: 'ti-question-mark', label: 'Không rõ' };
        
        const orderDate = new Date(order.order_date);
        const dateStr = orderDate.toLocaleDateString('vi-VN');
        const timeStr = orderDate.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
        
        html += `
            <tr>
                <td>
                    <a href="<?php echo WEBROOT; ?>/admin/orderDetail/${order.order_id}" 
                       class="text-primary fw-bold text-decoration-none">
                        #${escapeHtml(order.order_number)}
                    </a>
                </td>
                <td>
                    <div class="fw-bold">${escapeHtml(order.full_name)}</div>
                    <div class="text-muted small">
                        <i class="ti ti-phone me-1"></i>${escapeHtml(order.phone)}
                    </div>
                </td>
                <td>
                    <span class="fw-bold text-success">${formatPrice(order.final_amount)} ₫</span>
                </td>
                <td>
                    <span class="badge bg-${status.class}-lt">
                        <i class="ti ${status.icon} me-1"></i>${status.label}
                    </span>
                </td>
                <td>
                    <span class="badge bg-${payment.class}-lt">
                        <i class="ti ${payment.icon} me-1"></i>${payment.label}
                    </span>
                </td>
                <td>
                    <div>${dateStr}</div>
                    <div class="text-muted small">${timeStr}</div>
                </td>
                <td class="text-center">
                    <a href="<?php echo WEBROOT; ?>/admin/orderDetail/${order.order_id}" 
                       class="btn btn-sm btn-icon btn-ghost-primary"
                       title="Chi tiết">
                        <i class="ti ti-eye"></i>
                    </a>
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
.empty-img i {
    color: #cbd5e1;
}
</style>