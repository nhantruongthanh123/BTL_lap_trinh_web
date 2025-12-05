<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-file-invoice me-2"></i>
                        Chi tiết đơn hàng #<?php echo htmlspecialchars($order['order_number']); ?>
                    </h4>
                    <div>
                        <a href="<?php echo WEBROOT; ?>/user/orders" class="btn btn-light btn-sm me-2">
                            <i class="fas fa-arrow-left me-1"></i>Đơn hàng của tôi
                        </a>
                        <a href="<?php echo WEBROOT; ?>/user/orderHistory" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-history me-1"></i>Lịch sử
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    
                    <!-- Order Status Timeline -->
                    <div class="alert alert-light border mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">
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
                                            'shipping' => 'Đang giao hàng',
                                            'delivered' => 'Đã giao hàng',
                                            'cancelled' => 'Đã hủy'
                                        ];
                                        $statusIcon = [
                                            'pending' => 'fa-clock',
                                            'confirmed' => 'fa-check-circle',
                                            'processing' => 'fa-box',
                                            'shipping' => 'fa-shipping-fast',
                                            'delivered' => 'fa-check-double',
                                            'cancelled' => 'fa-times-circle'
                                        ];
                                    ?>
                                    <span class="badge <?php echo $statusBadge[$order['status']]; ?> fs-6">
                                        <i class="fas <?php echo $statusIcon[$order['status']]; ?> me-2"></i>
                                        <?php echo $statusText[$order['status']]; ?>
                                    </span>
                                </h5>
                                <p class="mb-0 text-muted">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    Đặt hàng lúc: <strong><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></strong>
                                </p>
                            </div>
                            <?php if ($order['status'] === 'pending'): ?>
                                <div>
                                    <a href="<?php echo WEBROOT; ?>/user/cancelOrder/<?php echo $order['order_id']; ?>" 
                                       class="btn btn-danger"
                                       onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                                        <i class="fas fa-times me-1"></i>Hủy đơn hàng
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Order Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 text-primary">
                                        <i class="fas fa-info-circle me-2"></i>Thông tin đơn hàng
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <td class="text-muted" style="width: 40%;">Mã đơn hàng:</td>
                                            <td><strong class="text-primary"><?php echo htmlspecialchars($order['order_number']); ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Ngày đặt:</td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Thanh toán:</td>
                                            <td>
                                                <?php 
                                                    $paymentMethod = [
                                                        'cod' => '<i class="fas fa-money-bill-wave text-success me-1"></i>COD',
                                                        'bank_transfer' => '<i class="fas fa-university text-primary me-1"></i>Chuyển khoản',
                                                        'momo' => '<i class="fas fa-wallet text-danger me-1"></i>MoMo'
                                                    ];
                                                    echo $paymentMethod[$order['payment_method']];
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Trạng thái TT:</td>
                                            <td>
                                                <?php
                                                    $paymentStatusBadge = [
                                                        'unpaid' => 'bg-warning text-dark',
                                                        'paid' => 'bg-success',
                                                        'refunded' => 'bg-secondary'
                                                    ];
                                                    $paymentStatusText = [
                                                        'unpaid' => 'Chưa thanh toán',
                                                        'paid' => 'Đã thanh toán',
                                                        'refunded' => 'Đã hoàn tiền'
                                                    ];
                                                ?>
                                                <span class="badge <?php echo $paymentStatusBadge[$order['payment_status']]; ?>">
                                                    <?php echo $paymentStatusText[$order['payment_status']]; ?>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 text-primary">
                                        <i class="fas fa-shipping-fast me-2"></i>Thông tin giao hàng
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <td class="text-muted" style="width: 40%;">Người nhận:</td>
                                            <td><strong><?php echo htmlspecialchars($order['full_name']); ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Số điện thoại:</td>
                                            <td>
                                                <i class="fas fa-phone text-success me-1"></i>
                                                <?php echo htmlspecialchars($order['phone']); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Email:</td>
                                            <td>
                                                <i class="fas fa-envelope text-primary me-1"></i>
                                                <?php echo htmlspecialchars($order['email']); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Địa chỉ:</td>
                                            <td>
                                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                                <?php echo htmlspecialchars($order['shipping_address']); ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ghi chú -->
                    <?php if (!empty($order['note'])): ?>
                        <div class="alert alert-info mb-4">
                            <h6 class="mb-2"><i class="fas fa-sticky-note me-2"></i>Ghi chú đơn hàng:</h6>
                            <p class="mb-0"><em><?php echo htmlspecialchars($order['note']); ?></em></p>
                        </div>
                    <?php endif; ?>

                    <!-- Order Items -->
                    <h5 class="text-primary mb-3 border-bottom pb-2">
                        <i class="fas fa-list me-2"></i>Sản phẩm đã đặt
                    </h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50%;">Sản phẩm</th>
                                    <th class="text-center" style="width: 15%;">Số lượng</th>
                                    <th class="text-end" style="width: 17.5%;">Đơn giá</th>
                                    <th class="text-end" style="width: 17.5%;">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order_items as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php 
                                                    $img = !empty($item['cover_image']) ? $item['cover_image'] : 'default-book.jpg';
                                                ?>
                                                <img src="<?php echo WEBROOT . '/public/images/' . $img; ?>" 
                                                     class="rounded me-3 border" 
                                                     style="width: 60px; height: 80px; object-fit: cover;">
                                                <div>
                                                    <strong><?php echo htmlspecialchars($item['book_title']); ?></strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="badge bg-secondary fs-6"><?php echo $item['quantity']; ?></span>
                                        </td>
                                        <td class="text-end align-middle"><?php echo number_format($item['price']); ?> ₫</td>
                                        <td class="text-end align-middle">
                                            <strong class="text-primary"><?php echo number_format($item['subtotal']); ?> ₫</strong>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Order Summary -->
                    <div class="row">
                        <div class="col-md-6 offset-md-6">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <td class="text-muted">Tạm tính:</td>
                                            <td class="text-end"><strong><?php echo number_format($order['total_amount']); ?> ₫</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Phí vận chuyển:</td>
                                            <td class="text-end">
                                                <?php if ($order['shipping_fee'] == 0): ?>
                                                    <span class="text-success fw-bold">MIỄN PHÍ</span>
                                                <?php else: ?>
                                                    <?php echo number_format($order['shipping_fee']); ?> ₫
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php if ($order['discount_amount'] > 0): ?>
                                            <tr>
                                                <td class="text-muted">
                                                    Giảm giá
                                                    <?php if (!empty($order['coupon_code'])): ?>
                                                        <span class="badge bg-success ms-1"><?php echo htmlspecialchars($order['coupon_code']); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end text-danger fw-bold">-<?php echo number_format($order['discount_amount']); ?> ₫</td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr class="border-top">
                                            <td><h5 class="mb-0 text-dark">Tổng cộng:</h5></td>
                                            <td class="text-end">
                                                <h4 class="text-danger mb-0 fw-bold"><?php echo number_format($order['final_amount']); ?> ₫</h4>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>