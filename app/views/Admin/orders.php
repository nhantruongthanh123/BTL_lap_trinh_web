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
            <?php if (!empty($orders)): ?>
                <?php foreach($orders as $order): ?>
                
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
                            $statusLabel = 'Hoàn thành'; 
                            break;
                        case 'cancelled':   
                            $statusClass = 'danger';  
                            $statusIcon = 'ti-x';
                            $statusLabel = 'Đã hủy'; 
                            break;
                    }

                    // 2. Trạng thái Thanh toán
                    $payClass = 'secondary';
                    $payIcon = 'ti-credit-card-off';
                    $payLabel = 'Chưa thanh toán';
                    
                    if ($order['payment_status'] == 'paid') {
                        $payClass = 'success';
                        $payIcon = 'ti-credit-card';
                        $payLabel = 'Đã thanh toán';
                    } elseif ($order['payment_status'] == 'refunded') {
                        $payClass = 'danger';
                        $payIcon = 'ti-refresh';
                        $payLabel = 'Đã hoàn tiền';
                    }
                ?>

                <tr>
                  <!-- MÃ ĐƠN -->
                  <td>
                    <a href="<?php echo WEBROOT; ?>/admin/orderDetail/<?php echo $order['order_id']; ?>" 
                       class="text-reset fw-bold">
                        <span class="badge bg-blue-lt">#<?php echo htmlspecialchars($order['order_number']); ?></span>
                    </a>
                  </td>
                  
                  <!-- KHÁCH HÀNG -->
                  <td>
                    <div class="d-flex align-items-center">
                        <div class="flex-fill">
                            <div class="fw-bold"><?php echo htmlspecialchars($order['full_name'] ?? 'Khách lẻ'); ?></div>
                            <?php if (!empty($order['email'])): ?>
                                <div class="text-muted small"><?php echo htmlspecialchars($order['email']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                  </td>
                  
                  <!-- TỔNG TIỀN -->
                  <td>
                     <div class="fw-bold text-primary"><?php echo number_format($order['final_amount'], 0, ',', '.'); ?> ₫</div>
                     <?php if ($order['discount_amount'] > 0): ?>
                        <div class="text-muted small">Giảm: -<?php echo number_format($order['discount_amount'], 0, ',', '.'); ?>₫</div>
                     <?php endif; ?>
                  </td>

                  <!-- TRẠNG THÁI ĐƠN HÀNG -->
                  <td>
                     <span class="badge bg-<?php echo $statusClass; ?>-lt">
                        <i class="ti <?php echo $statusIcon; ?> me-1"></i>
                        <?php echo $statusLabel; ?>
                     </span>
                  </td>

                  <!-- TRẠNG THÁI THANH TOÁN -->
                  <td>
                     <span class="badge bg-<?php echo $payClass; ?>-lt">
                        <i class="ti <?php echo $payIcon; ?> me-1"></i>
                        <?php echo $payLabel; ?>
                     </span>
                  </td>
                  
                  <!-- NGÀY ĐẶT -->
                  <td class="text-muted">
                     <i class="ti ti-calendar me-1"></i>
                     <?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?>
                  </td>

                  <!-- THAO TÁC -->
                  <td class="text-center">
                    <a href="<?php echo WEBROOT; ?>/admin/orderDetail/<?php echo $order['order_id']; ?>" 
                       class="btn btn-sm btn-primary">
                        <i class="ti ti-eye me-1"></i>Chi tiết
                    </a>
                  </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="empty">
                            <div class="empty-img">
                                <i class="ti ti-package-off" style="font-size: 4rem; opacity: 0.3;"></i>
                            </div>
                            <p class="empty-title">Chưa có đơn hàng nào</p>
                            <p class="empty-subtitle text-muted">
                                Đơn hàng sẽ xuất hiện khi khách đặt mua
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
            Hiển thị <strong><?php echo count($orders); ?></strong> đơn hàng
        </p>
      </div>
    </div>
  </div>
</div>

<!-- JAVASCRIPT TÌM KIẾM -->
<script>
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    const keyword = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#orderTable tbody tr');
    
    rows.forEach(row => {
        const orderNumber = row.cells[0]?.innerText.toLowerCase() || '';
        const customerName = row.cells[1]?.innerText.toLowerCase() || '';
        
        if (orderNumber.includes(keyword) || customerName.includes(keyword)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

<style>
.empty-img i {
    color: #cbd5e1;
}
</style>