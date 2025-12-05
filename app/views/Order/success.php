<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            
            <div class="card border-0 shadow-sm p-5">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white" 
                         style="width: 100px; height: 100px;">
                        <i class="fas fa-check fa-4x"></i>
                    </div>
                </div>
                
                <h2 class="fw-bold text-success mb-3">Đặt hàng thành công!</h2>
                <p class="text-muted lead">
                    Cảm ơn bạn đã mua sắm tại Bookstore. <br>
                    Đơn hàng của bạn đang được xử lý và sẽ sớm được giao đến bạn.
                </p>
                
                <div class="alert alert-light border d-inline-block px-5 py-3 my-3">
                    <span class="text-muted small d-block mb-1">Mã đơn hàng của bạn:</span>
                    <span class="fw-bold fs-3 text-primary text-uppercase">
                        #<?php echo htmlspecialchars($order['order_number'] ?? 'ORD-XXXX'); ?>
                    </span>
                </div>
                
                <p class="text-muted small mb-4">
                    Bạn có thể xem chi tiết đơn hàng trong mục 
                    <a href="<?php echo WEBROOT; ?>/order/history" class="text-decoration-none fw-bold">Đơn hàng của tôi</a>.
                </p>
                
                <div class="d-flex justify-content-center gap-3">
                    <a href="<?php echo WEBROOT; ?>/product" class="btn btn-outline-secondary px-4 py-2">
                        <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                    </a>
                    
                    <a href="<?php echo WEBROOT; ?>/order/history" class="btn btn-primary px-4 py-2">
                        Xem đơn hàng <i class="fas fa-file-invoice ms-2"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>