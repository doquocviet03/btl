# Barber House - Laravel Booking + Shop

Dự án website quản lý tiệm cắt tóc bằng Laravel Blade, Tailwind CSS và Alpine.js.

## 1. Công nghệ sử dụng

- Laravel 12
- Laravel Blade theo mô hình MVC
- Tailwind CSS
- Alpine.js cho dropdown, menu mobile, form tương tác nhẹ
- Vite để build CSS/JS
- MySQL

Dự án vẫn giữ kiểu Laravel truyền thống:

```txt
Route -> Controller -> Model -> Blade View
```

Không dùng React/Vue để tránh phá cấu trúc MVC hiện tại.

## 2. Database mặc định

File `.env` đang cấu hình sẵn:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quan_ly_cat_toc_moi
DB_USERNAME=root
DB_PASSWORD=
```

Tạo database trong MySQL/phpMyAdmin:

```sql
CREATE DATABASE quan_ly_cat_toc_moi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## 3. Cách chạy dự án

```bash
composer install
npm install
php artisan key:generate
php artisan migrate:fresh --seed
npm run dev
php artisan serve
```

Nếu bị cache route/view/config:

```bash
php artisan optimize:clear
php artisan route:clear
php artisan view:clear
php artisan config:clear
```

## 4. Tài khoản mẫu

Admin:

```txt
Email: admin@barber.test
Password: 12345678
```

Khách hàng:

```txt
Email: khachhang@barber.test
Password: 12345678
```

Tài khoản thợ mẫu:

```txt
quan.barber@test.local / 12345678
nam.barber@test.local / 12345678
anh.barber@test.local / 12345678
```

## 5. Chức năng user

- Trang chủ
- Xem dịch vụ
- Xem chi tiết dịch vụ
- Xem danh sách thợ cắt tóc
- Xem chi tiết thợ
- Đặt lịch
- Xem lịch của tôi
- Hủy lịch hẹn
- Gửi thông tin thanh toán
- Đánh giá sau khi lịch hẹn hoàn thành
- Xem lịch sử đánh giá
- Xem blog chăm sóc tóc
- Xem hệ thống cửa hàng tại Việt Nam
- Xem sản phẩm chăm sóc tóc/da đầu
- Thêm sản phẩm vào giỏ hàng
- Cập nhật số lượng giỏ hàng
- Xóa sản phẩm khỏi giỏ hàng
- Đặt đơn hàng sản phẩm

## 6. Chức năng admin

- Dashboard quản trị
- Quản lý khách hàng
- Quản lý thợ cắt tóc
- Quản lý danh mục dịch vụ
- Quản lý dịch vụ
- Quản lý lịch hẹn
- Quản lý thanh toán
- Quản lý lịch làm việc thợ
- Quản lý tài khoản
- Quản lý đánh giá
- Quản lý sản phẩm chăm sóc tóc
- Quản lý đơn hàng sản phẩm

## 7. Bảng database chính

```txt
tai_khoan
khach_hang
tho_cat_toc
danh_muc_dich_vu
dich_vu
lich_lam_viec_tho
lich_hen
chi_tiet_lich_hen
thanh_toan
danh_gia
san_pham
don_hang
chi_tiet_don_hang
bai_viet
cua_hang
thong_bao
```

## 8. Cấu trúc MVC chính

Controller admin:

```txt
app/Http/Controllers/Admin/DashboardController.php
app/Http/Controllers/Admin/LichHenController.php
app/Http/Controllers/Admin/ThanhToanController.php
app/Http/Controllers/Admin/DanhGiaController.php
app/Http/Controllers/Admin/SanPhamController.php
app/Http/Controllers/Admin/DonHangController.php
```

Controller user/public:

```txt
app/Http/Controllers/PublicSite/BookingController.php
app/Http/Controllers/PublicSite/ShopController.php
```

Model chính:

```txt
app/Models/TaiKhoan.php
app/Models/KhachHang.php
app/Models/ThoCatToc.php
app/Models/DichVu.php
app/Models/LichHen.php
app/Models/ThanhToan.php
app/Models/DanhGia.php
app/Models/SanPham.php
app/Models/DonHang.php
app/Models/ChiTietDonHang.php
app/Models/BaiViet.php
app/Models/CuaHang.php
```

View user:

```txt
resources/views/user/home
resources/views/user/services
resources/views/user/barbers
resources/views/user/booking
resources/views/user/payment
resources/views/user/review
resources/views/user/shop
resources/views/user/cart
resources/views/user/blog
resources/views/user/stores
```

View admin:

```txt
resources/views/admin/dashboard
resources/views/admin/lich_hen
resources/views/admin/thanh_toan
resources/views/admin/danh_gia
resources/views/admin/san_pham
resources/views/admin/don_hang
```

## 9. Ghi chú chỉnh UI

Các file UI đã có comment `UI NOTE` để dễ tìm phần cần sửa.

File quan trọng nhất để đổi giao diện tổng thể:

```txt
resources/css/app.css
```

Trong file này có hệ thống class dùng chung:

```txt
.bh-card
.bh-card-soft
.bh-dark-card
.bh-btn-primary
.bh-btn-dark
.bh-btn-light
.bh-input
.bh-table
.bh-chip
```

Đổi màu chủ đạo tại biến CSS:

```css
--brand-orange: #f97316;
--brand-dark: #070a12;
```

Đổi font tại:

```css
--font-main: "Be Vietnam Pro", "Inter", ui-sans-serif, system-ui;
```

Menu user:

```txt
resources/views/user/layouts/navigation.blade.php
resources/views/user/layouts/header.blade.php
```

Menu admin:

```txt
resources/views/admin/layouts/sidebar.blade.php
```

Map trạng thái enum sang tiếng Việt:

```txt
resources/views/components/badge-status.blade.php
```

Nếu sau này thêm trạng thái mới, hãy bổ sung vào file này để không bị hiện dạng `xxx_xxx`.

## 10. Cách test nhanh

1. Chạy migrate fresh seed.
2. Đăng nhập admin.
3. Kiểm tra dashboard.
4. Thêm/sửa dịch vụ.
5. Thêm/sửa thợ.
6. Tạo lịch làm việc.
7. Đăng nhập user.
8. Đặt lịch.
9. Vào admin xác nhận lịch.
10. Admin xác nhận thanh toán.
11. Admin chuyển lịch sang hoàn thành.
12. User vào `Lịch của tôi` và bấm đánh giá.
13. User vào `Sản phẩm`, thêm sản phẩm vào giỏ.
14. User đặt đơn hàng.
15. Admin vào `Đơn hàng` để xử lý.

## 11. Gợi ý nâng cấp tiếp theo

- Upload ảnh thật cho sản phẩm, dịch vụ, thợ.
- Xuất hóa đơn PDF.
- Gửi email xác nhận lịch hẹn/đơn hàng.
- QR chuyển khoản tự động.
- Livewire cho filter realtime trong admin.
- Dashboard có thêm thống kê đơn hàng và sản phẩm bán chạy.

## 10. Thanh toán MoMo QR

Bản này có 2 chế độ MoMo:

### Chế độ 1: MoMo QR tĩnh, phù hợp demo đồ án

Không cần tài khoản Merchant API. Bạn chỉ cần lấy ảnh QR MoMo thật của cửa hàng/cá nhân, copy vào:

```txt
public/images/momo-qr.png
```

Sau đó sửa `.env`:

```env
MOMO_ENABLED=false
MOMO_STATIC_QR_IMAGE=/images/momo-qr.png
MOMO_RECEIVER_NAME="TEN NGUOI NHAN"
MOMO_RECEIVER_PHONE=09xxxxxxxx
```

Luồng xử lý:

```txt
User quét QR -> nhập đúng số tiền + nội dung -> bấm gửi mã giao dịch/ghi chú -> Admin kiểm tra MoMo -> Admin xác nhận đã thanh toán.
```

### Chế độ 2: MoMo Gateway/Sandbox có IPN tự động

Cần đăng ký MoMo Business/Merchant hoặc sandbox, sau đó điền:

```env
MOMO_ENABLED=true
MOMO_ENV=test
MOMO_ENDPOINT=https://test-payment.momo.vn/v2/gateway/api/create
MOMO_PARTNER_CODE=...
MOMO_ACCESS_KEY=...
MOMO_SECRET_KEY=...
MOMO_REQUEST_TYPE=captureWallet
```

Luồng xử lý:

```txt
User bấm Thanh toán qua MoMo -> Laravel tạo giao dịch -> chuyển sang MoMo payUrl -> MoMo gửi IPN về /momo/ipn -> hệ thống cập nhật đã thanh toán nếu chữ ký hợp lệ.
```

Khi test localhost, IPN của MoMo không gọi được `127.0.0.1`, nên cần dùng ngrok:

```bash
ngrok http 8000
```

Sau đó sửa `.env`:

```env
APP_URL=https://xxxx.ngrok-free.app
```

Rồi chạy:

```bash
php artisan optimize:clear
```

Các file liên quan MoMo:

```txt
config/momo.php
app/Services/MomoPaymentService.php
app/Http/Controllers/Payment/MomoPaymentController.php
resources/views/user/payment/index.blade.php
resources/views/user/cart/success.blade.php
public/images/momo-qr-placeholder.svg
```

Database đã bổ sung trường MoMo trong:

```txt
thanh_toan
don_hang
```

Nếu đang dùng database cũ, chạy:

```bash
php artisan migrate
```

Nếu muốn tạo lại dữ liệu mẫu từ đầu:

```bash
php artisan migrate:fresh --seed
```

## 11. Thanh toán VNPAY Sandbox + MoMo Demo/Sandbox

Bản V4 bổ sung thêm hướng thanh toán chuyên nghiệp hơn:

```txt
User đặt lịch hoặc đặt hàng
-> chọn VNPAY Sandbox hoặc MoMo Demo/Sandbox
-> Laravel tạo link thanh toán nếu đã cấu hình key
-> VNPAY/MoMo redirect/callback về website
-> hệ thống kiểm tra chữ ký
-> cập nhật trạng thái thanh toán
```

### VNPAY Sandbox

File cấu hình:

```txt
config/vnpay.php
app/Services/VnpayPaymentService.php
app/Http/Controllers/Payment/VnpayPaymentController.php
```

Biến `.env` cần chú ý:

```env
VNPAY_ENABLED=false
VNPAY_ENV=sandbox
VNPAY_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
VNPAY_TMN_CODE=
VNPAY_HASH_SECRET=
VNPAY_VERSION=2.1.0
VNPAY_COMMAND=pay
VNPAY_CURR_CODE=VND
VNPAY_LOCALE=vn
VNPAY_ORDER_TYPE=billpayment
```

Khi có tài khoản sandbox, điền:

```env
VNPAY_ENABLED=true
VNPAY_TMN_CODE=ma_tmn_code_cua_ban
VNPAY_HASH_SECRET=hash_secret_cua_ban
APP_URL=http://127.0.0.1:8000
```

Sau khi sửa `.env`, chạy:

```bash
php artisan optimize:clear
```

Routes VNPAY:

```txt
POST /lich-cua-toi/{lichHen}/thanh-toan/vnpay
POST /vnpay/don-hang/{donHang}/thanh-toan
GET  /vnpay/lich-hen/{lichHen}/ket-qua
GET  /vnpay/don-hang/{donHang}/ket-qua
GET  /vnpay/ipn
```

### MoMo Demo/Sandbox

MoMo vẫn giữ 2 chế độ:

```txt
1. Demo QR tĩnh: MOMO_ENABLED=false, dùng ảnh QR trong public/images.
2. Sandbox/Gateway: MOMO_ENABLED=true và điền PartnerCode/AccessKey/SecretKey.
```

Biến `.env`:

```env
MOMO_ENABLED=false
MOMO_ENDPOINT=https://test-payment.momo.vn/v2/gateway/api/create
MOMO_PARTNER_CODE=
MOMO_ACCESS_KEY=
MOMO_SECRET_KEY=
MOMO_STATIC_QR_IMAGE=/images/momo-qr-placeholder.svg
MOMO_RECEIVER_NAME="BARBER HOUSE"
MOMO_RECEIVER_PHONE=0900000000
```

### Database payment mới

Migration mới:

```txt
database/migrations/2026_05_25_000002_add_vnpay_fields_to_payment_tables.php
```

Bổ sung các cột VNPAY vào:

```txt
thanh_toan
don_hang
```

Nếu đang dùng database cũ, chỉ cần chạy:

```bash
php artisan migrate
php artisan optimize:clear
```

Không cần `migrate:fresh` nếu muốn giữ dữ liệu cũ.

## 12. Giao diện lịch làm việc thợ V4

Trang:

```txt
resources/views/admin/lich_lam_viec_thang/index.blade.php
```

đã được thiết kế lại đồng bộ với UI admin hiện tại:

```txt
- Header card sáng
- Thống kê tổng thợ / đang làm / nghỉ
- Bộ lọc tháng/ngày dạng card
- Bảng dùng .bh-table
- Button dùng .bh-btn-primary/.bh-btn-dark/.bh-btn-light
- Có UI NOTE trong file để dễ sửa sau
```
