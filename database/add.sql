USE bookstore_db;

INSERT INTO books (title, isbn, author_id, publisher_id, category_id, description, price, discount_price, stock_quantity, cover_image, is_featured, pages) VALUES
('Sherlock Holmes - Tập 1', 'DT-002', 18, 3, 8, 'Những vụ án ly kỳ của thám tử Sherlock Holmes.', 120000, 110000, 40, 'sherlock-holmes-tap-1.jpg', 1, 300),
('Sherlock Holmes - Tập 2', 'DT-003', 18, 3, 8, 'Tiếp tục những vụ án hấp dẫn của Sherlock Holmes.', 120000, 120000, 35, 'sherlock-holmes-tap-2.jpg', 0, 320),
('Sherlock Holmes - Tập 3', 'DT-004', 18, 3, 8, 'Phần kết câu chuyện trinh thám kinh điển của Sherlock Holmes.', 130000, 130000, 30, 'sherlock-holmes-tap-3.jpg', 0, 350),
('Hannibal Lecter - Sự im lặng của bầy cừu', 'DT-001', 19, 3, 8, 'Tiểu thuyết trinh thám kinh dị về bác sĩ Hannibal Lecter.', 200000, 190000, 25, 'hannibal-lecter.jpg', 0, 400),
('Án mạng trên chuyến tàu tốc hành Phương Đông', 'DT-005', 20, 3, 8, 'Tiểu thuyết trinh thám kinh điển của Agatha Christie.', 150000, 140000, 20, 'an-mang-tren-chuyen-tau-phuong-dong.jpg', 0, 350),
('Án mạng ở Ngôi nhà màu đỏ', 'DT-006', 20, 3, 8, 'Một trong những tác phẩm trinh thám nổi tiếng của Agatha Christie.', 140000, 130000, 15, 'an-mang-o-ngoi-nha-mau-do.jpg', 0, 300),
('Án mạng tại biệt thự Styles', 'DT-007', 20, 3, 8, 'Tác phẩm trinh thám đầu tiên của Agatha Christie.', 130000, 120000, 10, 'an-mang-tai-biet-thu-styles.jpg', 0, 280),
('Vụ Án Mạng Được Báo Trước', 'DT-008', 20, 3, 8, 'Một trong những câu chuyện trinh thám hấp dẫn của Agatha Christie.', 120000, 110000, 5, 'vu-an-mang-duoc-bao-truoc.jpg', 0, 260),
('Bí Ẩn Ba Phần Tư', 'DT-009', 20, 3, 8, 'Câu chuyện trinh thám ly kỳ của Agatha Christie.', 110000, 110000, 8, 'bi-an-ba-phan-tu.jpg', 0, 240);