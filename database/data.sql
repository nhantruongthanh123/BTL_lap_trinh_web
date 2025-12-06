-- Sample Data for Book Selling Website
-- Password for all test accounts: 123456

USE bookstore_db;

-- 1. Thêm Users (Admin + Khách hàng test)
INSERT INTO users (username, email, password_hash, full_name, gender, birthday, phone, role, address, created_at) VALUES
-- Password admin: 123123
('admin1', 'admin1@bookstore.com', '$2y$10$rl2sRlKeCNuvmVOW8yrxFeoTgxV4/kcBtuQAz813C0oxHtEiMdJES', 'Quản Trị Viên', 'male', '1990-06-11', '0909000000', 'admin', 'Văn phòng Nhà sách Sài Gòn', '2025-11-05 7:50:00'),
('admin2', 'admin2@bookstore.com', '$2y$10$W6WYL155rub9Ll076Wo6m.ZnycM8.c9jj4w328tktF2Tk2OaObjyS', 'Quản Trị Viên', 'female', '1995-01-01', '0909000001', 'admin', 'Văn phòng Nhà sách Hà Nội', '2025-11-05 7:36:45'),
-- Password khách hàng: 123456
('khachhang1', 'khach1@gmail.com', '$2y$10$atuhVjsIvUmF9HIDiXImduRgcda4NnNoJIKcwsXr.yzOB7eFfjAOa', 'Nguyễn Văn Mua', 'male', '1995-05-15', '0912345678', 'customer', '123 Đường Láng, Hà Nội', '2025-11-06 07:00:02'),
('khachhang2', 'khach2@gmail.com', '$2y$10$ZmFljbiHMMd0J88OYV9kaesvEOyNTsl.nAxVSKiuuIj.T04CDq5zu', 'Trần Thị Bán', 'female', '1992-08-20', '0987654321', 'customer', '456 Lê Lợi, TP.HCM', '2025-11-07 11:23:56'),
('khachhang3', 'khach3@gmail.com', '$2y$10$Q1jF7zPjW5Vn8tr2J9x0de8ZqUK7brB7L9ghJFXuC2E8WnZpTfYDu', 'Lê Minh Tân', 'male', '1990-03-12', '0901122334', 'customer', '12 Hai Bà Trưng, Hà Nội', '2025-11-08 09:12:45'),
('khachhang4', 'khach4@gmail.com', '$2y$10$QnT8P2VtL1Gkz5cMuJw4ue7Ft4JGAgs2pY0dJ5R8w2mOMQEzFvY2m', 'Phạm Thảo Vy', 'female', '1998-11-25', '0938123456', 'customer', '88 Nguyễn Huệ, Đà Nẵng', '2025-11-08 14:33:21'),
('khachhang5', 'khach5@gmail.com', '$2y$10$uC3TyhG2zN0OjYtX1vDkRe3qS9WbqA98oS7ucRJQeC9/GZq2Yp0v.', 'Nguyễn Quốc Hùng', 'male', '1989-01-20', '0919223344', 'customer', '23 Trần Phú, Hải Phòng', '2025-11-09 10:45:03'),
('khachhang6', 'khach6@gmail.com', '$2y$10$kG8tX0pBzMDuIY9UL7rHmuxj8Yx5pTwnb9Otu9nfgmWBxEsgz8s5G', 'Lâm Thu Hà', 'female', '1997-04-18', '0971556677', 'customer', '55 Lạch Tray, Hải Phòng', '2025-11-10 16:12:27'),
('khachhang7', 'khach7@gmail.com', '$2y$10$gF4iUe3PzJTcDk1Nx6H0TezFvV7f4GtV1Rz1W09sBZL8RJmYBf2gW', 'Trần Bảo Long', 'male', '1994-07-09', '0922345567', 'customer', '101 Võ Thị Sáu, TP.HCM', '2025-11-11 11:59:41'),
('khachhang8', 'khach8@gmail.com', '$2y$10$wH6Ne3LqPj8GJ1xFt2CdP.m6XqV0YtMzAuKT.MuJeiC6uW0m.zcxy', 'Võ Thị Kim Anh', 'female', '1999-10-12', '0934778899', 'customer', '78 Bạch Đằng, Đà Nẵng', '2025-11-12 08:32:10'),
('khachhang9', 'khach9@gmail.com', '$2y$10$eR1NmKp7TtO8qS2RQ9b01uBg0eP6lFw7rOBe2zWZ8t02L4S0uqjXW', 'Phùng Đức Hải', 'male', '1988-02-22', '0908776655', 'customer', '66 Nguyễn Trãi, Hà Nội', '2025-11-12 19:20:54'),
('khachhang10', 'khach10@gmail.com', '$2y$10$S1EoG3cJH0mRrU9eZJz34Oap7pDgV4hEJ5btKe4fO3.A3ryq3kLSq', 'Đỗ Ngọc Hân', 'female', '1996-06-01', '0975551122', 'customer', '09 Lý Tự Trọng, Cần Thơ', '2025-11-13 07:14:03'),
('khachhang11', 'khach11@gmail.com', '$2y$10$Pq1Oe5MkHf9uZdY3W3Dqcu7nAfZ2cQ0bXM4sVJtWmQ0eEe/ZVPhXi', 'Hoàng Anh Tuấn', 'male', '1993-12-14', '0913112244', 'customer', '44 Lê Duẩn, Hà Nội', '2025-11-14 12:55:19'),
('khachhang12', 'khach12@gmail.com', '$2y$10$Kp2Fe1TcRz5oN8BNkq6Jg.y1QfYgkN4sN8fV7OyA6c5s7dqkRm6Y.', 'Nguyễn Phương Linh', 'female', '1991-09-01', '0948667788', 'customer', '102 Lê Lợi, Huế', '2025-11-15 09:22:45'),
('khachhang13', 'khach13@gmail.com', '$2y$10$dN0Oe3GmJt4R5g8WZ1hC0u.4pEwCw0sH4TgQkIdOa3hR8S5mQ7e1m', 'Trịnh Nhật Huy', 'male', '1987-05-28', '0935446677', 'customer', '200 Bình Long, TP.HCM', '2025-11-16 18:11:33'),
('khachhang14', 'khach14@gmail.com', '$2y$10$Zc9Ln2KpRr5IuX7sDmGQxO6Qd2dN1uEy9QmD2nB2kOmQO2fQOc5rW', 'Vũ Thị Bích', 'female', '1995-03-03', '0902334456', 'customer', '77 CMT8, TP.HCM', '2025-11-17 15:33:12'),
('khachhang15', 'khach15@gmail.com', '$2y$10$Tf4Jn9NkAq2Fs8LdV5tC2u1XgJdE8sQk0GvOeZzGdX1oT7VfYjJ3W', 'Phan Minh Nhật', 'male', '1990-08-17', '0968223344', 'customer', '35 Trường Chinh, Đà Nẵng', '2025-11-18 10:05:55'),
('khachhang16', 'khach16@gmail.com', '$2y$10$Ro1Fv8TnEp9Zq3LuD3xP7uAqGDaN5wG0uT1sBlcFvHfM2rQZP8FQ2', 'Đinh Thị Yến Nhi', 'female', '1998-12-09', '0945998877', 'customer', '12 Nguyễn Kiệm, TP.HCM', '2025-11-19 21:48:02'),
('khachhang17', 'khach17@gmail.com', '$2y$10$aE4Zk0BcFt2Jn5SpQw8UCe5N8WgPpE2oA9qLrSsMnFyG3BuNfT7sG', 'Trần Gia Khánh', 'male', '1992-11-11', '0907445566', 'customer', '81 Điện Biên Phủ, Hà Nội', '2025-11-20 13:29:41'),
('khachhang18', 'khach18@gmail.com', '$2y$10$Mq8Co2HxQf7Nd8OeXz9vGd1HpT1pE9wUq4GwYdGkRrJ0tFyPqM3Cu', 'Hà Thúy An', 'female', '1999-07-23', '0974001122', 'customer', '50 Nguyễn Du, Hà Nội', '2025-11-21 08:17:30');

-- 2. Thêm Categories (Thể loại)
INSERT INTO categories (category_name, slug, description, created_at) VALUES
('Văn học trong nước', 'van-hoc-trong-nuoc', 'Các tác phẩm văn học của tác giả Việt Nam', '2025-11-06 10:00:00'),
('Văn học nước ngoài', 'van-hoc-nuoc-ngoai', 'Tiểu thuyết, truyện ngắn dịch từ nước ngoài', '2025-11-06 10:00:05'),
('Kinh tế - Kỹ năng', 'kinh-te-ky-nang', 'Sách dạy làm giàu, phát triển bản thân', '2025-11-06 10:02:16'),
('Sách Thiếu nhi', 'sach-thieu-nhi', 'Truyện tranh, truyện cổ tích cho bé', '2025-11-06 10:05:00'),
('Truyên tranh', 'truyen-tranh', 'Sách truyện tranh đa thể loại', '2025-11-06 10:07:30'),
('Công nghệ thông tin', 'cntt', 'Sách lập trình, thuật toán', '2025-11-06 10:10:00'),
('Giáo trình - Tham khảo', 'giao-trinh-tham-khao', 'Sách giáo khoa, tài liệu tham khảo', '2025-11-06 10:12:45'),
('Trinh thám', 'trinh-tham', 'Sách trinh thám, phá án', '2025-11-06 10:15:20');



-- 3. Thêm Authors (Tác giả)
INSERT INTO authors (author_name, biography, nationality) VALUES
('Nguyễn Nhật Ánh', 'Nhà văn chuyên viết cho thanh thiếu niên.', 'Vietnam'),
('Ngô Tất Tố', 'Nhà văn nổi tiếng với tác phẩm "Tắt Đèn".', 'Vietnam'),
('Vũ Trọng Phụng', 'Nhà văn hiện thực phê phán nổi tiếng.', 'Vietnam'),
('Tô Hoài', 'Tác giả của nhiều tác phẩm văn học thiếu nhi.', 'Vietnam'),
('Nam Cao', 'Tác giả của nhiều truyện ngắn nổi tiếng.', 'Vietnam'),

('Paulo Coelho', 'Tác giả Nhà Giả Kim.', 'Brazil'),
('J.K. Rowling', 'Tác giả bộ truyện Harry Potter.', 'United Kingdom'),

('Rosie Nguyễn', 'Tác giả sách kỹ năng sống nổi tiếng.', 'Vietnam'),
('Robert T. Kiyosaki', 'Tác giả bộ Dạy Con Làm Giàu.', 'USA'),

('Nguyễn Ngọc Thuần', 'Nhà văn chuyên viết truyện thiếu nhi nổi tiếng.', 'Vietnam'),
('Antoine de Saint-Exupéry', 'Tác giả của tác phẩm kinh điển Hoàng Tử Bé.', 'France'),

('Eiichiro Oda', 'Tác giả bộ truyện tranh One Piece.', 'Japan'),
('Masashi Kishimoto', 'Tác giả bộ truyện tranh Naruto.', 'Japan'),
('Akira Toriyama', 'Tác giả bộ truyện tranh Dragon Ball.', 'Japan'),

('Andrew Hutchinson', 'Tác giả sách lập trình Python.', 'USA'),
('Robert Lafore', 'Tác giả sách về thuật toán và cấu trúc dữ liệu.', 'USA'),

('Nguyễn Văn Nhân', 'Tác giả giáo trình đại học nổi tiếng.', 'Vietnam'),

('Conan Doyle', 'Tác giả bộ truyện trinh thám Sherlock Holmes.', 'United Kingdom'),
('Thomas Harris', 'Tác giả của loạt tiểu thuyết trinh thám nổi tiếng.', 'USA'),
('Agatha Christie', 'Nữ hoàng trinh thám với nhiều tác phẩm kinh điển.', 'United Kingdom');


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
('Tắt đèn', 'VN-004', 2, 3, 1, 'Tác phẩm phản ánh cuộc sống nông thôn Việt Nam dưới ách đô hộ của thực dân Pháp.', 70000, 70000, 75, 'tat-den.jpg', 0, 180),
('Số Đỏ', 'VN-005', 3, 3, 1, 'Tiểu thuyết châm biếm xã hội Việt Nam thời Pháp thuộc.', 90000, 85000, 60, 'so-do.jpg', 0, 250),
('Vợ chồng A Phủ', 'VN-008', 4, 3, 1, 'Câu chuyện về cuộc sống và tình yêu của người dân tộc thiểu số vùng Tây Bắc.', 75000, 75000, 80, 'vo-chong-a-phu.jpg', 0, 210),
('Chí Phèo', 'VN-007', 5, 3, 1, 'Truyện ngắn nổi tiếng về cuộc đời bi kịch của Chí Phèo.', 75000, 70000, 90, 'chi-pheo.jpg', 0, 200),

-- Văn học nước ngoài (ID 2)
('Nhà Giả Kim', 'BR-001', 6, 3, 2, 'Cuốn sách bán chạy chỉ sau Kinh Thánh.', 79000, 79000, 150, 'nha-gia-kim.jpg', 0, 220),
('Harry Potter và Hòn đá Phù thủy', 'UK-001', 7, 1, 2, 'Tập đầu tiên trong series Harry Potter nổi tiếng toàn cầu.', 150000, 130000, 30, 'harry-potter-1.jpg', 1, 400),
('Harry Potter và Phòng chứa Bí mật', 'UK-002', 7, 1, 2, 'Tập thứ hai trong series Harry Potter.', 150000, 150000, 25, 'harry-potter-2.jpg', 0, 420),
('Harry Potter và Tù nhân Ngục Azkaban', 'UK-003', 7, 1, 2, 'Tập thứ ba trong series Harry Potter.', 160000, 160000, 20, 'harry-potter-3.jpg', 0, 450),
('Harry Potter và Chiếc cốc lửa', 'UK-004', 7, 1, 2, 'Tập thứ tư trong series Harry Potter.', 150000, 150000, 15, 'harry-potter-4.jpg', 0, 500),
('Harry Potter và Hội Phượng hoàng', 'UK-005', 7, 1, 2, 'Tập thứ năm trong series Harry Potter.', 180000, 180000, 10, 'harry-potter-5.jpg', 0, 600),
('Harry Potter và Hoàng tử lai', 'UK-006', 7, 1, 2, 'Tập thứ sáu trong series Harry Potter.', 190000, 190000, 8, 'harry-potter-6.jpg', 0, 650),
('Harry Potter và Bảo bối Tử thần', 'UK-007', 7, 1, 2, 'Tập cuối cùng trong series Harry Potter.', 200000, 180000, 5, 'harry-potter-7.jpg', 0, 700),


-- Kinh tế - Kỹ năng (ID 3)
('Đắc Nhân Tâm', 'VN-003', 8, 4, 3, 'Cuốn sách giúp bạn cải thiện kỹ năng giao tiếp và xây dựng mối quan hệ.', 90000, 85000, 70, 'dac-nhan-tam.jpg', 1, 220),
('Dạy Con Làm Giàu', 'US-001', 9, 4, 3, 'Cuốn sách kinh điển về tài chính cá nhân và đầu tư.', 120000, 100000, 40, 'day-con-lam-giau.jpg', 0, 250),


-- Sách Thiếu nhi (ID 4)
('Dế mèn phiêu lưu ký', 'VN-006', 4, 2, 4, 'Cuộc phiêu lưu của chú dế mèn dũng cảm và thông minh.', 60000, 55000, 120, 'de-men-phieu-luu-ky.jpg', 0, 220),
('Kính Vạn Hoa - Tập 1', 'VN-002', 1, 2, 4, 'Những câu chuyện học trò tinh nghịch của Quý ròm, nhỏ Hạnh và Tiểu Long.', 85000, 80000, 100, 'kinh-van-hoa-tap-1.jpg', 0, 200),
('Kính Vạn Hoa - Tập 2', 'VN-009', 1, 2, 4, 'Tiếp tục những cuộc phiêu lưu của nhóm bạn trong Kính Vạn Hoa.', 85000, 85000, 90, 'kinh-van-hoa-tap-2.jpg', 0, 210),
('Kính Vạn Hoa - Tập 3', 'VN-010', 1, 2, 4, 'Những câu chuyện hài hước và ý nghĩa trong Kính Vạn Hoa.', 85000, 85000, 80, 'kinh-van-hoa-tap-3.jpg', 0, 220),
('Kính Vạn Hoa - Tập 4', 'VN-011', 1, 2, 4, 'Những chuyến phiêu lưu mới của nhóm bạn trong Kính Vạn Hoa.', 85000, 85000, 70, 'kinh-van-hoa-tap-4.jpg', 0, 230),
('Kính Vạn Hoa - Tập 5', 'VN-012', 1, 2, 4, 'Tiếp tục những câu chuyện thú vị trong Kính Vạn Hoa.', 85000, 85000, 60, 'kinh-van-hoa-tap-5.jpg', 0, 240),
('Kinh Vạn Hoa - Tập 6', 'VN-013', 1, 2, 4, 'Những cuộc phiêu lưu kỳ thú của nhóm bạn trong Kính Vạn Hoa.', 85000, 85000, 50, 'kinh-van-hoa-tap-6.jpg', 0, 250),
('Cho tôi một vé đi tuổi thơ', 'VN-014', 1, 2, 4, 'Tập hợp những câu chuyện ngắn về tuổi thơ đầy kỷ niệm.', 70000, 70000, 110, 'cho-toi-mot-ve-di-tuoi-tho.jpg', 0, 180),
('Vừa Nhắm Mắt Vừa Mở Cửa Sổ', 'VN-015', 10, 1, 4, 'Một câu chuyện nhẹ nhàng, trong trẻo dành cho thiếu nhi.', 80000, 80000, 90, 'vua-nham-mat-vua-mo-cua-so.jpg', 0, 200),
('Hoàng Tử Bé', 'FR-001', 11, 2, 4, 'Tác phẩm kinh điển về tình bạn và cuộc sống.', 95000, 90000, 130, 'hoang-tu-be.jpg', 0, 150),


-- Truyện tranh (ID 5)
('One Piece - Tập 1', 'JP-001', 12, 2, 5, 'Bắt đầu cuộc hành trình của Luffy và băng hải tặc Mũ Rơm.', 20000, 20000, 40, 'one-piece-tap-1.jpg', 1, 200),
('Naruto - Tập 1', 'JP-002', 13, 2, 5, 'Câu chuyện về cậu bé ninja Naruto Uzumaki.', 22000, 22000, 35, 'naruto-tap-1.jpg', 0, 220),
('Dragon Ball - Tập 1', 'JP-003', 14, 2, 5, 'Cuộc phiêu lưu của Goku từ nhỏ đến lớn.', 20000, 20000, 30, 'dragon-ball-tap-1.jpg', 0, 210),

-- Công nghệ thông tin (ID 6)
('Lập trình Python căn bản', 'IT-001', 15, 4, 6, 'Sách hướng dẫn lập trình Python từ cơ bản đến nâng cao.', 120000, 110000, 45, 'lap-trinh-python-can-ban.jpg', 1, 350),
('Thuật toán và cấu trúc dữ liệu', 'IT-002', 16, 4, 6, 'Tài liệu tham khảo về thuật toán và cấu trúc dữ liệu trong lập trình.', 130000, 130000, 50, 'thuat-toan-cau-truc-du-lieu.jpg', 0, 400),
('Lập trình web với JavaScript', 'IT-003', 15, 4, 6, 'Hướng dẫn xây dựng website động sử dụng JavaScript.', 125000, 125000, 40, 'lap-trinh-web-javascript.jpg', 0, 300),
('An toàn thông tin cơ bản', 'IT-004', 16, 4, 6, 'Những kiến thức cơ bản về an toàn thông tin và bảo mật mạng.', 140000, 130000, 35, 'an-toan-thong-tin-co-ban.jpg', 0, 320),

-- Giáo trình - Tham khảo (ID 7)
('Giáo trình Toán cao cấp', 'GT-001', 17, 4, 7, 'Giáo trình toán cao cấp dành cho sinh viên đại học.', 200000, 180000, 60, 'giao-trinh-toan-cao-cap.jpg', 0, 600),
('Giáo trình Vật lý đại cương', 'GT-002', 17, 4, 7, 'Giáo trình vật lý đại cương dành cho sinh viên đại học.', 180000, 170000, 70, 'giao-trinh-vat-ly-dai-cuong.jpg', 0, 550),
('Giáo trình Hóa học đại cương', 'GT-003', 17, 4, 7, 'Giáo trình hóa học đại cương dành cho sinh viên đại học.', 190000, 180000, 65, 'giao-trinh-hoa-hoc-dai-cuong.jpg', 0, 580),

-- Trinh thám (ID 8)
('Sherlock Holmes - Tập 1', 'DT-002', 18, 3, 8, 'Những vụ án ly kỳ của thám tử Sherlock Holmes.', 120000, 110000, 40, 'sherlock-holmes-tap-1.jpg', 1, 300),
('Sherlock Holmes - Tập 2', 'DT-003', 18, 3, 8, 'Tiếp tục những vụ án hấp dẫn của Sherlock Holmes.', 120000, 120000, 35, 'sherlock-holmes-tap-2.jpg', 0, 320),
('Sherlock Holmes - Tập 3', 'DT-004', 18, 3, 8, 'Phần kết câu chuyện trinh thám kinh điển của Sherlock Holmes.', 130000, 130000, 30, 'sherlock-holmes-tap-3.jpg', 0, 350),
('Hannibal Lecter - Sự im lặng của bầy cừu', 'DT-001', 19, 3, 8, 'Tiểu thuyết trinh thám kinh dị về bác sĩ Hannibal Lecter.', 200000, 190000, 25, 'hannibal-lecter.jpg', 0, 400),
('Án mạng trên chuyến tàu tốc hành Phương Đông', 'DT-005', 20, 3, 8, 'Tiểu thuyết trinh thám kinh điển của Agatha Christie.', 150000, 140000, 20, 'an-mang-tren-chuyen-tau-phuong-dong.jpg', 0, 350),
('Án mạng ở nhà mục vụ', 'DT-006', 20, 3, 8, 'Một trong những tác phẩm trinh thám nổi tiếng của Agatha Christie.', 140000, 130000, 15, 'an-mang-o-nha-muc-vu.jpg', 0, 300),
('Cái chết trên sông Nile', 'DT-007', 20, 3, 8, 'Tiểu thuyết trinh thám hấp dẫn của Agatha Christie.', 130000, 120000, 10, 'cai-chet-tren-song-nile.jpg', 0, 280),
('Mười Người Da Đen Nhỏ', 'DT-008', 20, 3, 8, 'Một trong những tác phẩm trinh thám kinh điển của Agatha Christie.', 120000, 110000, 12, 'muoi-nguoi-da-den-nho.jpg', 0, 260),
('Bí Ẩn Ba Phần Tư', 'DT-009', 20, 3, 8, 'Câu chuyện trinh thám ly kỳ của Agatha Christie.', 110000, 110000, 8, 'bi-an-ba-phan-tu.jpg', 0, 240);


-- 6. Thêm Reviews (Đánh giá mẫu)
-- user_id: 1=admin, 2=khachhang1, 3=khachhang2
INSERT INTO reviews (book_id, user_id, rating, comment, is_approved) VALUES
(1, 5, 5, 'Đọc xong thấy nghèn nghẹn, câu chuyện giản dị mà thấm.', 1),
(2, 7, 4, 'Tác phẩm kinh điển, nhưng vài đoạn hơi dài.', 1),
(3, 9, 5, 'Vừa hài hước vừa sâu cay, đọc mà phải suy ngẫm.', 1),
(4, 12, 4, 'Giọng văn ấm và buồn nhẹ, hợp đọc buổi tối.', 1),
(5, 14, 5, 'Một truyện ngắn xuất sắc, dễ hiểu mà cảm động.', 1),

-- Văn học nước ngoài
(6, 6, 5, 'Cuốn sách khiến mình muốn thay đổi cách sống.', 1),
(7, 15, 5, 'Cả tuổi thơ gói lại trong cuốn này, tuyệt vời.', 1),
(8, 18, 4, 'Nội dung ổn, hơi chậm đoạn đầu nhưng càng về sau càng cuốn.', 1),
(9, 11, 5, 'Tập này tone tối hơn nhưng siêu hay.', 1),
(10, 20, 5, 'Đọc một lèo hết luôn, nhiều khoảnh khắc nổi da gà.', 1),
(11, 4, 4, 'Khá nặng nhưng nội dung chất lượng.', 1),
(12, 16, 5, 'Tác giả viết quá đỉnh, cảm xúc dạt dào.', 1),
(13, 10, 5, 'Cái kết làm mình nổi da gà. Xuất sắc.', 1),

-- Kinh tế - kỹ năng
(14, 3, 4, 'Nhiều bài học áp dụng được ngay, dễ đọc.', 1),
(15, 17, 5, 'Sách tài chính hay nhất mình từng đọc.', 1),

-- Thiếu nhi
(16, 8, 5, 'Tuổi thơ quay trở lại, nhẹ nhàng và đẹp.', 1),
(17, 13, 5, 'Một tác phẩm kinh điển, đọc lại vẫn hay như xưa.', 1),
(18, 6, 4, 'Dễ thương và ý nghĩa, hợp cho mọi lứa tuổi.', 1),
(19, 19, 5, 'Vui, đọc để giải trí cực hợp.', 1),
(20, 12, 5, 'Nhiều tình tiết sáng tạo, đọc không chán.', 1),
(21, 3, 4, 'Giữ được chất của Kính Vạn Hoa, rất ổn.', 1),
(22, 7, 4, 'Lời kể hồn nhiên, đọc thấy thích.', 1),
(23, 15, 5, 'Câu chuyện vượt thời gian, sâu sắc.', 1),
(24, 10, 4, 'Nhẹ nhàng và dễ thương.', 1),
(25, 18, 5, 'Một tác phẩm triết lý nhưng không hề khó hiểu.', 1),

-- Truyện tranh
(26, 14, 5, 'One Piece tập đầu quá huyền thoại.', 1),
(27, 20, 4, 'Naruto mở đầu cảm động và cuốn hút.', 1),
(28, 11, 5, 'Dragon Ball mãi đỉnh, đọc bao lần vẫn ghiền.', 1),

-- Công nghệ thông tin
(29, 8, 5, 'Viết dễ hiểu, phù hợp người mới.', 1),
(30, 4, 5, 'Giải thích kỹ, ví dụ rõ ràng.', 1),
(31, 17, 4, 'Khá đầy đủ nhưng phần nâng cao hơi ít.', 1),
(32, 5, 5, 'Một trong những cuốn cơ bản về bảo mật tốt nhất.', 1),

-- Giáo trình
(33, 6, 4, 'Chi tiết nhưng hơi khó đọc nếu tự học.', 1),
(34, 9, 4, 'Phần vật lý hiện đại viết rất logic.', 1),
(35, 13, 4, 'Lý thuyết chắc chắn, đúng chuẩn giáo trình.', 1),

-- Trinh thám
(36, 19, 5, 'Sherlock Holmes luôn đáng đọc.', 1),
(37, 16, 5, 'Các vụ án được sắp xếp cực thông minh.', 1),
(38, 3, 4, 'Hay nhưng hơi ngắn.', 1),
(39, 12, 4, 'Cốt truyện lôi cuốn, nhiều twist hay.', 1),
(40, 11, 5, 'Agatha Christie viết quá đỉnh!', 1),
(41, 18, 4, 'Khá bất ngờ ở đoạn cuối.', 1),
(42, 7, 4, 'Một khởi đầu tốt cho series về Poirot.', 1),
(43, 15, 4, 'Gay cấn từ đầu đến cuối.', 1),
(44, 20, 4, 'Tốc độ nhanh, đọc rất sướng.', 1),


-- 1. Mắt Biếc
(1, 3, 5, 'Một câu chuyện đẹp nhưng buồn, đọc xong thấy day dứt mãi.', 1),
(1, 12, 4, 'Giọng văn nhẹ nhàng, hơi chậm nhưng cảm xúc thật.', 1),
(1, 17, 5, 'Sách hay hơn bản phim nhiều, đọc cuốn và rất xúc động.', 1),

-- 2. Tắt Đèn
(2, 6, 4, 'Tác phẩm phản ánh hiện thực rất sắc bén.', 1),
(2, 15, 5, 'Đọc lại sau nhiều năm vẫn thấy nghẹn ở đoạn cuối.', 1),
(2, 19, 4, 'Giá như kết có phần đỡ bi kịch hơn.', 1),

-- 3. Số Đỏ
(3, 10, 5, 'Hài hước nhưng châm biếm thâm sâu, đọc sướng.', 1),
(3, 13, 5, 'Một trong những tác phẩm thông minh nhất của văn học VN.', 1),
(3, 18, 4, 'Nhiều đoạn hơi khó hiểu nếu không quen lối văn cũ.', 1),

-- 4. Vợ chồng A Phủ
(4, 7, 4, 'Truyện đẹp và buồn, nhiều hình ảnh rất ám ảnh.', 1),
(4, 14, 5, 'Đọc xong thấy thương Mị vô cùng.', 1),
(4, 20, 4, 'Giọng văn mộc mạc, gần gũi.', 1),

-- 5. Chí Phèo
(5, 9, 5, 'Một kiệt tác thực sự, Nam Cao viết quá đỉnh.', 1),
(5, 11, 4, 'Buồn nhưng có chiều sâu, đọc xong cứ nghĩ mãi.', 1),
(5, 16, 4, 'Phần mô tả tâm lý nhân vật rất hay.', 1);


INSERT INTO coupons (code, discount_type, min_order_value, discount_value, expiration_date, is_active) VALUES
('FREESHIP2025', 'free_shipping', 150000, 15000, '2025-12-31', 1),
('SAVE20', 'fixed_amount', 200000, 20000, '2025-12-31', 1),
('BIGCOUPON', 'fixed_amount', 500000, 30000, '2025-12-31', 1);



INSERT INTO orders (user_id, total_amount, shipping_fee, discount_amount, final_amount, order_date, status, payment_status, order_number, shipping_address, coupon_code) VALUES
(3, 155000, 15000, 15000, 155000, '2025-11-11', 'delivered', 'paid', 'ORD-2025-001', '123 Đường Láng, Hà Nội', 'FREESHIP2025'),
(3, 99000, 15000, 0, 114000, '2025-11-11', 'delivered', 'paid', 'ORD-2025-002', '123 Đường Láng, Hà Nội', NULL),
(4, 374000, 15000, 20000, 354000, '2025-11-12', 'delivered', 'paid', 'ORD-2025-003', '456 Lê Lợi, TP.HCM', 'SAVE20'),
(5, 630000, 15000, 30000, 615000, '2025-11-13', 'delivered', 'paid', 'ORD-2025-004', '12 Hai Bà Trưng, Hà Nội', 'BIGCOUPON'),
(6, 440000, 15000, 20000, 425000, '2025-11-14', 'delivered', 'paid', 'ORD-2025-005', '88 Nguyễn Huệ, Đà Nẵng', 'SAVE20'),
(7, 250000, 15000, 15000, 250000, '2025-11-15', 'delivered', 'paid', 'ORD-2025-006', '23 Trần Phú, Hải Phòng', 'FREESHIP2025'),
(8, 62000, 15000, 0, 77000, '2025-11-16', 'delivered', 'paid', 'ORD-2025-007', '55 Lạch Tray, Hải Phòng', NULL),
(9, 360000, 15000, 20000, 355000, '2025-11-17', 'delivered', 'paid', 'ORD-2025-008', '101 Võ Thị Sáu, TP.HCM', 'SAVE20'),
(9, 350000, 15000, 20000, 365000, '2025-11-18', 'delivered', 'paid', 'ORD-2025-009', '101 Võ Thị Sáu, TP.HCM', 'SAVE20'),
(10, 210000, 15000, 15000, 210000, '2025-11-19', 'delivered', 'paid', 'ORD-2025-010', '78 Bạch Đằng, Đà Nẵng', 'FREESHIP2025'),
(11, 370000, 15000, 20000, 355000, '2025-11-20', 'delivered', 'paid', 'ORD-2025-011', '66 Nguyễn Trãi, Hà Nội', 'SAVE20'),
(12, 225000, 15000, 15000, 225000, '2025-11-21', 'delivered', 'paid', 'ORD-2025-012', '09 Lý Tự Trọng, Cần Thơ', 'FREESHIP2025'),
(13, 130000, 15000, 0, 145000, '2025-11-22', 'delivered', 'paid', 'ORD-2025-013', '44 Lê Duẩn, Hà Nội', NULL),
(14, 560000, 15000, 30000, 545000, '2025-11-23', 'delivered', 'paid', 'ORD-2025-014', '102 Lê Lợi, Huế', 'BIGCOUPON'),
(15, 170000, 15000, 15000, 170000, '2025-11-24', 'delivered', 'paid', 'ORD-2025-015', '200 Bình Long, TP.HCM', 'FREESHIP2025');



INSERT INTO order_items (order_id, book_id, quantity, price, subtotal) VALUES
(1, 2, 1, 70000, 85000),
(1, 3, 1, 85000, 60000),

(2, 1, 1, 99000, 99000),

(3, 6, 1, 79000, 79000),
(3, 14, 1, 85000, 66000),
(3, 15, 1, 100000, 100000),
(3, 29, 1, 110000, 110000),

(4, 7, 1, 130000, 130000),
(4, 8, 1, 150000, 150000),
(4, 9, 1, 220000, 220000),
(4, 30, 1, 130000, 130000),

(5, 7, 1, 130000, 130000),
(5, 8, 1, 150000, 150000),
(5, 9, 1, 160000, 160000),

(6, 17, 1, 80000, 80000),
(6, 18, 1, 85000, 85000),
(6, 19, 1, 85000, 85000),

(7, 26, 1, 20000, 20000),
(7, 27, 1, 22000, 22000),
(7, 28, 1, 20000, 20000),

(8, 36, 1, 110000, 110000),
(8, 37, 1, 120000, 120000),
(8, 38, 1, 130000, 130000),

(9, 41, 1, 130000, 130000),
(9, 43, 1, 110000, 110000),
(9, 44, 1, 110000, 110000),

(10, 2, 2, 70000, 140000),
(10, 5, 1, 70000, 70000),

(11, 12, 1, 190000, 190000),
(11, 13, 1, 180000, 180000),

(12, 15, 1, 100000, 100000),
(12, 31, 1, 125000, 125000),

(13, 32, 1, 130000, 130000),

(14, 33, 1, 180000, 180000),
(14, 34, 1, 170000, 170000),
(14, 35, 1, 180000, 180000),

(15, 24, 1, 80000, 80000),
(15, 25, 1, 90000, 90000);





