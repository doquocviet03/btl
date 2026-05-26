<?php

namespace Database\Seeders;

use App\Models\BaiViet;
use App\Models\CuaHang;
use App\Models\DanhMucDichVu;
use App\Models\DichVu;
use App\Models\KhachHang;
use App\Models\LichLamViecTho;
use App\Models\SanPham;
use App\Models\TaiKhoan;
use App\Models\ThoCatToc;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = TaiKhoan::updateOrCreate(
            ['email' => 'admin@barber.test'],
            [
                'ho_ten' => 'Quản trị viên',
                'mat_khau' => Hash::make('12345678'),
                'so_dien_thoai' => '0900000000',
                'vai_tro' => 'admin',
                'trang_thai' => 1,
                'email_verified_at' => now(),
            ]
        );

        $khachTaiKhoan = TaiKhoan::updateOrCreate(
            ['email' => 'khachhang@barber.test'],
            [
                'ho_ten' => 'Nguyễn Văn Khách',
                'mat_khau' => Hash::make('12345678'),
                'so_dien_thoai' => '0911111111',
                'vai_tro' => 'khach_hang',
                'trang_thai' => 1,
                'email_verified_at' => now(),
            ]
        );

        KhachHang::updateOrCreate(
            ['tai_khoan_id' => $khachTaiKhoan->id],
            [
                'ho_ten' => $khachTaiKhoan->ho_ten,
                'so_dien_thoai' => $khachTaiKhoan->so_dien_thoai,
                'email' => $khachTaiKhoan->email,
                'gioi_tinh' => 'nam',
                'dia_chi' => 'Hà Nội',
                'trang_thai' => 1,
            ]
        );

        $catToc = DanhMucDichVu::updateOrCreate(
            ['ten_danh_muc' => 'Cắt tóc'],
            [
                'mo_ta' => 'Các dịch vụ cắt tóc nam cơ bản và nâng cao.',
                'trang_thai' => 1,
            ]
        );

        $chamSoc = DanhMucDichVu::updateOrCreate(
            ['ten_danh_muc' => 'Chăm sóc tóc'],
            [
                'mo_ta' => 'Gội, massage, hấp dưỡng và chăm sóc da đầu.',
                'trang_thai' => 1,
            ]
        );

        $hoaChat = DanhMucDichVu::updateOrCreate(
            ['ten_danh_muc' => 'Uốn nhuộm'],
            [
                'mo_ta' => 'Các dịch vụ uốn, nhuộm và tạo kiểu.',
                'trang_thai' => 1,
            ]
        );

        $dichVuData = [
            [
                'danh_muc_id' => $catToc->id,
                'ten_dich_vu' => 'Cắt tóc nam cơ bản',
                'gia' => 70000,
                'thoi_gian' => 30,
                'mo_ta' => 'Cắt tóc theo form gọn gàng, phù hợp đi học và đi làm.',
            ],
            [
                'danh_muc_id' => $catToc->id,
                'ten_dich_vu' => 'Cắt tóc tạo kiểu',
                'gia' => 120000,
                'thoi_gian' => 45,
                'mo_ta' => 'Tư vấn và cắt theo phong cách cá nhân.',
            ],
            [
                'danh_muc_id' => $chamSoc->id,
                'ten_dich_vu' => 'Gội đầu massage',
                'gia' => 80000,
                'thoi_gian' => 30,
                'mo_ta' => 'Gội sạch sâu kết hợp massage thư giãn.',
            ],
            [
                'danh_muc_id' => $chamSoc->id,
                'ten_dich_vu' => 'Hấp dưỡng tóc',
                'gia' => 150000,
                'thoi_gian' => 45,
                'mo_ta' => 'Phục hồi tóc khô xơ, hư tổn nhẹ.',
            ],
            [
                'danh_muc_id' => $hoaChat->id,
                'ten_dich_vu' => 'Nhuộm tóc nam',
                'gia' => 350000,
                'thoi_gian' => 120,
                'mo_ta' => 'Nhuộm màu thời trang, tư vấn màu phù hợp.',
            ],
            [
                'danh_muc_id' => $hoaChat->id,
                'ten_dich_vu' => 'Uốn tóc nam',
                'gia' => 450000,
                'thoi_gian' => 150,
                'mo_ta' => 'Uốn form tự nhiên, giữ nếp tốt.',
            ],
        ];

        foreach ($dichVuData as $data) {
            DichVu::updateOrCreate(
                ['ten_dich_vu' => $data['ten_dich_vu']],
                $data + [
                    'hinh_anh' => null,
                    'trang_thai' => 1,
                ]
            );
        }



        $sanPhamData = [
            ['ten_san_pham' => 'Pomade Matte Clay Barber House', 'thuong_hieu' => 'Barber House', 'loai_san_pham' => 'tao_kieu', 'gia' => 220000, 'gia_khuyen_mai' => 189000, 'so_luong_ton' => 80, 'dung_tich' => '100g', 'mo_ta_ngan' => 'Sáp vuốt tóc giữ nếp tự nhiên, finish lì, hợp tóc nam Việt Nam.', 'noi_bat' => 1],
            ['ten_san_pham' => 'Dầu gội sạch sâu da đầu bạc hà', 'thuong_hieu' => 'Barber House', 'loai_san_pham' => 'cham_soc_da_dau', 'gia' => 180000, 'gia_khuyen_mai' => null, 'so_luong_ton' => 120, 'dung_tich' => '300ml', 'mo_ta_ngan' => 'Làm sạch dầu thừa, tạo cảm giác mát và giảm bết tóc.', 'noi_bat' => 1],
            ['ten_san_pham' => 'Tinh dầu dưỡng tóc phục hồi', 'thuong_hieu' => 'Care Lab', 'loai_san_pham' => 'cham_soc_toc', 'gia' => 260000, 'gia_khuyen_mai' => 239000, 'so_luong_ton' => 65, 'dung_tich' => '80ml', 'mo_ta_ngan' => 'Dưỡng tóc khô xơ, giảm rối, tạo độ bóng vừa phải.', 'noi_bat' => 1],
            ['ten_san_pham' => 'Xịt tạo phồng tóc nam Volume Spray', 'thuong_hieu' => 'Urban Barber', 'loai_san_pham' => 'tao_kieu', 'gia' => 195000, 'gia_khuyen_mai' => null, 'so_luong_ton' => 72, 'dung_tich' => '150ml', 'mo_ta_ngan' => 'Tạo độ phồng trước khi sấy, giữ form tóc cả ngày.', 'noi_bat' => 0],
            ['ten_san_pham' => 'Combo chăm sóc tóc sạch sâu', 'thuong_hieu' => 'Barber House', 'loai_san_pham' => 'combo', 'gia' => 420000, 'gia_khuyen_mai' => 359000, 'so_luong_ton' => 40, 'dung_tich' => '2 sản phẩm', 'mo_ta_ngan' => 'Combo dầu gội bạc hà và tinh dầu dưỡng cho tóc khỏe hơn.', 'noi_bat' => 1],
            ['ten_san_pham' => 'Lược tạo kiểu carbon chống tĩnh điện', 'thuong_hieu' => 'Pro Comb', 'loai_san_pham' => 'tao_kieu', 'gia' => 90000, 'gia_khuyen_mai' => null, 'so_luong_ton' => 150, 'dung_tich' => '1 chiếc', 'mo_ta_ngan' => 'Lược nhẹ, chắc, phù hợp sấy tạo kiểu tại nhà.', 'noi_bat' => 0],
        ];

        foreach ($sanPhamData as $data) {
            SanPham::updateOrCreate(
                ['slug' => Str::slug($data['ten_san_pham'])],
                $data + [
                    'hinh_anh' => null,
                    'mo_ta_chi_tiet' => ($data['mo_ta_ngan'] ?? '') . "\n\nHướng dẫn dùng: lấy lượng vừa đủ, thoa đều lên tóc hoặc da đầu theo hướng dẫn của sản phẩm. Bảo quản nơi khô ráo, tránh ánh nắng trực tiếp.",
                    'trang_thai' => 1,
                ]
            );
        }

        $baiVietData = [
            ['tieu_de' => '5 kiểu tóc nam dễ chăm sóc cho người bận rộn', 'tom_tat' => 'Gợi ý các kiểu tóc gọn, dễ giữ form và phù hợp đi học, đi làm.', 'noi_dung' => 'Một kiểu tóc tốt không chỉ đẹp khi rời tiệm mà còn phải dễ chăm sóc tại nhà. Những lựa chọn như side part gọn, layer tự nhiên, crop ngắn hoặc classic fade đều phù hợp với người bận rộn. Khi đặt lịch, bạn nên nói rõ chất tóc, môi trường làm việc và thời gian có thể chăm sóc tóc mỗi ngày để thợ tư vấn chuẩn hơn.'],
            ['tieu_de' => 'Cách chọn sáp vuốt tóc theo chất tóc', 'tom_tat' => 'Tóc mỏng, tóc dày, tóc dầu nên dùng sản phẩm tạo kiểu khác nhau.', 'noi_dung' => 'Nếu tóc mỏng, hãy ưu tiên sản phẩm nhẹ và có khả năng tạo phồng. Nếu tóc dày, clay hoặc paste giữ nếp cao sẽ phù hợp hơn. Với tóc dầu, nên chọn finish lì để tóc không bị bóng bết. Không nên dùng quá nhiều sản phẩm trong một lần vì sẽ làm tóc nặng và khó gội sạch.'],
            ['tieu_de' => 'Lịch chăm sóc da đầu cho nam giới', 'tom_tat' => 'Da đầu khỏe giúp tóc sạch, ít bết và dễ tạo kiểu hơn.', 'noi_dung' => 'Da đầu cũng cần chăm sóc giống như da mặt. Hãy gội đầu đều đặn, massage nhẹ khi gội và hạn chế nước quá nóng. Nếu thường xuyên dùng sáp, bạn nên có một buổi làm sạch sâu mỗi tuần tại salon hoặc dùng dầu gội phù hợp để hạn chế tích tụ sản phẩm.'],
        ];

        foreach ($baiVietData as $data) {
            BaiViet::updateOrCreate(
                ['slug' => Str::slug($data['tieu_de'])],
                $data + [
                    'anh_dai_dien' => null,
                    'tac_gia' => 'Barber House',
                    'trang_thai' => 1,
                    'xuat_ban_luc' => now(),
                ]
            );
        }

        $cuaHangData = [
            ['ten_cua_hang' => 'Barber House Hoàn Kiếm', 'thanh_pho' => 'Hà Nội', 'dia_chi' => '24 Tràng Tiền, Hoàn Kiếm, Hà Nội', 'so_dien_thoai' => '0900000001', 'email' => 'hoankiem@barber.test', 'mo_ta' => 'Chi nhánh trung tâm, thuận tiện đặt lịch sau giờ làm.'],
            ['ten_cua_hang' => 'Barber House Cầu Giấy', 'thanh_pho' => 'Hà Nội', 'dia_chi' => '88 Xuân Thủy, Cầu Giấy, Hà Nội', 'so_dien_thoai' => '0900000002', 'email' => 'caugiay@barber.test', 'mo_ta' => 'Không gian trẻ trung, nhiều thợ chuyên fade và layer.'],
            ['ten_cua_hang' => 'Barber House Quận 1', 'thanh_pho' => 'TP. Hồ Chí Minh', 'dia_chi' => '12 Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh', 'so_dien_thoai' => '0900000003', 'email' => 'quan1@barber.test', 'mo_ta' => 'Chi nhánh flagship tại TP. Hồ Chí Minh.'],
            ['ten_cua_hang' => 'Barber House Hải Châu', 'thanh_pho' => 'Đà Nẵng', 'dia_chi' => '35 Bạch Đằng, Hải Châu, Đà Nẵng', 'so_dien_thoai' => '0900000004', 'email' => 'danang@barber.test', 'mo_ta' => 'Không gian thoáng, phù hợp khách du lịch và dân văn phòng.'],
        ];

        foreach ($cuaHangData as $data) {
            CuaHang::updateOrCreate(
                ['slug' => Str::slug($data['ten_cua_hang'])],
                $data + [
                    'gio_mo_cua' => '08:00 - 18:00',
                    'ban_do_url' => null,
                    'hinh_anh' => null,
                    'trang_thai' => 1,
                ]
            );
        }

        $thoData = [
            [
                'ho_ten' => 'Trần Minh Quân',
                'email' => 'quan.barber@test.local',
                'so_dien_thoai' => '0922222222',
                'kinh_nghiem' => 5,
                'chuyen_mon' => 'Fade, layer, tạo kiểu nam',
                'mo_ta' => 'Thợ chính chuyên các kiểu tóc trẻ trung.',
            ],
            [
                'ho_ten' => 'Lê Hoàng Nam',
                'email' => 'nam.barber@test.local',
                'so_dien_thoai' => '0933333333',
                'kinh_nghiem' => 3,
                'chuyen_mon' => 'Uốn, nhuộm, tư vấn phong cách',
                'mo_ta' => 'Có kinh nghiệm xử lý tóc uốn nhuộm.',
            ],
            [
                'ho_ten' => 'Phạm Đức Anh',
                'email' => 'anh.barber@test.local',
                'so_dien_thoai' => '0944444444',
                'kinh_nghiem' => 4,
                'chuyen_mon' => 'Cắt tóc công sở, classic',
                'mo_ta' => 'Phong cách gọn gàng, lịch sự.',
            ],
        ];

        $thoCatToc = collect();

        foreach ($thoData as $data) {
            $taiKhoanTho = TaiKhoan::updateOrCreate(
                ['email' => $data['email']],
                [
                    'ho_ten' => $data['ho_ten'],
                    'mat_khau' => Hash::make('12345678'),
                    'so_dien_thoai' => $data['so_dien_thoai'],
                    'vai_tro' => 'tho',
                    'trang_thai' => 1,
                    'email_verified_at' => now(),
                ]
            );

            $tho = ThoCatToc::updateOrCreate(
                ['tai_khoan_id' => $taiKhoanTho->id],
                [
                    'ho_ten' => $data['ho_ten'],
                    'email' => $data['email'],
                    'so_dien_thoai' => $data['so_dien_thoai'],
                    'kinh_nghiem' => $data['kinh_nghiem'],
                    'chuyen_mon' => $data['chuyen_mon'],
                    'anh_dai_dien' => null,
                    'mo_ta' => $data['mo_ta'],
                    'trang_thai' => 1,
                ]
            );

            $thoCatToc->push($tho);
        }

        foreach ($thoCatToc as $tho) {
            for ($i = 0; $i < 14; $i++) {
                $ngayLam = now()->addDays($i)->toDateString();

                LichLamViecTho::updateOrCreate(
                    [
                        'tho_id' => $tho->id,
                        'ngay_lam' => $ngayLam,
                    ],
                    [
                        'ca_lam' => 'ca_ngay',
                        'gio_bat_dau' => '08:00:00',
                        'gio_ket_thuc' => '17:30:00',
                        'trang_thai' => 1,
                        'ghi_chu' => null,
                    ]
                );
            }
        }
    }
}
