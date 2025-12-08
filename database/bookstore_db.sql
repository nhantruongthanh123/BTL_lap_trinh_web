-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2025 at 04:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `author_id` int(11) NOT NULL,
  `author_name` varchar(100) NOT NULL,
  `biography` text DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`author_id`, `author_name`, `biography`, `birth_date`, `nationality`, `created_at`) VALUES
(1, 'Nguyễn Nhật Ánh', 'Nhà văn chuyên viết cho thanh thiếu niên.', NULL, 'Vietnam', '2025-12-07 02:37:58'),
(2, 'Ngô Tất Tố', 'Nhà văn nổi tiếng với tác phẩm \"Tắt Đèn\".', NULL, 'Vietnam', '2025-12-07 02:37:58'),
(3, 'Vũ Trọng Phụng', 'Nhà văn hiện thực phê phán nổi tiếng.', NULL, 'Vietnam', '2025-12-07 02:37:58'),
(4, 'Tô Hoài', 'Tác giả của nhiều tác phẩm văn học thiếu nhi.', NULL, 'Vietnam', '2025-12-07 02:37:58'),
(5, 'Nam Cao', 'Tác giả của nhiều truyện ngắn nổi tiếng.', NULL, 'Vietnam', '2025-12-07 02:37:58'),
(6, 'Paulo Coelho', 'Tác giả Nhà Giả Kim.', NULL, 'Brazil', '2025-12-07 02:37:58'),
(7, 'J.K. Rowling', 'Tác giả bộ truyện Harry Potter.', NULL, 'United Kingdom', '2025-12-07 02:37:58'),
(8, 'Rosie Nguyễn', 'Tác giả sách kỹ năng sống nổi tiếng.', NULL, 'Vietnam', '2025-12-07 02:37:58'),
(9, 'Robert T. Kiyosaki', 'Tác giả bộ Dạy Con Làm Giàu.', NULL, 'USA', '2025-12-07 02:37:58'),
(10, 'Nguyễn Ngọc Thuần', 'Nhà văn chuyên viết truyện thiếu nhi nổi tiếng.', NULL, 'Vietnam', '2025-12-07 02:37:58'),
(11, 'Antoine de Saint-Exupéry', 'Tác giả của tác phẩm kinh điển Hoàng Tử Bé.', NULL, 'France', '2025-12-07 02:37:58'),
(12, 'Eiichiro Oda', 'Tác giả bộ truyện tranh One Piece.', NULL, 'Japan', '2025-12-07 02:37:58'),
(13, 'Masashi Kishimoto', 'Tác giả bộ truyện tranh Naruto.', NULL, 'Japan', '2025-12-07 02:37:58'),
(14, 'Akira Toriyama', 'Tác giả bộ truyện tranh Dragon Ball.', NULL, 'Japan', '2025-12-07 02:37:58'),
(15, 'Andrew Hutchinson', 'Tác giả sách lập trình Python.', NULL, 'USA', '2025-12-07 02:37:58'),
(16, 'Robert Lafore', 'Tác giả sách về thuật toán và cấu trúc dữ liệu.', NULL, 'USA', '2025-12-07 02:37:58'),
(17, 'Nguyễn Văn Nhân', 'Tác giả giáo trình đại học nổi tiếng.', NULL, 'Vietnam', '2025-12-07 02:37:58'),
(18, 'Conan Doyle', 'Tác giả bộ truyện trinh thám Sherlock Holmes.', NULL, 'United Kingdom', '2025-12-07 02:37:58'),
(19, 'Thomas Harris', 'Tác giả của loạt tiểu thuyết trinh thám nổi tiếng.', NULL, 'USA', '2025-12-07 02:37:58'),
(20, 'Agatha Christie', 'Nữ hoàng trinh thám với nhiều tác phẩm kinh điển.', NULL, 'United Kingdom', '2025-12-07 02:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `publisher_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `pages` int(11) DEFAULT NULL,
  `language` varchar(50) DEFAULT 'Vietnamese',
  `publication_date` date DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `format` enum('Hardcover','Paperback','Ebook') DEFAULT 'Paperback',
  `weight` decimal(5,2) DEFAULT NULL COMMENT 'Weight in grams',
  `dimensions` varchar(50) DEFAULT NULL COMMENT 'e.g., 20x15x2 cm',
  `is_featured` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `view_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `isbn`, `author_id`, `publisher_id`, `category_id`, `description`, `price`, `discount_price`, `stock_quantity`, `pages`, `language`, `publication_date`, `cover_image`, `format`, `weight`, `dimensions`, `is_featured`, `is_active`, `view_count`, `created_at`, `updated_at`) VALUES
(1, 'Mắt Biếc', 'VN-001', 1, 1, 1, 'Một câu chuyện tình yêu buồn và đẹp nhất của Nguyễn Nhật Ánh.', 110000.00, 99000.00, 46, 300, 'Vietnamese', NULL, 'mat-biec.jpg', 'Paperback', NULL, NULL, 1, 1, 0, '2025-12-07 02:37:58', '2025-12-08 02:48:36'),
(2, 'Tắt đèn', 'VN-004', 2, 3, 1, 'Tác phẩm phản ánh cuộc sống nông thôn Việt Nam dưới ách đô hộ của thực dân Pháp.', 70000.00, 70000.00, 75, 180, 'Vietnamese', NULL, 'tat-den.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(3, 'Số Đỏ', 'VN-005', 3, 3, 1, 'Tiểu thuyết châm biếm xã hội Việt Nam thời Pháp thuộc.', 90000.00, 85000.00, 60, 250, 'Vietnamese', NULL, 'so-do.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(4, 'Vợ chồng A Phủ', 'VN-008', 4, 3, 1, 'Câu chuyện về cuộc sống và tình yêu của người dân tộc thiểu số vùng Tây Bắc.', 75000.00, 75000.00, 80, 210, 'Vietnamese', NULL, 'vo-chong-a-phu.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(5, 'Chí Phèo', 'VN-007', 5, 3, 1, 'Truyện ngắn nổi tiếng về cuộc đời bi kịch của Chí Phèo.', 75000.00, 70000.00, 90, 200, 'Vietnamese', NULL, 'chi-pheo.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(6, 'Nhà Giả Kim', 'BR-001', 6, 3, 2, 'Cuốn sách bán chạy chỉ sau Kinh Thánh.', 79000.00, 79000.00, 150, 220, 'Vietnamese', NULL, 'nha-gia-kim.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(7, 'Harry Potter và Hòn đá Phù thủy', 'UK-001', 7, 1, 2, 'Tập đầu tiên trong series Harry Potter nổi tiếng toàn cầu.', 150000.00, 130000.00, 30, 400, 'Vietnamese', NULL, 'harry-potter-1.jpg', 'Paperback', NULL, NULL, 1, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(8, 'Harry Potter và Phòng chứa Bí mật', 'UK-002', 7, 1, 2, 'Tập thứ hai trong series Harry Potter.', 150000.00, 150000.00, 25, 420, 'Vietnamese', NULL, 'harry-potter-2.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(9, 'Harry Potter và Tù nhân Ngục Azkaban', 'UK-003', 7, 1, 2, 'Tập thứ ba trong series Harry Potter.', 160000.00, 160000.00, 20, 450, 'Vietnamese', NULL, 'harry-potter-3.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(10, 'Harry Potter và Chiếc cốc lửa', 'UK-004', 7, 1, 2, 'Tập thứ tư trong series Harry Potter.', 150000.00, 150000.00, 15, 500, 'Vietnamese', NULL, 'harry-potter-4.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(11, 'Harry Potter và Hội Phượng hoàng', 'UK-005', 7, 1, 2, 'Tập thứ năm trong series Harry Potter.', 180000.00, 180000.00, 10, 600, 'Vietnamese', NULL, 'harry-potter-5.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(12, 'Harry Potter và Hoàng tử lai', 'UK-006', 7, 1, 2, 'Tập thứ sáu trong series Harry Potter.', 190000.00, 190000.00, 8, 650, 'Vietnamese', NULL, 'harry-potter-6.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(13, 'Harry Potter và Bảo bối Tử thần', 'UK-007', 7, 1, 2, 'Tập cuối cùng trong series Harry Potter.', 200000.00, 180000.00, 5, 700, 'Vietnamese', NULL, 'harry-potter-7.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(14, 'Đắc Nhân Tâm', 'VN-003', 8, 4, 3, 'Cuốn sách giúp bạn cải thiện kỹ năng giao tiếp và xây dựng mối quan hệ.', 90000.00, 85000.00, 68, 220, 'Vietnamese', NULL, 'dac-nhan-tam.jpg', 'Paperback', NULL, NULL, 1, 1, 0, '2025-12-07 02:37:58', '2025-12-08 02:46:02'),
(15, 'Dạy Con Làm Giàu', 'US-001', 9, 4, 3, 'Cuốn sách kinh điển về tài chính cá nhân và đầu tư.', 120000.00, 100000.00, 39, 250, 'Vietnamese', NULL, 'day-con-lam-giau.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-08 01:28:47'),
(16, 'Dế mèn phiêu lưu ký', 'VN-006', 4, 2, 4, 'Cuộc phiêu lưu của chú dế mèn dũng cảm và thông minh.', 60000.00, 55000.00, 120, 220, 'Vietnamese', NULL, 'de-men-phieu-luu-ky.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(17, 'Kính Vạn Hoa - Tập 1', 'VN-002', 1, 2, 4, 'Những câu chuyện học trò tinh nghịch của Quý ròm, nhỏ Hạnh và Tiểu Long.', 85000.00, 80000.00, 100, 200, 'Vietnamese', NULL, 'kinh-van-hoa-tap-1.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(18, 'Kính Vạn Hoa - Tập 2', 'VN-009', 1, 2, 4, 'Tiếp tục những cuộc phiêu lưu của nhóm bạn trong Kính Vạn Hoa.', 85000.00, 85000.00, 90, 210, 'Vietnamese', NULL, 'kinh-van-hoa-tap-2.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(19, 'Kính Vạn Hoa - Tập 3', 'VN-010', 1, 2, 4, 'Những câu chuyện hài hước và ý nghĩa trong Kính Vạn Hoa.', 85000.00, 85000.00, 80, 220, 'Vietnamese', NULL, 'kinh-van-hoa-tap-3.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(20, 'Kính Vạn Hoa - Tập 4', 'VN-011', 1, 2, 4, 'Những chuyến phiêu lưu mới của nhóm bạn trong Kính Vạn Hoa.', 85000.00, 85000.00, 70, 230, 'Vietnamese', NULL, 'kinh-van-hoa-tap-4.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(21, 'Kính Vạn Hoa - Tập 5', 'VN-012', 1, 2, 4, 'Tiếp tục những câu chuyện thú vị trong Kính Vạn Hoa.', 85000.00, 85000.00, 60, 240, 'Vietnamese', NULL, 'kinh-van-hoa-tap-5.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(22, 'Kinh Vạn Hoa - Tập 6', 'VN-013', 1, 2, 4, 'Những cuộc phiêu lưu kỳ thú của nhóm bạn trong Kính Vạn Hoa.', 85000.00, 85000.00, 50, 250, 'Vietnamese', NULL, 'kinh-van-hoa-tap-6.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(23, 'Cho tôi một vé đi tuổi thơ', 'VN-014', 1, 2, 4, 'Tập hợp những câu chuyện ngắn về tuổi thơ đầy kỷ niệm.', 70000.00, 70000.00, 110, 180, 'Vietnamese', NULL, 'cho-toi-mot-ve-di-tuoi-tho.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(24, 'Vừa Nhắm Mắt Vừa Mở Cửa Sổ', 'VN-015', 10, 1, 4, 'Một câu chuyện nhẹ nhàng, trong trẻo dành cho thiếu nhi.', 80000.00, 80000.00, 90, 200, 'Vietnamese', NULL, 'vua-nham-mat-vua-mo-cua-so.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(25, 'Hoàng Tử Bé', 'FR-001', 11, 2, 4, 'Tác phẩm kinh điển về tình bạn và cuộc sống.', 95000.00, 90000.00, 130, 150, 'Vietnamese', NULL, 'hoang-tu-be.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(26, 'One Piece - Tập 1', 'JP-001', 12, 2, 5, 'Bắt đầu cuộc hành trình của Luffy và băng hải tặc Mũ Rơm.', 20000.00, 20000.00, 40, 200, 'Vietnamese', NULL, 'one-piece-tap-1.jpg', 'Paperback', NULL, NULL, 1, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(27, 'Naruto - Tập 1', 'JP-002', 13, 2, 5, 'Câu chuyện về cậu bé ninja Naruto Uzumaki.', 22000.00, 22000.00, 35, 220, 'Vietnamese', NULL, 'naruto-tap-1.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(28, 'Dragon Ball - Tập 1', 'JP-003', 14, 2, 5, 'Cuộc phiêu lưu của Goku từ nhỏ đến lớn.', 20000.00, 20000.00, 30, 210, 'Vietnamese', NULL, 'dragon-ball-tap-1.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(29, 'Lập trình Python căn bản', 'IT-001', 15, 4, 6, 'Sách hướng dẫn lập trình Python từ cơ bản đến nâng cao.', 120000.00, 110000.00, 45, 350, 'Vietnamese', NULL, 'lap-trinh-python-can-ban.jpg', 'Paperback', NULL, NULL, 1, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(30, 'Thuật toán và cấu trúc dữ liệu', 'IT-002', 16, 4, 6, 'Tài liệu tham khảo về thuật toán và cấu trúc dữ liệu trong lập trình.', 130000.00, 130000.00, 50, 400, 'Vietnamese', NULL, 'thuat-toan-cau-truc-du-lieu.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(31, 'Lập trình web với JavaScript', 'IT-003', 15, 4, 6, 'Hướng dẫn xây dựng website động sử dụng JavaScript.', 125000.00, 125000.00, 40, 300, 'Vietnamese', NULL, 'lap-trinh-web-javascript.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(32, 'An toàn thông tin cơ bản', 'IT-004', 16, 4, 6, 'Những kiến thức cơ bản về an toàn thông tin và bảo mật mạng.', 140000.00, 130000.00, 35, 320, 'Vietnamese', NULL, 'an-toan-thong-tin-co-ban.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(33, 'Giáo trình Toán cao cấp', 'GT-001', 17, 4, 7, 'Giáo trình toán cao cấp dành cho sinh viên đại học.', 200000.00, 180000.00, 60, 600, 'Vietnamese', NULL, 'giao-trinh-toan-cao-cap.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(34, 'Giáo trình Vật lý đại cương', 'GT-002', 17, 4, 7, 'Giáo trình vật lý đại cương dành cho sinh viên đại học.', 180000.00, 170000.00, 70, 550, 'Vietnamese', NULL, 'giao-trinh-vat-ly-dai-cuong.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(35, 'Giáo trình Hóa học đại cương', 'GT-003', 17, 4, 7, 'Giáo trình hóa học đại cương dành cho sinh viên đại học.', 190000.00, 180000.00, 65, 580, 'Vietnamese', NULL, 'giao-trinh-hoa-hoc-dai-cuong.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(36, 'Sherlock Holmes - Tập 1', 'DT-002', 18, 3, 8, 'Những vụ án ly kỳ của thám tử Sherlock Holmes.', 120000.00, 110000.00, 38, 300, 'Vietnamese', NULL, 'sherlock-holmes-tap-1.jpg', 'Paperback', NULL, NULL, 1, 1, 0, '2025-12-07 02:37:58', '2025-12-08 02:46:02'),
(37, 'Sherlock Holmes - Tập 2', 'DT-003', 18, 3, 8, 'Tiếp tục những vụ án hấp dẫn của Sherlock Holmes.', 120000.00, 120000.00, 35, 320, 'Vietnamese', NULL, 'sherlock-holmes-tap-2.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(38, 'Sherlock Holmes - Tập 3', 'DT-004', 18, 3, 8, 'Phần kết câu chuyện trinh thám kinh điển của Sherlock Holmes.', 130000.00, 130000.00, 30, 350, 'Vietnamese', NULL, 'sherlock-holmes-tap-3.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(39, 'Hannibal Lecter - Sự im lặng của bầy cừu', 'DT-001', 19, 3, 8, 'Tiểu thuyết trinh thám kinh dị về bác sĩ Hannibal Lecter.', 200000.00, 190000.00, 25, 400, 'Vietnamese', NULL, 'hannibal-lecter.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(40, 'Án mạng trên chuyến tàu tốc hành Phương Đông', 'DT-005', 20, 3, 8, 'Tiểu thuyết trinh thám kinh điển của Agatha Christie.', 150000.00, 140000.00, 20, 350, 'Vietnamese', NULL, 'an-mang-tren-chuyen-tau-phuong-dong.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(41, 'Án mạng ở nhà mục vụ', 'DT-006', 20, 3, 8, 'Một trong những tác phẩm trinh thám nổi tiếng của Agatha Christie.', 140000.00, 130000.00, 15, 300, 'Vietnamese', NULL, 'an-mang-o-nha-muc-vu.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(42, 'Cái chết trên sông Nile', 'DT-007', 20, 3, 8, 'Tiểu thuyết trinh thám hấp dẫn của Agatha Christie.', 130000.00, 120000.00, 10, 280, 'Vietnamese', NULL, 'cai-chet-tren-song-nile.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(43, 'Mười Người Da Đen Nhỏ', 'DT-008', 20, 3, 8, 'Một trong những tác phẩm trinh thám kinh điển của Agatha Christie.', 120000.00, 110000.00, 12, 260, 'Vietnamese', NULL, 'muoi-nguoi-da-den-nho.jpg', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(44, 'Bí Ẩn Ba Phần Tư phần1', 'DT-009', 20, 3, 8, 'Câu chuyện trinh thám ly kỳ của Agatha Christie.', 110000.00, 110000.00, 8, 240, 'Vietnamese', NULL, 'cover_1765162253_69363d0dd5477.png', 'Paperback', NULL, NULL, 0, 1, 0, '2025-12-07 02:37:58', '2025-12-07 20:50:53');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `slug` varchar(100) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`, `slug`, `is_active`, `created_at`) VALUES
(1, 'Văn học trong nước', 'Các tác phẩm văn học của tác giả Việt Nam', 'van-hoc-trong-nuoc', 1, '2025-11-06 03:00:00'),
(2, 'Văn học nước ngoài', 'Tiểu thuyết, truyện ngắn dịch từ nước ngoài', 'van-hoc-nuoc-ngoai', 1, '2025-11-06 03:00:05'),
(3, 'Kinh tế - Kỹ năng', 'Sách dạy làm giàu, phát triển bản thân', 'kinh-te-ky-nang', 1, '2025-11-06 03:02:16'),
(4, 'Sách Thiếu nhi', 'Truyện tranh, truyện cổ tích cho bé', 'sach-thieu-nhi', 1, '2025-11-06 03:05:00'),
(5, 'Truyên tranh', 'Sách truyện tranh đa thể loại', 'truyen-tranh', 1, '2025-11-06 03:07:30'),
(6, 'Công nghệ thông tin', 'Sách lập trình, thuật toán', 'cntt', 1, '2025-11-06 03:10:00'),
(7, 'Giáo trình - Tham khảo', 'Sách giáo khoa, tài liệu tham khảo', 'giao-trinh-tham-khao', 1, '2025-11-06 03:12:45'),
(8, 'Trinh thám', 'Sách trinh thám, phá án', 'trinh-tham', 1, '2025-11-06 03:15:20');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `coupon_id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_type` enum('free_shipping','fixed_amount') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `min_order_value` decimal(10,2) DEFAULT 0.00,
  `expiration_date` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`coupon_id`, `code`, `discount_type`, `discount_value`, `min_order_value`, `expiration_date`, `is_active`, `created_at`) VALUES
(1, 'FREESHIP2025', 'free_shipping', 15000.00, 150000.00, '2025-12-31', 1, '2025-12-07 02:37:58'),
(2, 'SAVE20', 'fixed_amount', 20000.00, 200000.00, '2025-12-31', 1, '2025-12-07 02:37:58'),
(3, 'BIGCOUPON', 'fixed_amount', 30000.00, 500000.00, '2025-12-31', 1, '2025-12-07 02:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coupon_code` varchar(50) DEFAULT NULL,
  `order_number` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) DEFAULT 0.00,
  `shipping_fee` decimal(10,2) DEFAULT 15000.00,
  `final_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','processing','shipping','delivered','cancelled') DEFAULT 'pending',
  `payment_status` enum('unpaid','paid') DEFAULT 'unpaid',
  `payment_method` enum('cod','bank_transfer','momo') DEFAULT 'cod',
  `note` text DEFAULT NULL,
  `shipping_address` text NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancellation_reason` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `coupon_code`, `order_number`, `total_amount`, `discount_amount`, `shipping_fee`, `final_amount`, `status`, `payment_status`, `payment_method`, `note`, `shipping_address`, `order_date`, `confirmed_at`, `shipped_at`, `delivered_at`, `cancelled_at`, `cancellation_reason`, `updated_at`) VALUES
(1, 3, 'FREESHIP2025', 'ORD-2025-001', 155000.00, 15000.00, 15000.00, 155000.00, 'delivered', 'paid', 'cod', NULL, '123 Đường Láng, Hà Nội', '2025-11-10 17:00:00', NULL, NULL, NULL, NULL, NULL, '2025-12-07 02:37:58'),
(2, 3, NULL, 'ORD-2025-002', 99000.00, 0.00, 15000.00, 114000.00, 'delivered', 'paid', 'cod', NULL, '123 Đường Láng, Hà Nội', '2025-11-10 17:00:00', NULL, NULL, NULL, NULL, NULL, '2025-12-07 02:37:58'),
(3, 4, 'SAVE20', 'ORD-2025-003', 374000.00, 20000.00, 15000.00, 354000.00, 'delivered', 'paid', 'cod', NULL, '456 Lê Lợi, TP.HCM', '2025-11-11 17:00:00', NULL, NULL, NULL, NULL, NULL, '2025-12-07 02:37:58'),
(4, 5, 'BIGCOUPON', 'ORD-2025-004', 630000.00, 30000.00, 15000.00, 615000.00, 'delivered', 'paid', 'cod', NULL, '12 Hai Bà Trưng, Hà Nội', '2025-11-12 17:00:00', NULL, NULL, NULL, NULL, NULL, '2025-12-07 02:37:58'),
(5, 6, 'SAVE20', 'ORD-2025-005', 440000.00, 20000.00, 15000.00, 425000.00, 'delivered', 'paid', 'cod', NULL, '88 Nguyễn Huệ, Đà Nẵng', '2025-11-13 17:00:00', NULL, NULL, NULL, NULL, NULL, '2025-12-07 02:37:58'),
(6, 7, 'FREESHIP2025', 'ORD-2025-006', 250000.00, 15000.00, 15000.00, 250000.00, 'delivered', 'paid', 'cod', NULL, '23 Trần Phú, Hải Phòng', '2025-11-14 17:00:00', NULL, NULL, NULL, NULL, NULL, '2025-12-07 02:37:58'),
(7, 8, NULL, 'ORD-2025-007', 62000.00, 0.00, 15000.00, 77000.00, 'delivered', 'paid', 'cod', NULL, '55 Lạch Tray, Hải Phòng', '2025-11-15 17:00:00', NULL, NULL, NULL, NULL, NULL, '2025-12-07 02:37:58'),
(8, 9, 'SAVE20', 'ORD-2025-008', 360000.00, 20000.00, 15000.00, 355000.00, 'delivered', 'paid', 'cod', NULL, '101 Võ Thị Sáu, TP.HCM', '2025-11-16 17:00:00', NULL, NULL, NULL, NULL, NULL, '2025-12-07 02:37:58'),
(9, 9, 'SAVE20', 'ORD-2025-009', 350000.00, 20000.00, 15000.00, 365000.00, 'delivered', 'paid', 'cod', NULL, '101 Võ Thị Sáu, TP.HCM', '2025-11-17 17:00:00', NULL, NULL, NULL, NULL, NULL, '2025-12-07 02:37:58'),
(10, 10, 'FREESHIP2025', 'ORD-2025-010', 210000.00, 15000.00, 15000.00, 210000.00, 'delivered', 'paid', 'cod', NULL, '78 Bạch Đằng, Đà Nẵng', '2025-11-18 17:00:00', NULL, NULL, NULL, NULL, NULL, '2025-12-07 02:37:58'),
(11, 11, 'SAVE20', 'ORD-2025-011', 370000.00, 20000.00, 15000.00, 355000.00, 'delivered', 'paid', 'cod', NULL, '66 Nguyễn Trãi, Hà Nội', '2025-11-19 17:00:00', NULL, NULL, NULL, NULL, NULL, '2025-12-07 02:37:58'),
(12, 12, 'FREESHIP2025', 'ORD-2025-012', 225000.00, 15000.00, 15000.00, 225000.00, 'delivered', 'paid', 'cod', NULL, '09 Lý Tự Trọng, Cần Thơ', '2025-11-20 17:00:00', NULL, NULL, NULL, NULL, NULL, '2025-12-07 02:37:58'),
(13, 13, NULL, 'ORD-2025-013', 130000.00, 0.00, 15000.00, 145000.00, 'delivered', 'paid', 'cod', NULL, '44 Lê Duẩn, Hà Nội', '2025-11-21 17:00:00', NULL, NULL, NULL, NULL, NULL, '2025-12-07 02:37:58'),
(14, 14, 'BIGCOUPON', 'ORD-2025-014', 560000.00, 30000.00, 15000.00, 545000.00, 'delivered', 'paid', 'cod', NULL, '102 Lê Lợi, Huế', '2025-11-22 17:00:00', NULL, NULL, NULL, NULL, NULL, '2025-12-07 02:37:58'),
(15, 15, 'FREESHIP2025', 'ORD-2025-015', 170000.00, 15000.00, 15000.00, 170000.00, 'delivered', 'paid', 'cod', NULL, '200 Bình Long, TP.HCM', '2025-11-23 17:00:00', NULL, NULL, NULL, NULL, NULL, '2025-12-07 02:37:58'),
(16, 3, 'FREESHIP2025', 'ORD-20251207-737BAB', 198000.00, 15000.00, 0.00, 183000.00, 'delivered', 'paid', 'cod', '', '123 Đường Láng, Hà Nội', '2025-12-07 13:09:11', NULL, NULL, NULL, NULL, NULL, '2025-12-07 13:10:09'),
(17, 4, 'FREESHIP2025', 'ORD-20251208-FCFF2A', 284000.00, 15000.00, 0.00, 269000.00, 'delivered', 'paid', 'cod', '', '456 Lê Lợi, TP.HCM', '2025-12-08 01:28:47', NULL, NULL, NULL, NULL, NULL, '2025-12-08 01:36:44'),
(18, 4, '', 'ORD-20251208-7EE878', 99000.00, 0.00, 15000.00, 114000.00, 'cancelled', 'unpaid', 'cod', '', '456 Lê Lợi, TP.HCM', '2025-12-08 01:30:47', NULL, NULL, NULL, '2025-12-08 01:42:01', NULL, '2025-12-08 01:42:01'),
(19, 4, '', 'ORD-20251208-A8F00F', 305000.00, 0.00, 15000.00, 320000.00, 'pending', 'unpaid', 'cod', '', '456 Lê Lợi, TP.HCM', '2025-12-08 02:46:02', NULL, NULL, NULL, NULL, NULL, '2025-12-08 02:46:02'),
(20, 3, '', 'ORD-20251208-42F75A', 99000.00, 0.00, 15000.00, 114000.00, 'pending', 'unpaid', 'cod', '', '123 Đường Láng, Hà Nội', '2025-12-08 02:48:36', NULL, NULL, NULL, NULL, NULL, '2025-12-08 02:48:36');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `book_id`, `quantity`, `price`, `subtotal`) VALUES
(1, 1, 2, 1, 70000.00, 85000.00),
(2, 1, 3, 1, 85000.00, 60000.00),
(3, 2, 1, 1, 99000.00, 99000.00),
(4, 3, 6, 1, 79000.00, 79000.00),
(5, 3, 14, 1, 85000.00, 66000.00),
(6, 3, 15, 1, 100000.00, 100000.00),
(7, 3, 29, 1, 110000.00, 110000.00),
(8, 4, 7, 1, 130000.00, 130000.00),
(9, 4, 8, 1, 150000.00, 150000.00),
(10, 4, 9, 1, 220000.00, 220000.00),
(11, 4, 30, 1, 130000.00, 130000.00),
(12, 5, 7, 1, 130000.00, 130000.00),
(13, 5, 8, 1, 150000.00, 150000.00),
(14, 5, 9, 1, 160000.00, 160000.00),
(15, 6, 17, 1, 80000.00, 80000.00),
(16, 6, 18, 1, 85000.00, 85000.00),
(17, 6, 19, 1, 85000.00, 85000.00),
(18, 7, 26, 1, 20000.00, 20000.00),
(19, 7, 27, 1, 22000.00, 22000.00),
(20, 7, 28, 1, 20000.00, 20000.00),
(21, 8, 36, 1, 110000.00, 110000.00),
(22, 8, 37, 1, 120000.00, 120000.00),
(23, 8, 38, 1, 130000.00, 130000.00),
(24, 9, 41, 1, 130000.00, 130000.00),
(25, 9, 43, 1, 110000.00, 110000.00),
(26, 9, 44, 1, 110000.00, 110000.00),
(27, 10, 2, 2, 70000.00, 140000.00),
(28, 10, 5, 1, 70000.00, 70000.00),
(29, 11, 12, 1, 190000.00, 190000.00),
(30, 11, 13, 1, 180000.00, 180000.00),
(31, 12, 15, 1, 100000.00, 100000.00),
(32, 12, 31, 1, 125000.00, 125000.00),
(33, 13, 32, 1, 130000.00, 130000.00),
(34, 14, 33, 1, 180000.00, 180000.00),
(35, 14, 34, 1, 170000.00, 170000.00),
(36, 14, 35, 1, 180000.00, 180000.00),
(37, 15, 24, 1, 80000.00, 80000.00),
(38, 15, 25, 1, 90000.00, 90000.00),
(39, 16, 1, 2, 99000.00, 198000.00),
(40, 17, 1, 1, 99000.00, 99000.00),
(41, 17, 14, 1, 85000.00, 85000.00),
(42, 17, 15, 1, 100000.00, 100000.00),
(43, 18, 1, 1, 99000.00, 99000.00),
(44, 19, 36, 2, 110000.00, 220000.00),
(45, 19, 14, 1, 85000.00, 85000.00),
(46, 20, 1, 1, 99000.00, 99000.00);

-- --------------------------------------------------------

--
-- Table structure for table `publishers`
--

CREATE TABLE `publishers` (
  `publisher_id` int(11) NOT NULL,
  `publisher_name` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`publisher_id`, `publisher_name`, `address`, `phone`, `email`, `website`, `created_at`) VALUES
(1, 'NXB Trẻ', '161B Lý Chính Thắng, TP.HCM', NULL, 'info@nxbtre.com.vn', NULL, '2025-12-07 02:37:58'),
(2, 'NXB Kim Đồng', '55 Quang Trung, Hà Nội', NULL, 'info@nxbkimdong.com.vn', NULL, '2025-12-07 02:37:58'),
(3, 'NXB Hội Nhà Văn', '65 Nguyễn Du, Hà Nội', NULL, 'hnv@gmail.com', NULL, '2025-12-07 02:37:58'),
(4, 'NXB Tổng Hợp TP.HCM', '148 Nguyễn Thị Minh Khai, TP.HCM', NULL, 'info@nxbtphcm.com.vn', NULL, '2025-12-07 02:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `is_verified_purchase` tinyint(1) DEFAULT 0,
  `is_approved` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `book_id`, `user_id`, `rating`, `comment`, `is_verified_purchase`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 5, 'Đọc xong thấy nghèn nghẹn, câu chuyện giản dị mà thấm.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(2, 2, 7, 4, 'Tác phẩm kinh điển, nhưng vài đoạn hơi dài.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(3, 3, 9, 5, 'Vừa hài hước vừa sâu cay, đọc mà phải suy ngẫm.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(4, 4, 12, 4, 'Giọng văn ấm và buồn nhẹ, hợp đọc buổi tối.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(5, 5, 14, 5, 'Một truyện ngắn xuất sắc, dễ hiểu mà cảm động.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(6, 6, 6, 5, 'Cuốn sách khiến mình muốn thay đổi cách sống.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(7, 7, 15, 5, 'Cả tuổi thơ gói lại trong cuốn này, tuyệt vời.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(8, 8, 18, 4, 'Nội dung ổn, hơi chậm đoạn đầu nhưng càng về sau càng cuốn.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(9, 9, 11, 5, 'Tập này tone tối hơn nhưng siêu hay.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(10, 10, 20, 5, 'Đọc một lèo hết luôn, nhiều khoảnh khắc nổi da gà.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(11, 11, 4, 4, 'Khá nặng nhưng nội dung chất lượng.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(12, 12, 16, 5, 'Tác giả viết quá đỉnh, cảm xúc dạt dào.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(13, 13, 10, 5, 'Cái kết làm mình nổi da gà. Xuất sắc.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(14, 14, 3, 4, 'Nhiều bài học áp dụng được ngay, dễ đọc.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(15, 15, 17, 5, 'Sách tài chính hay nhất mình từng đọc.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(16, 16, 8, 5, 'Tuổi thơ quay trở lại, nhẹ nhàng và đẹp.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(17, 17, 13, 5, 'Một tác phẩm kinh điển, đọc lại vẫn hay như xưa.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(18, 18, 6, 4, 'Dễ thương và ý nghĩa, hợp cho mọi lứa tuổi.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(19, 19, 19, 5, 'Vui, đọc để giải trí cực hợp.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(20, 20, 12, 5, 'Nhiều tình tiết sáng tạo, đọc không chán.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(21, 21, 3, 4, 'Giữ được chất của Kính Vạn Hoa, rất ổn.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(22, 22, 7, 4, 'Lời kể hồn nhiên, đọc thấy thích.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(23, 23, 15, 5, 'Câu chuyện vượt thời gian, sâu sắc.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(24, 24, 10, 4, 'Nhẹ nhàng và dễ thương.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(25, 25, 18, 5, 'Một tác phẩm triết lý nhưng không hề khó hiểu.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(26, 26, 14, 5, 'One Piece tập đầu quá huyền thoại.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(27, 27, 20, 4, 'Naruto mở đầu cảm động và cuốn hút.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(28, 28, 11, 5, 'Dragon Ball mãi đỉnh, đọc bao lần vẫn ghiền.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(29, 29, 8, 5, 'Viết dễ hiểu, phù hợp người mới.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(30, 30, 4, 5, 'Giải thích kỹ, ví dụ rõ ràng.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(31, 31, 17, 4, 'Khá đầy đủ nhưng phần nâng cao hơi ít.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(32, 32, 5, 5, 'Một trong những cuốn cơ bản về bảo mật tốt nhất.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(33, 33, 6, 4, 'Chi tiết nhưng hơi khó đọc nếu tự học.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(34, 34, 9, 4, 'Phần vật lý hiện đại viết rất logic.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(35, 35, 13, 4, 'Lý thuyết chắc chắn, đúng chuẩn giáo trình.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(36, 36, 19, 5, 'Sherlock Holmes luôn đáng đọc.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(37, 37, 16, 5, 'Các vụ án được sắp xếp cực thông minh.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(38, 38, 3, 4, 'Hay nhưng hơi ngắn.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(39, 39, 12, 4, 'Cốt truyện lôi cuốn, nhiều twist hay.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(40, 40, 11, 5, 'Agatha Christie viết quá đỉnh!', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(41, 41, 18, 4, 'Khá bất ngờ ở đoạn cuối.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(42, 42, 7, 4, 'Một khởi đầu tốt cho series về Poirot.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(43, 43, 15, 4, 'Gay cấn từ đầu đến cuối.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(44, 44, 20, 4, 'Tốc độ nhanh, đọc rất sướng.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(45, 1, 3, 5, 'Một câu chuyện đẹp nhưng buồn, đọc xong thấy day dứt mãi.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(46, 1, 12, 4, 'Giọng văn nhẹ nhàng, hơi chậm nhưng cảm xúc thật.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(47, 1, 17, 5, 'Sách hay hơn bản phim nhiều, đọc cuốn và rất xúc động.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(48, 2, 6, 4, 'Tác phẩm phản ánh hiện thực rất sắc bén.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(49, 2, 15, 5, 'Đọc lại sau nhiều năm vẫn thấy nghẹn ở đoạn cuối.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(50, 2, 19, 4, 'Giá như kết có phần đỡ bi kịch hơn.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(51, 3, 10, 5, 'Hài hước nhưng châm biếm thâm sâu, đọc sướng.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(52, 3, 13, 5, 'Một trong những tác phẩm thông minh nhất của văn học VN.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(53, 3, 18, 4, 'Nhiều đoạn hơi khó hiểu nếu không quen lối văn cũ.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(54, 4, 7, 4, 'Truyện đẹp và buồn, nhiều hình ảnh rất ám ảnh.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(55, 4, 14, 5, 'Đọc xong thấy thương Mị vô cùng.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(56, 4, 20, 4, 'Giọng văn mộc mạc, gần gũi.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(57, 5, 9, 5, 'Một kiệt tác thực sự, Nam Cao viết quá đỉnh.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(58, 5, 11, 4, 'Buồn nhưng có chiều sâu, đọc xong cứ nghĩ mãi.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58'),
(59, 5, 16, 4, 'Phần mô tả tâm lý nhân vật rất hay.', 0, 1, '2025-12-07 02:37:58', '2025-12-07 02:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'default-avatar.png',
  `role` enum('admin','customer') DEFAULT 'customer',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `full_name`, `gender`, `birthday`, `phone`, `address`, `avatar`, `role`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'admin1', 'admin1@bookstore.com', '$2y$10$rl2sRlKeCNuvmVOW8yrxFeoTgxV4/kcBtuQAz813C0oxHtEiMdJES', 'Quản Trị Viên', 'male', '1990-06-11', '0909000000', 'Văn phòng Nhà sách Sài Gòn', 'default-avatar.png', 'admin', 1, '2025-11-05 00:50:00', '2025-12-07 02:37:58'),
(2, 'admin2', 'admin2@bookstore.com', '$2y$10$W6WYL155rub9Ll076Wo6m.ZnycM8.c9jj4w328tktF2Tk2OaObjyS', 'Quản Trị Viên', 'female', '1995-01-01', '0909000001', 'Văn phòng Nhà sách Hà Nội', 'default-avatar.png', 'admin', 1, '2025-11-05 00:36:45', '2025-12-07 02:37:58'),
(3, 'khachhang1', 'khach1@gmail.com', '$2y$10$qNGTXqNTdti5j4GyWXELae3DzbIulvAqEVMuvXD6BjnsvJCfGQ3bu', 'Nguyễn Văn Mua', 'male', '1995-05-15', '0912345678', '123 Đường Láng, Hà Nội', 'khachhang1.jpg', 'customer', 1, '2025-11-06 00:00:02', '2025-12-08 02:53:33'),
(4, 'khachhang2', 'khach2@gmail.com', '$2y$10$ZmFljbiHMMd0J88OYV9kaesvEOyNTsl.nAxVSKiuuIj.T04CDq5zu', 'Trần Thị Bán', 'female', '1992-08-20', '0987654321', '456 Lê Lợi, TP.HCM', 'avatar_4_1765161618.png', 'customer', 1, '2025-11-07 04:23:56', '2025-12-08 02:40:18'),
(5, 'khachhang3', 'khach3@gmail.com', '$2y$10$Q1jF7zPjW5Vn8tr2J9x0de8ZqUK7brB7L9ghJFXuC2E8WnZpTfYDu', 'Lê Minh Tân', 'male', '1990-03-12', '0901122334', '12 Hai Bà Trưng, Hà Nội', 'default-avatar.png', 'customer', 1, '2025-11-08 02:12:45', '2025-12-07 02:37:58'),
(6, 'khachhang4', 'khach4@gmail.com', '$2y$10$QnT8P2VtL1Gkz5cMuJw4ue7Ft4JGAgs2pY0dJ5R8w2mOMQEzFvY2m', 'Phạm Thảo Vy', 'female', '1998-11-25', '0938123456', '88 Nguyễn Huệ, Đà Nẵng', 'default-avatar.png', 'customer', 1, '2025-11-08 07:33:21', '2025-12-07 02:37:58'),
(7, 'khachhang5', 'khach5@gmail.com', '$2y$10$uC3TyhG2zN0OjYtX1vDkRe3qS9WbqA98oS7ucRJQeC9/GZq2Yp0v.', 'Nguyễn Quốc Hùng', 'male', '1989-01-20', '0919223344', '23 Trần Phú, Hải Phòng', 'default-avatar.png', 'customer', 1, '2025-11-09 03:45:03', '2025-12-07 02:37:58'),
(8, 'khachhang6', 'khach6@gmail.com', '$2y$10$kG8tX0pBzMDuIY9UL7rHmuxj8Yx5pTwnb9Otu9nfgmWBxEsgz8s5G', 'Lâm Thu Hà', 'female', '1997-04-18', '0971556677', '55 Lạch Tray, Hải Phòng', 'default-avatar.png', 'customer', 1, '2025-11-10 09:12:27', '2025-12-07 02:37:58'),
(9, 'khachhang7', 'khach7@gmail.com', '$2y$10$gF4iUe3PzJTcDk1Nx6H0TezFvV7f4GtV1Rz1W09sBZL8RJmYBf2gW', 'Trần Bảo Long', 'male', '1994-07-09', '0922345567', '101 Võ Thị Sáu, TP.HCM', 'default-avatar.png', 'customer', 1, '2025-11-11 04:59:41', '2025-12-07 02:37:58'),
(10, 'khachhang8', 'khach8@gmail.com', '$2y$10$wH6Ne3LqPj8GJ1xFt2CdP.m6XqV0YtMzAuKT.MuJeiC6uW0m.zcxy', 'Võ Thị Kim Anh', 'female', '1999-10-12', '0934778899', '78 Bạch Đằng, Đà Nẵng', 'default-avatar.png', 'customer', 1, '2025-11-12 01:32:10', '2025-12-07 02:37:58'),
(11, 'khachhang9', 'khach9@gmail.com', '$2y$10$eR1NmKp7TtO8qS2RQ9b01uBg0eP6lFw7rOBe2zWZ8t02L4S0uqjXW', 'Phùng Đức Hải', 'male', '1988-02-22', '0908776655', '66 Nguyễn Trãi, Hà Nội', 'default-avatar.png', 'customer', 1, '2025-11-12 12:20:54', '2025-12-07 02:37:58'),
(12, 'khachhang10', 'khach10@gmail.com', '$2y$10$S1EoG3cJH0mRrU9eZJz34Oap7pDgV4hEJ5btKe4fO3.A3ryq3kLSq', 'Đỗ Ngọc Hân', 'female', '1996-06-01', '0975551122', '09 Lý Tự Trọng, Cần Thơ', 'default-avatar.png', 'customer', 1, '2025-11-13 00:14:03', '2025-12-07 02:37:58'),
(13, 'khachhang11', 'khach11@gmail.com', '$2y$10$Pq1Oe5MkHf9uZdY3W3Dqcu7nAfZ2cQ0bXM4sVJtWmQ0eEe/ZVPhXi', 'Hoàng Anh Tuấn', 'male', '1993-12-14', '0913112244', '44 Lê Duẩn, Hà Nội', 'default-avatar.png', 'customer', 1, '2025-11-14 05:55:19', '2025-12-07 02:37:58'),
(14, 'khachhang12', 'khach12@gmail.com', '$2y$10$Kp2Fe1TcRz5oN8BNkq6Jg.y1QfYgkN4sN8fV7OyA6c5s7dqkRm6Y.', 'Nguyễn Phương Linh', 'female', '1991-09-01', '0948667788', '102 Lê Lợi, Huế', 'default-avatar.png', 'customer', 1, '2025-11-15 02:22:45', '2025-12-07 02:37:58'),
(15, 'khachhang13', 'khach13@gmail.com', '$2y$10$dN0Oe3GmJt4R5g8WZ1hC0u.4pEwCw0sH4TgQkIdOa3hR8S5mQ7e1m', 'Trịnh Nhật Huy', 'male', '1987-05-28', '0935446677', '200 Bình Long, TP.HCM', 'default-avatar.png', 'customer', 1, '2025-11-16 11:11:33', '2025-12-07 02:37:58'),
(16, 'khachhang14', 'khach14@gmail.com', '$2y$10$Zc9Ln2KpRr5IuX7sDmGQxO6Qd2dN1uEy9QmD2nB2kOmQO2fQOc5rW', 'Vũ Thị Bích', 'female', '1995-03-03', '0902334456', '77 CMT8, TP.HCM', 'default-avatar.png', 'customer', 1, '2025-11-17 08:33:12', '2025-12-07 02:37:58'),
(17, 'khachhang15', 'khach15@gmail.com', '$2y$10$Tf4Jn9NkAq2Fs8LdV5tC2u1XgJdE8sQk0GvOeZzGdX1oT7VfYjJ3W', 'Phan Minh Nhật', 'male', '1990-08-17', '0968223344', '35 Trường Chinh, Đà Nẵng', 'default-avatar.png', 'customer', 1, '2025-11-18 03:05:55', '2025-12-07 02:37:58'),
(18, 'khachhang16', 'khach16@gmail.com', '$2y$10$Ro1Fv8TnEp9Zq3LuD3xP7uAqGDaN5wG0uT1sBlcFvHfM2rQZP8FQ2', 'Đinh Thị Yến Nhi', 'female', '1998-12-09', '0945998877', '12 Nguyễn Kiệm, TP.HCM', 'default-avatar.png', 'customer', 1, '2025-11-19 14:48:02', '2025-12-07 02:37:58'),
(19, 'khachhang17', 'khach17@gmail.com', '$2y$10$aE4Zk0BcFt2Jn5SpQw8UCe5N8WgPpE2oA9qLrSsMnFyG3BuNfT7sG', 'Trần Gia Khánh', 'male', '1992-11-11', '0907445566', '81 Điện Biên Phủ, Hà Nội', 'default-avatar.png', 'customer', 1, '2025-11-20 06:29:41', '2025-12-07 02:37:58'),
(20, 'khachhang18', 'khach18@gmail.com', '$2y$10$Mq8Co2HxQf7Nd8OeXz9vGd1HpT1pE9wUq4GwYdGkRrJ0tFyPqM3Cu', 'Hà Thúy An', 'female', '1999-07-23', '0974001122', '50 Nguyễn Du, Hà Nội', 'default-avatar.png', 'customer', 1, '2025-11-21 01:17:30', '2025-12-07 02:37:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`author_id`),
  ADD KEY `idx_name` (`author_name`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD KEY `publisher_id` (`publisher_id`),
  ADD KEY `idx_title` (`title`),
  ADD KEY `idx_price` (`price`),
  ADD KEY `idx_category` (`category_id`),
  ADD KEY `idx_author` (`author_id`),
  ADD KEY `idx_isbn` (`isbn`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`coupon_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_order_number` (`order_number`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_order_date` (`order_date`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `idx_order` (`order_id`),
  ADD KEY `idx_book` (`book_id`);

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`publisher_id`),
  ADD KEY `idx_name` (`publisher_name`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `idx_book` (`book_id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_rating` (`rating`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
  MODIFY `publisher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `authors` (`author_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`publisher_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `books_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
