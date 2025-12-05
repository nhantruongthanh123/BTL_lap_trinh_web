<div class="container my-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-9 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-history me-2"></i>Lịch sử mua hàng
                    </h4>
                    <p class="mb-0 small mt-1">Tất cả đơn hàng của bạn được sắp xếp theo thời gian</p>
                </div>
                <div class="card-body">
                    
                    <?php if (empty($orders)): ?>
                        <!-- Chưa có đơn hàng -->
                        <div class="alert alert-info text-center py-5">
                            <i class="fas fa-inbox fa-3x mb-3 d-block text-muted"></i>
                            <h5>Chưa có lịch sử mua hàng</h5>
                            <p class="text-muted mb-3">Bạn chưa có đơn hàng nào</p>
                            <a href="<?php echo WEBROOT; ?>/product" class="btn btn-primary">
                                <i class="fas fa-shopping-cart me-2"></i>Bắt đầu mua sắm
                            </a>
                        </div>
                    <?php else: ?>
                        
                        <!-- Thống kê nhanh -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <i class="fas fa-shopping-bag fa-2x text-primary mb-2"></i>
                                        <h4 class="mb-0"><?php echo count($orders); ?></h4>
                                        <p class="text-muted mb-0 small">Tổng đơn hàng</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-success">
                                    <div class="card-body text-center">
                                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                        <h4 class="mb-0">
                                            <?php 
                                                $deliveredCount = count(array_filter($orders, function($o) { 
                                                    return $o['status'] === 'delivered'; 
                                                }));
                                                echo $deliveredCount;
                                            ?>
                                        </h4>
                                        <p class="text-muted mb-0 small">Đã hoàn thành</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-danger">
                                    <div class="card-body text-center">
                                        <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                                        <h4 class="mb-0">
                                            <?php 
                                                $cancelledCount = count(array_filter($orders, function($o) { 
                                                    return $o['status'] === 'cancelled'; 
                                                }));
                                                echo $cancelledCount;
                                            ?>
                                        </h4>
                                        <p class="text-muted mb-0 small">Đã hủy</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline Orders -->
                        <h5 class="border-bottom pb-2 mb-3">
                            <i class="far fa-calendar-alt me-2"></i>Danh sách đơn hàng
                        </h5>

                        <?php 
                        $currentYear = null;
                        $currentMonth = null;
                        foreach ($orders as $order): 
                            $orderYear = date('Y', strtotime($order['order_date']));
                            $orderMonth = date('m', strtotime($order['order_date']));
                            
                            // Hiển thị năm mới
                            if ($currentYear !== $orderYear):
                                if ($currentYear !== null): ?>
                                    </div> <!-- Đóng năm cũ -->
                                <?php endif;
                                $currentYear = $orderYear;
                                $currentMonth = null; // Reset tháng
                                ?>
                                <div class="year-group mb-4">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-calendar me-2"></i>Năm <?php echo $orderYear; ?>
                                    </h5>
                            <?php endif;
                            
                            // Hiển thị tháng mới
                            if ($currentMonth !== $orderMonth):
                                if ($currentMonth !== null): ?>
                                    </div> <!-- Đóng tháng cũ -->
                                <?php endif;
                                $currentMonth = $orderMonth;
                                ?>
                                <div class="month-group ms-3 mb-3">
                                    <h6 class="text-muted mb-2">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        Tháng <?php echo date('m/Y', strtotime($order['order_date'])); ?>
                                    </h6>
                            <?php endif; ?>

                            <!-- Order Card -->
                            <div class="card mb-3 border-start border-3 <?php 
                                echo $order['status'] === 'delivered' ? 'border-success' : 
                                    ($order['status'] === 'cancelled' ? 'border-danger' : 'border-primary'); 
                            ?>">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <!-- Thông tin đơn hàng -->
                                        <div class="col-md-7">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="mb-1">
                                                        <a href="<?php echo WEBROOT; ?>/user/orderDetail/<?php echo $order['order_id']; ?>" 
                                                           class="text-decoration-none text-primary fw-bold">
                                                            #<?php echo htmlspecialchars($order['order_number']); ?>
                                                        </a>
                                                    </h6>
                                                    <small class="text-muted">
                                                        <i class="far fa-clock me-1"></i>
                                                        <?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?>
                                                    </small>
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

                                            <div class="text-muted small">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                <?php echo htmlspecialchars($order['shipping_address']); ?>
                                            </div>

                                            <?php if (!empty($order['note'])): ?>
                                                <div class="mt-2">
                                                    <small class="text-muted fst-italic">
                                                        <i class="fas fa-sticky-note me-1"></i>
                                                        <?php echo htmlspecialchars($order['note']); ?>
                                                    </small>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Giá và actions -->
                                        <div class="col-md-5 text-end">
                                            <div class="mb-2">
                                                <?php if ($order['status'] === 'cancelled'): ?>
                                                    <del class="text-muted h5"><?php echo number_format($order['final_amount']); ?> ₫</del>
                                                    <br>
                                                    <span class="badge bg-danger mt-1">Không thu tiền</span>
                                                <?php else: ?>
                                                    <h5 class="text-danger mb-0">
                                                        <?php echo number_format($order['final_amount']); ?> ₫
                                                    </h5>
                                                <?php endif; ?>
                                            </div>

                                            <div class="btn-group" role="group">
                                                <a href="<?php echo WEBROOT; ?>/user/orderDetail/<?php echo $order['order_id']; ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i>Chi tiết
                                                </a>
                                                
                                                <?php if ($order['status'] === 'delivered'): ?>
                                                    <button class="btn btn-sm btn-outline-success" 
                                                            title="Mua lại"
                                                            onclick="alert('Chức năng đang phát triển')">
                                                        <i class="fas fa-redo me-1"></i>Mua lại
                                                    </button>
                                                <?php endif; ?>

                                                <?php if ($order['status'] === 'pending'): ?>
                                                    <a href="<?php echo WEBROOT; ?>/user/cancelOrder/<?php echo $order['order_id']; ?>" 
                                                       class="btn btn-sm btn-outline-danger"
                                                       onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                                                        <i class="fas fa-times me-1"></i>Hủy
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>

                        <?php if ($currentMonth !== null): ?>
                            </div> <!-- Đóng tháng cuối -->
                        <?php endif; ?>

                        <?php if ($currentYear !== null): ?>
                            </div> <!-- Đóng năm cuối -->
                        <?php endif; ?>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>