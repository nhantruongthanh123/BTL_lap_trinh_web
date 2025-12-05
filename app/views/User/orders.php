<div class="container my-5">
    <div class="row">

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-shopping-bag me-2"></i>Đơn hàng của tôi</h4>
                </div>
                <div class="card-body">
                    
                    <!-- Filter Tabs -->
                    <ul class="nav nav-pills mb-4">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_status === 'all' ? 'active' : ''; ?>" 
                               href="<?php echo WEBROOT; ?>/user/orders">
                                Tất cả đang xử lý
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_status === 'pending' ? 'active' : ''; ?>" 
                               href="<?php echo WEBROOT; ?>/user/orders?status=pending">
                                Chờ xác nhận
                                <?php if (isset($_SESSION['pending_orders']) && $_SESSION['pending_orders'] > 0): ?>
                                    <span class="badge bg-warning text-dark ms-1"><?php echo $_SESSION['pending_orders']; ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_status === 'confirmed' ? 'active' : ''; ?>" 
                               href="<?php echo WEBROOT; ?>/user/orders?status=confirmed">
                                Đã xác nhận
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_status === 'processing' ? 'active' : ''; ?>" 
                               href="<?php echo WEBROOT; ?>/user/orders?status=processing">
                                Đang xử lý
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_status === 'shipping' ? 'active' : ''; ?>" 
                               href="<?php echo WEBROOT; ?>/user/orders?status=shipping">
                                Đang giao
                            </a>
                        </li>
                    </ul>

                    <!-- Orders List -->
                    <?php if (empty($orders)): ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            <h5>Chưa có đơn hàng nào</h5>
                            <p class="mb-3">Bạn chưa có đơn hàng nào trong trạng thái này</p>
                            <a href="<?php echo WEBROOT; ?>/product" class="btn btn-primary">
                                <i class="fas fa-shopping-cart me-2"></i>Tiếp tục mua sắm
                            </a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <div class="card mb-3 border">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Mã đơn hàng:</strong> 
                                        <span class="text-primary"><?php echo htmlspecialchars($order['order_number']); ?></span>
                                        <span class="text-muted ms-3">
                                            <i class="far fa-calendar me-1"></i>
                                            <?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?>
                                        </span>
                                    </div>
                                    <div>
                                        <?php
                                            $statusBadge = [
                                                'pending' => 'bg-warning text-dark',
                                                'confirmed' => 'bg-info',
                                                'processing' => 'bg-primary',
                                                'shipping' => 'bg-primary',
                                                'delivered' => 'bg-success',
                                                'cancelled' => 'bg-danger'
                                            ];
                                            $statusText = [
                                                'pending' => 'Chờ xác nhận',
                                                'confirmed' => 'Đã xác nhận',
                                                'processing' => 'Đang xử lý',
                                                'shipping' => 'Đang giao',
                                                'delivered' => 'Đã giao',
                                                'cancelled' => 'Đã hủy'
                                            ];
                                        ?>
                                        <span class="badge <?php echo $statusBadge[$order['status']]; ?>">
                                            <?php echo $statusText[$order['status']]; ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <p class="mb-1">
                                                <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                                                <strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?>
                                            </p>
                                            <p class="mb-1">
                                                <i class="fas fa-credit-card me-2 text-success"></i>
                                                <strong>Thanh toán:</strong> 
                                                <?php 
                                                    $paymentMethod = [
                                                        'cod' => 'COD (Thanh toán khi nhận hàng)',
                                                        'bank_transfer' => 'Chuyển khoản ngân hàng',
                                                        'momo' => 'Ví MoMo'
                                                    ];
                                                    echo $paymentMethod[$order['payment_method']];
                                                ?>
                                            </p>
                                            <?php if (!empty($order['note'])): ?>
                                                <p class="mb-0 text-muted">
                                                    <i class="fas fa-sticky-note me-2"></i>
                                                    <em><?php echo htmlspecialchars($order['note']); ?></em>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <h4 class="text-danger mb-3">
                                                <?php echo number_format($order['final_amount']); ?> ₫
                                            </h4>
                                            <a href="<?php echo WEBROOT; ?>/user/orderDetail/<?php echo $order['order_id']; ?>" 
                                               class="btn btn-outline-primary btn-sm mb-2 w-100">
                                                <i class="fas fa-eye me-1"></i>Xem chi tiết
                                            </a>
                                            <?php if ($order['status'] === 'pending'): ?>
                                                <a href="<?php echo WEBROOT; ?>/user/cancelOrder/<?php echo $order['order_id']; ?>" 
                                                   class="btn btn-outline-danger btn-sm w-100"
                                                   onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                                                    <i class="fas fa-times me-1"></i>Hủy đơn
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>