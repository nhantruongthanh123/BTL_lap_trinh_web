# 📚 Bookstore - Website Bán Sách Trực Tuyến

> **Assignment:** Lập trình Web  
> **Công nghệ:** PHP Thuần (MVC) + MySQL + Bootstrap 5

### 📖 Giới thiệu
**Bookstore** là một nền tảng thương mại điện tử chuyên kinh doanh sách, được xây dựng hoàn toàn bằng **PHP thuần** theo mô hình kiến trúc **MVC (Model-View-Controller)**. Dự án tập trung vào việc tối ưu hóa trải nghiệm người dùng, quy trình đặt hàng nhanh chóng và hệ thống quản trị trực quan.

## ⚙️ Hướng dẫn Cài đặt & Triển khai

Để chạy dự án này trên máy cá nhân (Localhost), vui lòng thực hiện theo các bước sau:

### 1. Yêu cầu hệ thống (Prerequisites)
Trước khi cài đặt, đảm bảo máy tính của bạn đã có:
* **XAMPP**: Có sẵn PHP (phiên bản >= 7.4) và MySQL.
* **Git**: Để tải mã nguồn (hoặc có thể tải file ZIP).
* **Trình duyệt web**: Chrome, Edge, Firefox...

### 2. Tải mã nguồn (Clone Source Code)
- Di chuyển vào thư mục gốc của server (thường là `htdocs` trong XAMPP) và tải dự án về:

```bash
# Di chuyển vào thư mục htdocs
# Clone dự án 
git clone https://github.com/nhantruongthanh123/BTL_lap_trinh_web
```

- Đổi tên thư mục từ BTL_lap_trinh_web thành Bookstore (hoặc bookstore)

### 3. Import database lên server
- Bật XAMPP và khởi động Apache và MySQL
- Mở admin ở MySQL để khởi động http://localhost/phpmyadmin/
- Import lần lượt ở thư mục Bookstore/Database hai file bookstore_db để gửi dữ liệu lên server
- Khi này sẽ xuất hiện bảng bookstore_db lưu dữ liệu của dự án

### 4. Truy cập web
- Truy cập trang web với đường dẫn http://localhost/bookstore/
- Tại đây, người dùng có thể thử các tính năng như tạo tài khoản, đổi avatar, đặt sách,..
- Khách hàng: Username: khachhang1  ---  password: 123456
- Admin : Username: admin1   ---  password: 123123


