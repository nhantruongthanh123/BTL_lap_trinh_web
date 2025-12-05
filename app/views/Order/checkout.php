<div class="container my-5">
    
    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-map-marker-alt me-2"></i>Thông tin giao hàng
                    </h5>
                </div>
                <div class="card-body p-4">
                    
                    <form action="<?php echo WEBROOT; ?>/order/placeOrder" method="POST" id="checkoutForm">
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Người nhận</label>
                            <input type="text" class="form-control bg-light" value="<?php echo htmlspecialchars($user['full_name']); ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Số điện thoại</label>
                            <input type="text" class="form-control bg-light" value="<?php echo htmlspecialchars($user['phone'] ?? 'Chưa cập nhật'); ?>" readonly>
                            <?php if(empty($user['phone'])): ?>
                                <small class="text-danger">
                                    <i class="fas fa-exclamation-circle"></i> Vui lòng <a href="<?php echo WEBROOT; ?>/user/profile">cập nhật số điện thoại</a> trước khi đặt hàng.
                                </small>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Địa chỉ nhận hàng <span class="text-danger">*</span></label>
                            <textarea name="shipping_address" class="form-control" rows="3" required 
                                      placeholder="Nhập địa chỉ chi tiết (Số nhà, đường, phường/xã...)"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Ghi chú đơn hàng (Tùy chọn)</label>
                            <textarea name="note" class="form-control" rows="2" placeholder="Ví dụ: Giao hàng trong giờ hành chính..."></textarea>
                        </div>

                             
                        <!-- COUPON SECTION -->
                        <?php if (!empty($available_coupons)): ?>
                        <h5 class="fw-bold text-primary mb-3 mt-4">
                            <i class="fas fa-tags me-2"></i>Mã giảm giá
                        </h5>

                        <div class="border rounded p-3 bg-light">
                            <div class="mb-3">
                                <label class="form-label">Chọn mã giảm giá có thể áp dụng</label>
                                <select name="coupon_code" id="couponSelect" class="form-select">
                                    <option value="">-- Không sử dụng mã giảm giá --</option>
                                    <?php foreach($available_coupons as $coupon): ?>
                                        <option value="<?php echo htmlspecialchars($coupon['code']); ?>" 
                                                data-type="<?php echo $coupon['discount_type']; ?>"
                                                data-value="<?php echo $coupon['discount_value']; ?>"
                                                data-min="<?php echo $coupon['min_order_value']; ?>">
                                            <?php echo htmlspecialchars($coupon['code']); ?> - 
                                            <?php if($coupon['discount_type'] == 'free_shipping'): ?>
                                                Miễn phí vận chuyển
                                            <?php else: ?>
                                                Giảm <?php echo number_format($coupon['discount_value']); ?> ₫
                                            <?php endif; ?>
                                            (Đơn tối thiểu: <?php echo number_format($coupon['min_order_value']); ?> ₫)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Coupon Details Display -->
                            <div id="couponDetails" class="alert alert-success d-none mt-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-check-circle me-2"></i>
                                        <strong id="couponMessage"></strong>
                                    </div>
                                    <button type="button" class="btn-close btn-sm" onclick="clearCoupon()"></button>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="alert alert-info mt-4">
                            <i class="fas fa-info-circle me-2"></i>
                            Không có mã giảm giá khả dụng cho đơn hàng này.
                        </div>
                        <?php endif; ?>
                        <!-- END COUPON SECTION -->


                        <h5 class="fw-bold text-primary mb-3"><i class="fas fa-credit-card me-2"></i>Phương thức thanh toán</h5>
                        
                        <div class="border rounded p-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                <label class="form-check-label fw-bold" for="cod">
                                    <i class="fas fa-money-bill-wave text-success me-2"></i>Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="bank" value="bank_transfer">
                                <label class="form-check-label" for="bank">
                                    <i class="fas fa-university text-primary me-2"></i>Chuyển khoản ngân hàng
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="momo" value="momo">
                                <label class="form-check-label" for="momo">
                                    <i class="fas fa-wallet text-danger me-2"></i>Ví MoMo
                                </label>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-header bg-transparent py-3 border-bottom">
                    <h5 class="mb-0 fw-bold">Đơn hàng của bạn (<?php echo count($cart_items); ?> sản phẩm)</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        
                        <?php foreach($cart_items as $item): ?>
                            <li class="list-group-item bg-transparent py-3">
                                <div class="d-flex align-items-center">
                                    <div class="position-relative">
                                        <?php 
                                            $img = !empty($item['cover_image']) ? $item['cover_image'] : 'default-book.jpg';
                                        ?>
                                        <img src="<?php echo WEBROOT . '/public/images/' . $img; ?>" 
                                             class="rounded border" style="width: 50px; height: 70px; object-fit: cover;">
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">
                                            <?php echo $item['buy_qty']; ?>
                                        </span>
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <h6 class="mb-0 text-truncate" style="max-width: 200px;">
                                            <?php echo htmlspecialchars($item['title']); ?>
                                        </h6>
                                        <small class="text-muted">
                                            <?php echo number_format($item['final_price']); ?> ₫ x <?php echo $item['buy_qty']; ?>
                                        </small>
                                    </div>
                                    <div class="fw-bold">
                                        <?php echo number_format($item['subtotal']); ?> ₫
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                    
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tạm tính</span>
                            <span class="fw-bold"><?php echo number_format($total_price); ?> ₫</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Phí vận chuyển</span>
                            <span class="text-success"> <?php echo number_format(15000); ?> ₫</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fs-5 fw-bold">Tổng cộng</span>
                            <span class="fs-3 fw-bold text-danger"><?php echo number_format($total_price + 15000); ?> ₫</span>
                        </div>

                        

                        <button type="submit" form="checkoutForm" class="btn btn-primary w-100 py-3 fs-5 fw-bold shadow-sm">
                            ĐẶT HÀNG NGAY
                        </button>
                        
                        <div class="text-center mt-3">
                            <a href="<?php echo WEBROOT; ?>/cart" class="text-decoration-none text-muted small">
                                <i class="fas fa-arrow-left me-1"></i>Quay lại giỏ hàng
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const couponSelect = document.getElementById('couponSelect');
    const couponDetails = document.getElementById('couponDetails');
    const couponMessage = document.getElementById('couponMessage');
    
    const baseTotal = <?php echo $total_price; ?>;
    const baseShippingFee = 15000;
    
    if (couponSelect) {
        couponSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (this.value === '') {
                clearCoupon();
                return;
            }
            
            const discountType = selectedOption.getAttribute('data-type');
            const discountValue = parseFloat(selectedOption.getAttribute('data-value'));
            const minOrder = parseFloat(selectedOption.getAttribute('data-min'));
            
            let newShippingFee = baseShippingFee;
            let discountAmount = 0;
            let message = '';
            
            if (discountType === 'free_shipping') {
                newShippingFee = 0;
                discountAmount = 0; 
                message = 'Miễn phí vận chuyển (Tiết kiệm ' + formatCurrency(baseShippingFee) + ' ₫)';
            } else if (discountType === 'fixed_amount') {
                discountAmount = discountValue;
                message = 'Giảm giá ' + formatCurrency(discountValue) + ' ₫ cho đơn hàng';
            }
            
            const finalTotal = baseTotal + newShippingFee - discountAmount;
            
            updatePriceDisplay(newShippingFee, discountAmount, finalTotal, discountType);
            
            couponMessage.textContent = message;
            couponDetails.classList.remove('d-none');
        });
    }
});

function clearCoupon() {
    const couponSelect = document.getElementById('couponSelect');
    const couponDetails = document.getElementById('couponDetails');
    
    if (couponSelect) couponSelect.value = '';
    if (couponDetails) couponDetails.classList.add('d-none');
    
    const baseTotal = <?php echo $total_price; ?>;
    updatePriceDisplay(15000, 0, baseTotal + 15000, null);
}

function updatePriceDisplay(shippingFee, discountAmount, finalTotal, discountType) {
    // Update shipping fee display
    const shippingElements = document.querySelectorAll('.d-flex.justify-content-between');
    let shippingElement = null;
    
    shippingElements.forEach(el => {
        if (el.textContent.includes('Phí vận chuyển')) {
            shippingElement = el.querySelector('.text-success');
        }
    });
    
    if (shippingElement) {
        if (shippingFee === 0) {
            shippingElement.innerHTML = '<del>' + formatCurrency(15000) + ' ₫</del> <span class="text-success fw-bold">MIỄN PHÍ</span>';
        } else {
            shippingElement.innerHTML = formatCurrency(shippingFee) + ' ₫';
        }
    }
    
    // Add or update discount row (CHỈ hiển thị khi discount_type = fixed_amount)
    let discountRow = document.getElementById('discountRow');
    const hrElement = document.querySelector('.p-4 hr');
    
    if (discountAmount > 0 && discountType === 'fixed_amount') {
        if (!discountRow) {
            discountRow = document.createElement('div');
            discountRow.id = 'discountRow';
            discountRow.className = 'd-flex justify-content-between mb-2';
            discountRow.innerHTML = `
                <span class="text-muted">Giảm giá</span>
                <span class="text-danger fw-bold">-<span id="discountValue"></span> ₫</span>
            `;
            hrElement.parentNode.insertBefore(discountRow, hrElement);
        }
        document.getElementById('discountValue').textContent = formatCurrency(discountAmount);
        discountRow.style.display = 'flex';
    } else {
        if (discountRow) {
            discountRow.style.display = 'none';
        }
    }
    
    // Update final total
    const finalTotalElement = document.querySelector('.fs-3.fw-bold.text-danger');
    if (finalTotalElement) {
        finalTotalElement.textContent = formatCurrency(finalTotal) + ' ₫';
    }
}

function formatCurrency(amount) {
    return Math.round(amount).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
</script>

