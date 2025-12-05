<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ - Bookstore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* CSS riêng cho trang Liên hệ */
        .contact-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 60px 0;
            margin-bottom: 50px;
        }

        /* Card chứa thông tin bên trái */
        .contact-info-box {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            display: flex;
            align-items: center;
            border: 1px solid rgba(0,0,0,0.05);
        }
        .contact-info-box:hover {
            transform: translateY(-5px);
            border-color: #0d6efd;
        }
        .contact-icon {
            width: 50px;
            height: 50px;
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-right: 20px;
            flex-shrink: 0;
        }

        /* Form bên phải */
        .contact-form-card {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .form-control {
            background-color: #f8f9fa;
            border: 1px solid #eee;
            padding: 12px 15px;
            border-radius: 10px;
        }
        .form-control:focus {
            background-color: #fff;
            box-shadow: none;
            border-color: #0d6efd;
        }
        
        /* Bản đồ */
        .map-container {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 100%;
            min-height: 300px;
        }
    </style>
</head>
<body>

<div class="contact-header text-center rounded-bottom-4">
    <div class="container">
        <h1 class="fw-bold display-5">Liên hệ với <span class="text-primary">Bookstore</span></h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            Chúng tôi luôn sẵn sàng lắng nghe ý kiến đóng góp của bạn. Hãy để lại lời nhắn, đội ngũ hỗ trợ sẽ phản hồi trong vòng 24h.
        </p>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-5">
        
        <div class="col-lg-5">
            <h3 class="fw-bold mb-4">Thông tin liên lạc</h3>
            
            <div class="contact-info-box">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Địa chỉ</h6>
                    <p class="text-muted mb-0 small">Đại học Bách Khoa TP.HCM, Dĩ An, Bình Dương</p>
                </div>
            </div>

            <div class="contact-info-box">
                <div class="contact-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Hotline</h6>
                    <p class="text-muted mb-0 small">0123.456.789 (8:00 - 22:00)</p>
                </div>
            </div>

            <div class="contact-info-box">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Email</h6>
                    <p class="text-muted mb-0 small">support@bookstore.com</p>
                </div>
            </div>

            <div class="map-container mt-4">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.092636259068!2d106.8053770748065!3d10.87997238927515!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d8a5568c997f%3A0xdeac05f17a166e06!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBCw6FjaCBraG9hIC0gxJBIUUcgVFAuSGNtIChjxqEgc-G7nyAyKQ!5e0!3m2!1svi!2s!4v1701837000000!5m2!1svi!2s" 
                        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="contact-form-card h-100">
                <h3 class="fw-bold mb-4">Gửi tin nhắn cho chúng tôi</h3>
                <form action="#" method="POST"> <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Họ và tên</label>
                            <input type="text" class="form-control" placeholder="Nhập tên của bạn">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Email</label>
                            <input type="email" class="form-control" placeholder="example@email.com">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Chủ đề</label>
                            <input type="text" class="form-control" placeholder="Bạn cần hỗ trợ vấn đề gì?">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Nội dung tin nhắn</label>
                            <textarea class="form-control" rows="6" placeholder="Viết nội dung tại đây..."></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm">
                                <i class="fas fa-paper-plane me-2"></i> Gửi Ngay
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

</body>
</html>