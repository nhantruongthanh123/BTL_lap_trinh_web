<?php
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

// XÁC ĐỊNH TRẠNG THÁI THANH TOÁN
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

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle">Đơn hàng</div>
        <h2 class="page-title">#<?php echo htmlspecialchars($order['order_number']); ?></h2>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <a href="<?php echo WEBROOT; ?>/admin/orders" class="btn btn-ghost-secondary">
            <i class="ti ti-arrow-left me-1"></i>Quay lại
          </a>
          <button onclick="window.print()" class="btn btn-primary">
            <i class="ti ti-printer me-1"></i>In đơn hàng
          </button>
        </div>
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

    <div class="row row-cards">
      
      <!-- CỘT TRÁI: THÔNG TIN ĐƠN HÀNG -->
      <div class="col-lg-8">
        
        <!-- CHI TIẾT SẢN PHẨM -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Chi tiết sản phẩm</h3>
          </div>
          <div class="table-responsive">
            <table class="table table-vcenter card-table">
              <thead>
                <tr>
                  <th>Sản phẩm</th>
                  <th class="text-center" style="width: 100px;">Số lượng</th>
                  <th class="text-end" style="width: 150px;">Đơn giá</th>
                  <th class="text-end" style="width: 150px;">Thành tiền</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($orderItems)): ?>
                  <?php foreach ($orderItems as $item): ?>
                    <tr>
                      <!-- SẢN PHẨM -->
                      <td>
                        <div class="d-flex align-items-center">
                          <img src="<?php echo WEBROOT . '/public/images/' . ($item['cover_image'] ?? 'default-book.jpg'); ?>" 
                               alt="<?php echo htmlspecialchars($item['book_title']); ?>"
                               class="rounded me-3"
                               style="width: 50px; height: 70px; object-fit: cover;">
                          <div>
                            <div class="fw-bold"><?php echo htmlspecialchars($item['book_title']); ?></div>
                            <?php if (!empty($item['isbn'])): ?>
                              <small class="text-muted">ISBN: <?php echo htmlspecialchars($item['isbn']); ?></small>
                            <?php endif; ?>
                          </div>
                        </div>
                      </td>
                      
                      <!-- SỐ LƯỢNG -->
                      <td class="text-center">
                        <span class="badge bg-azure-lt fs-5"><?php echo $item['quantity']; ?></span>
                      </td>
                      
                      <!-- ĐƠN GIÁ -->
                      <td class="text-end">
                        <?php echo number_format($item['price'], 0, ',', '.'); ?> ₫
                      </td>
                      
                      <!-- THÀNH TIỀN -->
                      <td class="text-end fw-bold">
                        <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> ₫
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="4" class="text-center text-muted">Không có sản phẩm</td>
                  </tr>
                <?php endif; ?>
              </tbody>
              
              <!-- TỔNG TIỀN -->
              <tfoot>
                <tr>
                  <td colspan="3" class="text-end fw-bold">Tạm tính:</td>
                  <td class="text-end"><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> ₫</td>
                </tr>
                <tr>
                  <td colspan="3" class="text-end fw-bold">Phí vận chuyển:</td>
                  <td class="text-end"><?php echo number_format($order['shipping_fee'], 0, ',', '.'); ?> ₫</td>
                </tr>
                <?php if ($order['discount_amount'] > 0): ?>
                <tr>
                  <td colspan="3" class="text-end fw-bold text-danger">Giảm giá:</td>
                  <td class="text-end text-danger">-<?php echo number_format($order['discount_amount'], 0, ',', '.'); ?> ₫</td>
                </tr>
                <?php endif; ?>
                <tr class="bg-light">
                  <td colspan="3" class="text-end fw-bold fs-4">Tổng cộng:</td>
                  <td class="text-end fw-bold fs-3 text-primary">
                    <?php echo number_format($order['final_amount'], 0, ',', '.'); ?> ₫
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <!-- GHI CHÚ -->
        <?php if (!empty($order['notes'])): ?>
        <div class="card mt-3">
          <div class="card-header">
            <h3 class="card-title">Ghi chú đơn hàng</h3>
          </div>
          <div class="card-body">
            <p class="text-muted mb-0"><?php echo nl2br(htmlspecialchars($order['notes'])); ?></p>
          </div>
        </div>
        <?php endif; ?>

      </div>

      <!-- CỘT PHẢI: THÔNG TIN KHÁCH HÀNG VÀ TRẠNG THÁI -->
      <div class="col-lg-4">
        
        <!-- THÔNG TIN KHÁCH HÀNG -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Thông tin khách hàng</h3>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label fw-bold">Họ tên:</label>
              <div><?php echo htmlspecialchars($order['full_name'] ?? 'Khách lẻ'); ?></div>
            </div>
            
            <?php if (!empty($order['email'])): ?>
            <div class="mb-3">
              <label class="form-label fw-bold">Email:</label>
              <div>
                <a href="mailto:<?php echo $order['email']; ?>">
                  <?php echo htmlspecialchars($order['email']); ?>
                </a>
              </div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($order['phone'])): ?>
            <div class="mb-3">
              <label class="form-label fw-bold">Số điện thoại:</label>
              <div>
                <a href="tel:<?php echo $order['phone']; ?>">
                  <?php echo htmlspecialchars($order['phone']); ?>
                </a>
              </div>
            </div>
            <?php endif; ?>
            
            <div class="mb-0">
              <label class="form-label fw-bold">Địa chỉ giao hàng:</label>
              <div class="text-muted"><?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></div>
            </div>
          </div>
        </div>

        <!-- TRẠNG THÁI ĐƠN HÀNG -->
        <div class="card mt-3">
          <div class="card-header">
            <h3 class="card-title">Trạng thái đơn hàng</h3>
          </div>
          <div class="card-body">
            <form action="<?php echo WEBROOT; ?>/admin/updateOrderStatus" method="POST">
              <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
              
              <div class="mb-3">
                <label class="form-label fw-bold">Trạng thái hiện tại:</label>
                <div>
                  <span class="badge bg-<?php echo $statusClass; ?>-lt fs-5">
                    <i class="ti <?php echo $statusIcon; ?> me-1"></i>
                    <?php echo $statusLabel; ?>
                  </span>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Cập nhật trạng thái:</label>
                <select class="form-select" name="status" required>
                  <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>
                    ⏳ Chờ xử lý
                  </option>
                  <option value="confirmed" <?php echo $order['status'] == 'confirmed' ? 'selected' : ''; ?>>
                    ✅ Đã xác nhận
                  </option>
                  <option value="shipping" <?php echo $order['status'] == 'shipping' ? 'selected' : ''; ?>>
                    🚚 Đang giao hàng
                  </option>
                  <option value="delivered" <?php echo $order['status'] == 'delivered' ? 'selected' : ''; ?>>
                    📦 Đã giao hàng
                  </option>
                  <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>
                    ❌ Đã hủy
                  </option>
                </select>
              </div>

              <button type="submit" class="btn btn-primary w-100">
                <i class="ti ti-check me-1"></i>Cập nhật trạng thái
              </button>
            </form>
          </div>
        </div>

        <!-- TRẠNG THÁI THANH TOÁN -->
        <div class="card mt-3">
          <div class="card-header">
            <h3 class="card-title">Thanh toán</h3>
          </div>
          <div class="card-body">
            <form action="<?php echo WEBROOT; ?>/admin/updatePaymentStatus" method="POST">
              <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
              

              <div class="mb-3">
                <label class="form-label fw-bold">Trạng thái hiện tại:</label>
                <div>
                  <span class="badge bg-<?php echo $payClass; ?>-lt fs-5">
                    <i class="ti <?php echo $payIcon; ?> me-1"></i>
                    <?php echo $payLabel; ?>
                  </span>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Cập nhật trạng thái:</label>
                <select class="form-select" name="payment_status" required>
                  <option value="unpaid" <?php echo $order['payment_status'] == 'unpaid' ? 'selected' : ''; ?>>
                    ❌ Chưa thanh toán
                  </option>
                  <option value="paid" <?php echo $order['payment_status'] == 'paid' ? 'selected' : ''; ?>>
                    ✅ Đã thanh toán
                  </option>
                  <option value="refunded" <?php echo $order['payment_status'] == 'refunded' ? 'selected' : ''; ?>>
                    🔄 Đã hoàn tiền
                  </option>
                </select>
              </div>

              <button type="submit" class="btn btn-success w-100">
                <i class="ti ti-credit-card me-1"></i>Cập nhật thanh toán
              </button>
            </form>
          </div>
        </div>

        <!-- THÔNG TIN THỜI GIAN -->
        <div class="card mt-3">
          <div class="card-header">
            <h3 class="card-title">Thời gian</h3>
          </div>
          <div class="card-body">
            <div class="mb-2">
              <label class="form-label fw-bold">Ngày đặt hàng:</label>
              <div class="text-muted">
                <i class="ti ti-calendar me-1"></i>
                <?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?>
              </div>
            </div>
            
            <?php if ($order['updated_at'] != $order['order_date']): ?>
            <div class="mb-0">
              <label class="form-label fw-bold">Cập nhật lần cuối:</label>
              <div class="text-muted">
                <i class="ti ti-clock me-1"></i>
                <?php echo date('d/m/Y H:i', strtotime($order['updated_at'])); ?>
              </div>
            </div>
            <?php endif; ?>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

<style>
@media print {
  .page-header,
  .btn-list,
  .card-header,
  form {
    display: none !important;
  }
  
  .card {
    border: 1px solid #dee2e6 !important;
    box-shadow: none !important;
  }
}
</style>