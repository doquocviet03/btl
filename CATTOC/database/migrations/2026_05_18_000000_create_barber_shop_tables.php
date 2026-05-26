<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tai_khoan', function (Blueprint $table) {
            $table->id();
            $table->string('ho_ten', 100);
            $table->string('email', 150)->unique();
            $table->string('mat_khau');
            $table->string('so_dien_thoai', 20)->nullable();
            $table->enum('vai_tro', ['admin', 'khach_hang', 'tho'])->default('khach_hang');
            $table->boolean('trang_thai')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('danh_muc_dich_vu', function (Blueprint $table) {
            $table->id();
            $table->string('ten_danh_muc', 100);
            $table->text('mo_ta')->nullable();
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();
        });

        Schema::create('dich_vu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('danh_muc_id')->nullable()->constrained('danh_muc_dich_vu')->nullOnDelete();
            $table->string('ten_dich_vu', 150);
            $table->decimal('gia', 12, 2)->default(0);
            $table->unsignedInteger('thoi_gian');
            $table->text('mo_ta')->nullable();
            $table->string('hinh_anh')->nullable();
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();
        });

        Schema::create('san_pham', function (Blueprint $table) {
            $table->id();
            $table->string('ten_san_pham', 180);
            $table->string('slug', 220)->unique();
            $table->string('thuong_hieu', 120)->nullable();
            $table->enum('loai_san_pham', ['cham_soc_toc', 'cham_soc_da_dau', 'tao_kieu', 'combo'])->default('cham_soc_toc');
            $table->decimal('gia', 12, 2)->default(0);
            $table->decimal('gia_khuyen_mai', 12, 2)->nullable();
            $table->unsignedInteger('so_luong_ton')->default(0);
            $table->string('dung_tich', 80)->nullable();
            $table->string('hinh_anh')->nullable();
            $table->text('mo_ta_ngan')->nullable();
            $table->longText('mo_ta_chi_tiet')->nullable();
            $table->boolean('noi_bat')->default(false);
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();
        });

        Schema::create('khach_hang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tai_khoan_id')->nullable()->unique()->constrained('tai_khoan')->nullOnDelete();
            $table->string('ho_ten', 100);
            $table->string('so_dien_thoai', 20);
            $table->string('email', 150)->nullable();
            $table->enum('gioi_tinh', ['nam', 'nu', 'khac'])->nullable();
            $table->date('ngay_sinh')->nullable();
            $table->string('dia_chi')->nullable();
            $table->text('ghi_chu')->nullable();
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();
        });

        Schema::create('tho_cat_toc', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tai_khoan_id')->nullable()->unique()->constrained('tai_khoan')->nullOnDelete();
            $table->string('ho_ten', 100);
            $table->string('so_dien_thoai', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->unsignedInteger('kinh_nghiem')->default(0);
            $table->string('chuyen_mon')->nullable();
            $table->string('anh_dai_dien')->nullable();
            $table->text('mo_ta')->nullable();
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();
        });

        Schema::create('lich_lam_viec_tho', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tho_id')->constrained('tho_cat_toc')->cascadeOnDelete();
            $table->date('ngay_lam');
            $table->enum('ca_lam', ['sang', 'chieu', 'toi', 'ca_ngay', 'nghi'])->default('ca_ngay');
            $table->time('gio_bat_dau');
            $table->time('gio_ket_thuc');
            $table->boolean('trang_thai')->default(true);
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
            $table->unique(['tho_id', 'ngay_lam']);
        });

        Schema::create('lich_hen', function (Blueprint $table) {
            $table->id();
            $table->string('ma_lich_hen', 50)->unique();
            $table->foreignId('khach_hang_id')->constrained('khach_hang')->cascadeOnDelete();
            $table->foreignId('tho_id')->constrained('tho_cat_toc')->cascadeOnDelete();
            $table->date('ngay_hen');
            $table->time('gio_bat_dau');
            $table->time('gio_ket_thuc');
            $table->decimal('tong_tien', 12, 2)->default(0);
            $table->enum('trang_thai', ['cho_xac_nhan', 'da_xac_nhan', 'dang_thuc_hien', 'hoan_thanh', 'da_huy'])->default('cho_xac_nhan');
            $table->text('ghi_chu')->nullable();
            $table->text('ly_do_huy')->nullable();
            $table->timestamps();
        });

        Schema::create('chi_tiet_lich_hen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lich_hen_id')->constrained('lich_hen')->cascadeOnDelete();
            $table->foreignId('dich_vu_id')->nullable()->constrained('dich_vu')->nullOnDelete();
            $table->string('ten_dich_vu', 150);
            $table->decimal('gia', 12, 2)->default(0);
            $table->unsignedInteger('thoi_gian')->default(0);
            $table->timestamps();
        });

        Schema::create('thanh_toan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lich_hen_id')->unique()->constrained('lich_hen')->cascadeOnDelete();
            $table->string('ma_thanh_toan', 50)->unique();
            $table->decimal('so_tien', 12, 2)->default(0);
            $table->enum('phuong_thuc', ['tien_mat', 'chuyen_khoan', 'vi_dien_tu', 'momo', 'vnpay'])->default('tien_mat');
            $table->enum('trang_thai', ['chua_thanh_toan', 'da_thanh_toan', 'that_bai', 'hoan_tien'])->default('chua_thanh_toan');
            $table->dateTime('ngay_thanh_toan')->nullable();
            $table->text('ghi_chu')->nullable();
            $table->string('momo_order_id', 220)->nullable()->unique();
            $table->string('momo_request_id', 220)->nullable();
            $table->text('momo_pay_url')->nullable();
            $table->text('momo_deeplink')->nullable();
            $table->text('momo_qr_code')->nullable();
            $table->string('momo_trans_id', 120)->nullable();
            $table->integer('momo_result_code')->nullable();
            $table->string('momo_message', 255)->nullable();
            $table->longText('momo_payload')->nullable();
            $table->string('vnpay_txn_ref', 220)->nullable()->unique();
            $table->text('vnpay_payment_url')->nullable();
            $table->string('vnpay_transaction_no', 120)->nullable();
            $table->string('vnpay_response_code', 20)->nullable();
            $table->string('vnpay_transaction_status', 20)->nullable();
            $table->string('vnpay_bank_code', 60)->nullable();
            $table->string('vnpay_pay_date', 30)->nullable();
            $table->longText('vnpay_payload')->nullable();
            $table->timestamps();
        });

        Schema::create('danh_gia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lich_hen_id')->unique()->constrained('lich_hen')->cascadeOnDelete();
            $table->foreignId('khach_hang_id')->constrained('khach_hang')->cascadeOnDelete();
            $table->foreignId('tho_id')->constrained('tho_cat_toc')->cascadeOnDelete();
            $table->unsignedTinyInteger('so_sao');
            $table->text('noi_dung')->nullable();
            $table->enum('trang_thai', ['cho_duyet', 'da_duyet', 'an'])->default('cho_duyet');
            $table->timestamps();
        });

        Schema::create('bai_viet', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de', 220);
            $table->string('slug', 240)->unique();
            $table->string('anh_dai_dien')->nullable();
            $table->string('tom_tat', 500)->nullable();
            $table->longText('noi_dung');
            $table->string('tac_gia', 120)->default('Barber House');
            $table->boolean('trang_thai')->default(true);
            $table->timestamp('xuat_ban_luc')->nullable();
            $table->timestamps();
        });

        Schema::create('cua_hang', function (Blueprint $table) {
            $table->id();
            $table->string('ten_cua_hang', 180);
            $table->string('slug', 220)->unique();
            $table->string('thanh_pho', 120);
            $table->string('dia_chi');
            $table->string('so_dien_thoai', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('gio_mo_cua', 80)->default('08:00 - 18:00');
            $table->string('ban_do_url')->nullable();
            $table->string('hinh_anh')->nullable();
            $table->text('mo_ta')->nullable();
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();
        });

        Schema::create('don_hang', function (Blueprint $table) {
            $table->id();
            $table->string('ma_don_hang', 50)->unique();
            $table->foreignId('khach_hang_id')->nullable()->constrained('khach_hang')->nullOnDelete();
            $table->string('ho_ten', 120);
            $table->string('so_dien_thoai', 20);
            $table->string('email', 150)->nullable();
            $table->string('dia_chi');
            $table->decimal('tong_tien', 12, 2)->default(0);
            $table->enum('phuong_thuc_thanh_toan', ['cod', 'chuyen_khoan', 'momo', 'vnpay'])->default('cod');
            $table->enum('trang_thai', ['cho_xac_nhan', 'dang_chuan_bi', 'dang_giao', 'hoan_thanh', 'da_huy'])->default('cho_xac_nhan');
            $table->enum('trang_thai_thanh_toan', ['chua_thanh_toan', 'dang_cho_xac_nhan', 'da_thanh_toan', 'that_bai', 'hoan_tien'])->default('chua_thanh_toan');
            $table->text('ghi_chu')->nullable();
            $table->string('momo_order_id', 220)->nullable()->unique();
            $table->string('momo_request_id', 220)->nullable();
            $table->text('momo_pay_url')->nullable();
            $table->text('momo_deeplink')->nullable();
            $table->text('momo_qr_code')->nullable();
            $table->string('momo_trans_id', 120)->nullable();
            $table->integer('momo_result_code')->nullable();
            $table->string('momo_message', 255)->nullable();
            $table->longText('momo_payload')->nullable();
            $table->string('vnpay_txn_ref', 220)->nullable()->unique();
            $table->text('vnpay_payment_url')->nullable();
            $table->string('vnpay_transaction_no', 120)->nullable();
            $table->string('vnpay_response_code', 20)->nullable();
            $table->string('vnpay_transaction_status', 20)->nullable();
            $table->string('vnpay_bank_code', 60)->nullable();
            $table->string('vnpay_pay_date', 30)->nullable();
            $table->longText('vnpay_payload')->nullable();
            $table->timestamps();
        });

        Schema::create('chi_tiet_don_hang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('don_hang_id')->constrained('don_hang')->cascadeOnDelete();
            $table->foreignId('san_pham_id')->nullable()->constrained('san_pham')->nullOnDelete();
            $table->string('ten_san_pham', 180);
            $table->decimal('don_gia', 12, 2)->default(0);
            $table->unsignedInteger('so_luong')->default(1);
            $table->decimal('thanh_tien', 12, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('thong_bao', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de', 150);
            $table->text('noi_dung');
            $table->string('loai', 50)->default('he_thong');
            $table->string('lien_ket')->nullable();
            $table->boolean('da_doc')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thong_bao');
        Schema::dropIfExists('chi_tiet_don_hang');
        Schema::dropIfExists('don_hang');
        Schema::dropIfExists('cua_hang');
        Schema::dropIfExists('bai_viet');
        Schema::dropIfExists('danh_gia');
        Schema::dropIfExists('thanh_toan');
        Schema::dropIfExists('chi_tiet_lich_hen');
        Schema::dropIfExists('lich_hen');
        Schema::dropIfExists('lich_lam_viec_tho');
        Schema::dropIfExists('tho_cat_toc');
        Schema::dropIfExists('khach_hang');
        Schema::dropIfExists('san_pham');
        Schema::dropIfExists('dich_vu');
        Schema::dropIfExists('danh_muc_dich_vu');
        Schema::dropIfExists('tai_khoan');
    }
};
