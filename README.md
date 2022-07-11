# IS207.M22.TMCL
<h1 align="center">Phát triển ứng dụng web</h1>

<div align="center">
     <h3>XÂY DỰNG WEBSITE BÁN HÀNG MỸ PHẨM</h3>
</div>

<table align="center">
 <tr>
  <th>MSSV</th>
  <th>Họ và tên</th>
  <th>Github</th>
  <th>Email</th>
 </tr>
 <tr align="center">
  <td>19521332</td>
  <td>Lê Thành Đạt</td>
  <td><a href="https://github.com/ledat1205">ledat1205<a></td>
  <td><a href="19521332@gmail.uit.edu.vn">19521332@gmail.uit.edu.vn<a></td>
 </tr>
 <tr align="center">
  <td>19521332</td>
  <td>Vũ Tuấn Anh</td>
  <td><a href="https://github.com/TuanAnhlewlew">TuanAnhlewlew<a></td>
  <td><a href="19521228@gmail.uit.edu.vn">19521228@gmail.uit.edu.vn<a></td>
 </tr>
 <tr align="center">
  <td>19520008</td>
  <td>Cao Tuấn Anh</td>
  <td><a href="https://github.com/tuananh2604">tuananh2604<a></td>
  <td><a href="1950008@gmail.uit.edu.vn">1950008@gmail.uit.edu.vn<a></td>
 </tr>
</table>

<h3 align="center">CÁC BƯỚC CÀI ĐẶT VÀ CHẠY SOURCE CODE</h3>
<ins>Bước 1:</ins> Tải và cài đặt </br>
1. Cài đặt xampp </br>
2. Tải file source.zip và extract  </br>
3. Sau khi giải nén xong di chuyển folder Ecommerce vào folder htdocs của xampp  </br>
</br>
<ins>Bước 2:</ins> Tạo cơ sở dữ liêu </br>
1. Copy SQL statement trong file <i>create_DB.txt</i></br>
2. Mở xampp control panel</br>
3. Start Apache và MySQL </br>
4. Mở trình duyệt và truy cập <i>https://localhost/phpmyadmin</i></br>
5. Tạo 1 database mới có tên "<i>ecommerceapp</i>"</br>
6. Vào tab SQL của database mới tạo</br>
7. Paste SQL statement và ấn Go</br>
</br>
<ins>Bước 3:</ins> Thay đổi phí shipping (tùy chọn, mặc định 25k) </br>
1. Mở file config/constants.php </br>
2. Thay đổi giá trị phí shipping của biến "shipping"</br>
</br>
<ins>Bước 4:</ins> Thay đổi phí shipping (tùy chọn, mặc định 25k) </br>
1. Sau khi khởi tạo xong các bước trên truy cập trang web với đường dẫn <i>https://localhost/ecommerce</i></br>
2. Vì trang web mới khởi tạo nên chưa có sản phẩm, phải thêm sản phẩm trong trang quản trị với tài khoản admin (email : admin@admin.com, password: admin)
<p align="right">(<a href="#top">back to top</a>)</p>
