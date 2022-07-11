## CÀI ĐẶT TRANG WEB
### Tải và cài đặt
1. Cài đặt xampp
2. Tải file source.zip và extract 
3. Sau khi giải nén xong di chuyển folder Ecommerce vào folder htdocs của xampp
### Tạo cơ sở dữ liệu
1. Copy Sql statement trong file create_DB.txt
2. Mở xampp control panel
3. Start Apache và MySQL 
4. Mở trình duyệt và truy cập [https://localhost/phpmyadmin](https://localhost/phpmyadmin)
5. Tạo 1 database mới có tên "ecommerceapp"
6. Vào tab SQL của database mới tạo
7. Paste Sql statement và ấn Go
### Thay đổi phí shipping (tùy chọn, mặc định 25k)
1. Mở file config/constants.php
2. Thay đổi giá trị phí shipping của biến "shipping"
### Truy cập trang web
1. Sau khi khởi tạo xong các bước trên truy cập trang web với đường dẫn [https://localhost/ecommerce](https://localhost/ecommerce)
2. Vì trang web mới khởi tạo nên chưa có sản phẩm, phải thêm sản phẩm trong trang quản trị với tài khoản admin (email : admin@admin.com, password: admin)