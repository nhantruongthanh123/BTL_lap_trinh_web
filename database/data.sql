-- Sample Data for Book Selling Website
-- Password for all test accounts: 123456

USE bookstore_db;

-- 1. Thêm Users (Admin + Khách hàng test)
INSERT INTO users (username, email, password_hash, full_name, phone, role, address) VALUES
('admin', 'admin@bookstore.com', '$2y$10$rl2sRlKeCNuvmVOW8yrxFeoTgxV4/kcBtuQAz813C0oxHtEiMdJES', 'Quản Trị Viên', '0909000000', 'admin', 'Văn phòng Nhà sách'),
('khachhang1', 'khach1@gmail.com', '$2y$10$qL.0KuJW5titkgaUDySBzOZt5lVQKph3FS0HS/Trw47GuPuC/k7/W', 'Nguyễn Văn Mua', '0912345678', 'customer', '123 Đường Láng, Hà Nội'),
('khachhang2', 'khach2@gmail.com', '$2y$10$wSbdhckqQo4.e0Q.h/r.EOe7.v7q.v7q.v7q.v7q.v7q.v7q', 'Trần Thị Bán', '0987654321', 'customer', '456 Lê Lợi, TP.HCM');

-- 2. Thêm Categories (Thể loại)
INSERT INTO categories (category_name, slug, description) VALUES
('Văn học trong nước', 'van-hoc-trong-nuoc', 'Các tác phẩm văn học của tác giả Việt Nam'),
('Văn học nước ngoài', 'van-hoc-nuoc-ngoai', 'Tiểu thuyết, truyện ngắn dịch từ nước ngoài'),
('Kinh tế - Kỹ năng', 'kinh-te-ky-nang', 'Sách dạy làm giàu, phát triển bản thân'),
('Sách Thiếu nhi', 'sach-thieu-nhi', 'Truyện tranh, truyện cổ tích cho bé'),
('Công nghệ thông tin', 'cntt', 'Sách lập trình, thuật toán');

-- 3. Thêm Authors (Tác giả)
INSERT INTO authors (author_name, biography, nationality) VALUES
('Nguyễn Nhật Ánh', 'Nhà văn chuyên viết cho thanh thiếu niên.', 'Vietnam'),
('Rosie Nguyễn', 'Tác giả sách kỹ năng sống nổi tiếng.', 'Vietnam'),
('J.K. Rowling', 'Tác giả bộ truyện Harry Potter.', 'United Kingdom'),
('Paulo Coelho', 'Tác giả Nhà Giả Kim.', 'Brazil'),
('Robert T. Kiyosaki', 'Tác giả bộ Dạy Con Làm Giàu.', 'USA');

-- 4. Thêm Publishers (Nhà xuất bản)
INSERT INTO publishers (publisher_name, address, email) VALUES
('NXB Trẻ', '161B Lý Chính Thắng, TP.HCM', 'info@nxbtre.com.vn'),
('NXB Kim Đồng', '55 Quang Trung, Hà Nội', 'info@nxbkimdong.com.vn'),
('NXB Hội Nhà Văn', '65 Nguyễn Du, Hà Nội', 'hnv@gmail.com'),
('NXB Tổng Hợp TP.HCM', '148 Nguyễn Thị Minh Khai, TP.HCM', 'info@nxbtphcm.com.vn');


-- 5. Thêm Books (Sách)
-- Lưu ý: author_id, category_id, publisher_id phải khớp với ID ở trên (tự tăng bắt đầu từ 1)
INSERT INTO books (title, isbn, author_id, publisher_id, category_id, description, price, discount_price, stock_quantity, cover_image, is_featured, pages) VALUES
-- Sách 1: Nguyễn Nhật Ánh (ID 1) - NXB Trẻ (ID 1) - Văn học VN (ID 1)
('Mắt Biếc', 'VN-001', 1, 1, 1, 'Một câu chuyện tình yêu buồn và đẹp nhất của Nguyễn Nhật Ánh.', 110000, 99000, 50, 'mat-biec.jpg', 1, 300),

-- Sách 2: Nguyễn Nhật Ánh - Kính Vạn Hoa
('Kính Vạn Hoa - Tập 1', 'VN-002', 1, 2, 4, 'Những câu chuyện học trò tinh nghịch của Quý ròm, nhỏ Hạnh và Tiểu Long.', 85000, 85000, 100, 'kinh-van-hoa-tap-1.jpg', 0, 200),

-- Sách 3: Rosie Nguyễn (ID 2) - Kỹ năng (ID 3)
('Tuổi trẻ đáng giá bao nhiêu?', 'VN-003', 2, 3, 3, 'Cuốn sách best-seller khuyên các bạn trẻ hãy sống hết mình.', 80000, 60000, 200, 'tuoi-tre-dang-gia-bao-nhieu.jpg', 1, 250),

-- Sách 4: J.K. Rowling (ID 3) - Văn học nước ngoài (ID 2)
('Harry Potter và Hòn đá Phù thủy', 'UK-001', 3, 1, 2, 'Tập đầu tiên trong series Harry Potter nổi tiếng toàn cầu.', 150000, 120000, 30, 'harry-potter-1.jpg', 1, 400),

-- Sách 5: Paulo Coelho (ID 4) - Văn học nước ngoài (ID 2)
('Nhà Giả Kim', 'BR-001', 4, 3, 2, 'Cuốn sách bán chạy chỉ sau Kinh Thánh.', 79000, 79000, 150, 'nha-gia-kim.jpg', 1, 220),

-- Sách 6: Robert Kiyosaki (ID 5) - Kinh tế (ID 3)
('Dạy Con Làm Giàu - Tập 1', 'US-001', 5, 1, 3, 'Để không có tiền vẫn tạo ra tiền.', 65000, 50000, 80, 'day-con-lam-giau.jpg', 0, 180);


-- 6. Thêm Reviews (Đánh giá mẫu)
-- user_id: 1=admin, 2=khachhang1, 3=khachhang2
INSERT INTO reviews (book_id, user_id, rating, comment, is_approved) VALUES
(1, 2, 5, 'Sách rất hay, đọc mà khóc luôn. Đáng đọc!', 1),
(3, 3, 4, 'Sách bổ ích cho sinh viên, nên đọc khi còn trẻ.', 1),
(4, 2, 5, 'Harry Potter là đỉnh nhất! Con tôi rất thích.', 1),
(5, 3, 5, 'Nhà Giả Kim thay đổi cách nhìn cuộc sống của tôi.', 1);


INSERT INTO orders (user_id, total_amount, shipping_fee, discount_amount, final_amount, status, payment_status, order_number, shipping_address, coupon_code) VALUES
(2, 145000, 15000, 15000, 145000, 'delivered', 'paid', 'ORD-2025-001', '123 Đường Láng, Hà Nội', 'FREESHIP2025');

INSERT INTO order_items (order_id, book_id, quantity, price, subtotal) VALUES
(1, 2, 1, 85000, 85000),
(1, 3, 1, 60000, 60000);


INSERT INTO coupons (code, discount_type, min_order_value, discount_value, expiration_date, is_active) VALUES
('FREESHIP2025', 'free_shipping', 100000, 15000, '2025-12-31', 1),
('SAVE20', 'fixed_amount', 200000, 20000, '2025-12-31', 1);
