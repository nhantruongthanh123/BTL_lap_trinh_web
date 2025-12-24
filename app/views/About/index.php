<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* CSS Tùy chỉnh để làm đẹp thêm */
        .text-gradient {
            background: linear-gradient(45deg, #0d6efd, #0dcaf0);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Hiệu ứng cho phần Features */
        .feature-card {
            transition: all 0.3s ease;
            border-radius: 15px;
            background: #fff;
            /* Thêm viền mỏng để các ô rõ ràng hơn */
            border: 1px solid rgba(0,0,0,0.05) !important; 
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }
        .icon-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px auto;
        }
        
        /* --- ĐÃ SỬA: Tăng độ đậm màu nền từ 0.1 lên 0.25 --- */
        .bg-light-primary { 
            background-color: rgba(13, 110, 253, 0.25); 
            color: #0d6efd;
        }
        .bg-light-success { 
            background-color: rgba(25, 135, 84, 0.25); 
            color: #198754;
        }
        .bg-light-warning { 
            background-color: rgba(255, 193, 7, 0.25); 
            color: #ffc107;
        }
        /* ---------------------------------------------------- */

        /* Hiệu ứng cho phần Team */
        .team-card {
            transition: transform 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
        }
        .team-card:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        }
        .team-avatar {
            border: 4px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        /* Trang trí ảnh chính */
        .hero-img {
            border-radius: 20px;
            transform: rotate(2deg);
            transition: transform 0.5s;
        }
        .hero-img:hover {
            transform: rotate(0deg);
        }
    </style>
</head>
<body>

<div class="container my-5">
    
    <div class="row align-items-center mb-5 pt-4">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <span class="badge bg-primary bg-opacity-10 text-primary mb-2 px-3 py-2 rounded-pill fw-bold">Về chúng tôi</span>
            <h1 class="display-4 fw-bold mb-3">Mang <span class="text-gradient">tri thức</span> đến mọi nhà</h1>
            <p class="lead text-secondary mb-4">
                Bookstore được thành lập vào năm 2025 với sứ mệnh lan tỏa văn hóa đọc. 
                Chúng tôi tin rằng, mỗi cuốn sách là một người bạn, một người thầy vĩ đại.
            </p>
            <p class="text-muted">
                <i class="fas fa-check-circle text-success me-2"></i>Sách bản quyền 100%<br>
                <i class="fas fa-check-circle text-success me-2"></i>Giá cả ưu đãi cho sinh viên<br>
                <i class="fas fa-check-circle text-success me-2"></i>Không gian đọc sách hiện đại<br>
                <i class="fas fa-check-circle text-success me-2"></i>Đội ngũ hỗ trợ thân thiện và tận tâm
            </p>
        </div>
        <div class="col-lg-6 text-center">
            <img src="/Bookstore/public/images/AAA.jpg" 
            class="img-fluid shadow-lg hero-img w-100" 
            alt="Bookstore Library">
        </div>
    </div>

    <hr class="my-5 opacity-25">

    <div class="row text-center mb-5">
        <div class="col-12 mb-5">
            <h2 class="fw-bold display-6">Tại sao chọn <span class="text-primary">Bookstore?</span></h2>
            <p class="text-muted">Những giá trị cốt lõi mà chúng tôi cam kết mang lại</p>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm p-4 feature-card">
                <div class="card-body">
                    <div class="icon-wrapper bg-light-primary">
                        <i class="fas fa-book-open fa-2x"></i>
                    </div>
                    <h5 class="card-title fw-bold mt-3">Sách Chính Hãng 100%</h5>
                    <p class="card-text text-muted small">Cam kết hoàn tiền 200% nếu phát hiện sách giả, sách lậu. Nguồn gốc xuất xứ rõ ràng.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm p-4 feature-card">
                <div class="card-body">
                    <div class="icon-wrapper bg-light-success">
                        <i class="fas fa-shipping-fast fa-2x"></i>
                    </div>
                    <h5 class="card-title fw-bold mt-3">Giao Hàng Siêu Tốc</h5>
                    <p class="card-text text-muted small">Giao hàng nội thành trong 2h. Miễn phí vận chuyển toàn quốc cho đơn từ 200k.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm p-4 feature-card">
                <div class="card-body">
                    <div class="icon-wrapper bg-light-warning">
                        <i class="fas fa-headset fa-2x"></i>
                    </div>
                    <h5 class="card-title fw-bold mt-3">Hỗ Trợ 24/7</h5>
                    <p class="card-text text-muted small">Đội ngũ tư vấn nhiệt tình, hỗ trợ đổi trả sách miễn phí trong vòng 7 ngày đầu.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row text-center justify-content-center bg-light rounded-4 py-5 mx-1">
        <div class="col-12 mb-5">
            <h2 class="fw-bold">Đội ngũ phát triển</h2>
            <p class="text-muted">Nhóm sinh viên thực hiện dự án Lập trình Web</p>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 bg-transparent team-card">
                <div class="card-body">
                    <img src="https://ui-avatars.com/api/?name=Truong+Thanh+Nhan&background=0D8ABC&color=fff&size=128&bold=true" 
                         class="rounded-circle mb-3 team-avatar" width="120" height="120">
                    <h5 class="fw-bold mb-1">Trương Thanh Nhân</h5>
                    <span class="badge bg-primary mb-2">Trưởng nhóm</span>
                    <p class="text-muted small">MSSV: 2312453</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 bg-transparent team-card">
                <div class="card-body">
                    <img src="https://ui-avatars.com/api/?name=Tran+Anh+Khoi&background=27AE60&color=fff&size=128&bold=true" 
                         class="rounded-circle mb-3 team-avatar" width="120" height="120">
                    <h5 class="fw-bold mb-1">Trần Anh Khôi</h5>
                    <span class="badge bg-secondary mb-2">Thành viên</span>
                    <p class="text-muted small">MSSV: 2211695</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 bg-transparent team-card">
                <div class="card-body">
                    <img src="https://ui-avatars.com/api/?name=Nguyen+Xuan+Thinh&background=F39C12&color=fff&size=128&bold=true" 
                         class="rounded-circle mb-3 team-avatar" width="120" height="120">
                    <h5 class="fw-bold mb-1">Nguyễn Xuân Thịnh</h5>
                    <span class="badge bg-secondary mb-2">Thành viên</span>
                    <p class="text-muted small">MSSV: 2313303</p>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
