<div class="container my-5">
    
    <div class="d-flex align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0"><i class="fas fa-shopping-cart me-2"></i>Giỏ hàng của bạn</h2>
        <span class="badge bg-secondary ms-3 rounded-pill fs-6">
            <?php echo !empty($cart_items) ? count($cart_items) : 0; ?> sản phẩm
        </span>
    </div>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($cart_items)): ?>
        
        <div class="row">
            
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 45%;" class="ps-4">Sản phẩm</th>
                                    <th style="width: 15%;">Đơn giá</th>
                                    <th style="width: 20%;">Số lượng</th>
                                    <th style="width: 15%;" class="text-end pe-4">Thành tiền</th>
                                    <th style="width: 5%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart_items as $item): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <?php 
                                                    $img = !empty($item['cover_image']) ? $item['cover_image'] : 'default-book.jpg';
                                                    $link = WEBROOT . '/product/detail/' . $item['book_id'];
                                                ?>
                                                <a href="<?php echo $link; ?>">
                                                    <img src="<?php echo WEBROOT . '/public/images/' . $img; ?>" 
                                                         class="rounded border me-3 shadow-sm" 
                                                         style="width: 60px; height: 80px; object-fit: cover;">
                                                </a>
                                                <div>
                                                    <a href="<?php echo $link; ?>" class="text-decoration-none text-dark fw-bold text-truncate d-block" style="max-width: 250px;">
                                                        <?php echo htmlspecialchars($item['title']); ?>
                                                    </a>
                                                    <small class="text-muted">Mã: #<?php echo $item['book_id']; ?></small>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <?php if($item['final_price'] < $item['price']): ?>
                                                <div class="text-danger fw-bold"><?php echo number_format($item['final_price'], 0, ',', '.'); ?> ₫</div>
                                                <div class="text-muted text-decoration-line-through small"><?php echo number_format($item['price'], 0, ',', '.'); ?> ₫</div>
                                            <?php else: ?>
                                                <div class="fw-bold text-dark"><?php echo number_format($item['final_price'], 0, ',', '.'); ?> ₫</div>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <form action="<?php echo WEBROOT; ?>/cart/update" method="POST">
                                                <input type="hidden" name="product_id" value="<?php echo $item['book_id']; ?>">
                                                <div class="input-group input-group-sm" style="width: 110px;">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown(); this.parentNode.parentNode.submit();">-</button>
                                                    
                                                    <input type="number" name="quantity" 
                                                           value="<?php echo $item['buy_qty']; ?>" 
                                                           class="form-control text-center" 
                                                           min="1" max="99"
                                                           onchange="this.form.submit()">
                                                           
                                                    <button class="btn btn-outline-secondary" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp(); this.parentNode.parentNode.submit();">+</button>
                                                </div>
                                            </form>
                                        </td>

                                        <td class="text-end pe-4 fw-bold text-primary fs-6">
                                            <?php echo number_format($item['subtotal'], 0, ',', '.'); ?> ₫
                                        </td>

                                        <td class="text-center">
                                            <a href="<?php echo WEBROOT; ?>/cart/remove/<?php echo $item['book_id']; ?>" 
                                               class="text-danger btn btn-sm btn-link"
                                               onclick="return confirm('Bạn muốn xóa cuốn sách này khỏi giỏ?');"
                                               title="Xóa">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mt-3">
                    <a href="<?php echo WEBROOT; ?>/product" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Tiếp tục xem sách
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm bg-light sticky-top" style="top: 80px; z-index: 1;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 border-bottom pb-3">Cộng giỏ hàng</h5>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Tạm tính:</span>
                            <span class="fw-bold"><?php echo number_format($total_price, 0, ',', '.'); ?> ₫</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Phí vận chuyển:</span>
                            <span class="text-success fw-bold"><?php echo number_format(15000, 0, ',', '.'); ?> ₫</span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-4 align-items-center">
                            <span class="fs-5 fw-bold text-dark">Tổng cộng:</span>
                            <span class="fs-3 fw-bold text-danger"><?php echo number_format($total_price + 15000, 0, ',', '.'); ?> ₫</span>
                        </div>

                        <div class="d-grid gap-2">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="<?php echo WEBROOT; ?>/order/checkout" class="btn btn-primary btn-lg fw-bold py-3 shadow-sm">
                                    XÁC NHẬN ĐẶT HÀNG <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            <?php else: ?>
                                <a href="<?php echo WEBROOT; ?>/user/login" class="btn btn-warning btn-lg fw-bold py-3 shadow-sm text-white">
                                    ĐĂNG NHẬP ĐỂ MUA HÀNG
                                </a>
                                <small class="text-center text-muted mt-2">Bạn cần đăng nhập để thanh toán.</small>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mt-4 pt-3 border-top text-center text-muted small">
                            <div class="row">
                                <div class="col-4">
                                    <i class="fas fa-lock mb-1"></i><br>Bảo mật
                                </div>
                                <div class="col-4">
                                    <i class="fas fa-undo mb-1"></i><br>Hoàn trả
                                </div>
                                <div class="col-4">
                                    <i class="fas fa-star mb-1"></i><br>Uy tín
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="text-center py-5 bg-white shadow-sm rounded">
            <div class="mb-4">
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-cart-7359557-6024626.png" 
                     style="width: 250px; opacity: 0.8;" alt="Empty Cart">
            </div>
            <h3 class="text-muted fw-bold">Giỏ hàng của bạn đang trống!</h3>
            <p class="text-secondary mb-4">Có vẻ như bạn chưa chọn cuốn sách nào.</p>
            <a href="<?php echo WEBROOT; ?>/product" class="btn btn-primary btn-lg px-5 fw-bold">
                <i class="fas fa-shopping-bag me-2"></i> Mua sắm ngay
            </a>
        </div>
    <?php endif; ?>

</div>