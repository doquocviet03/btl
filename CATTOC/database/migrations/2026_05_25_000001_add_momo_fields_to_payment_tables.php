<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('thanh_toan')) {
            if (DB::getDriverName() === 'mysql') {
                DB::statement("ALTER TABLE thanh_toan MODIFY phuong_thuc ENUM('tien_mat','chuyen_khoan','vi_dien_tu','momo','vnpay') NOT NULL DEFAULT 'tien_mat'");
            }

            Schema::table('thanh_toan', function (Blueprint $table) {
                if (! Schema::hasColumn('thanh_toan', 'momo_order_id')) {
                    $table->string('momo_order_id', 220)->nullable()->unique()->after('ghi_chu');
                }
                if (! Schema::hasColumn('thanh_toan', 'momo_request_id')) {
                    $table->string('momo_request_id', 220)->nullable()->after('momo_order_id');
                }
                if (! Schema::hasColumn('thanh_toan', 'momo_pay_url')) {
                    $table->text('momo_pay_url')->nullable()->after('momo_request_id');
                }
                if (! Schema::hasColumn('thanh_toan', 'momo_deeplink')) {
                    $table->text('momo_deeplink')->nullable()->after('momo_pay_url');
                }
                if (! Schema::hasColumn('thanh_toan', 'momo_qr_code')) {
                    $table->text('momo_qr_code')->nullable()->after('momo_deeplink');
                }
                if (! Schema::hasColumn('thanh_toan', 'momo_trans_id')) {
                    $table->string('momo_trans_id', 120)->nullable()->after('momo_qr_code');
                }
                if (! Schema::hasColumn('thanh_toan', 'momo_result_code')) {
                    $table->integer('momo_result_code')->nullable()->after('momo_trans_id');
                }
                if (! Schema::hasColumn('thanh_toan', 'momo_message')) {
                    $table->string('momo_message', 255)->nullable()->after('momo_result_code');
                }
                if (! Schema::hasColumn('thanh_toan', 'momo_payload')) {
                    $table->longText('momo_payload')->nullable()->after('momo_message');
                }
            });
        }

        if (Schema::hasTable('don_hang')) {
            if (DB::getDriverName() === 'mysql') {
                DB::statement("ALTER TABLE don_hang MODIFY phuong_thuc_thanh_toan ENUM('cod','chuyen_khoan','momo','vnpay') NOT NULL DEFAULT 'cod'");
            }

            Schema::table('don_hang', function (Blueprint $table) {
                if (! Schema::hasColumn('don_hang', 'trang_thai_thanh_toan')) {
                    $table->enum('trang_thai_thanh_toan', ['chua_thanh_toan', 'dang_cho_xac_nhan', 'da_thanh_toan', 'that_bai', 'hoan_tien'])->default('chua_thanh_toan')->after('trang_thai');
                }
                if (! Schema::hasColumn('don_hang', 'momo_order_id')) {
                    $table->string('momo_order_id', 220)->nullable()->unique()->after('ghi_chu');
                }
                if (! Schema::hasColumn('don_hang', 'momo_request_id')) {
                    $table->string('momo_request_id', 220)->nullable()->after('momo_order_id');
                }
                if (! Schema::hasColumn('don_hang', 'momo_pay_url')) {
                    $table->text('momo_pay_url')->nullable()->after('momo_request_id');
                }
                if (! Schema::hasColumn('don_hang', 'momo_deeplink')) {
                    $table->text('momo_deeplink')->nullable()->after('momo_pay_url');
                }
                if (! Schema::hasColumn('don_hang', 'momo_qr_code')) {
                    $table->text('momo_qr_code')->nullable()->after('momo_deeplink');
                }
                if (! Schema::hasColumn('don_hang', 'momo_trans_id')) {
                    $table->string('momo_trans_id', 120)->nullable()->after('momo_qr_code');
                }
                if (! Schema::hasColumn('don_hang', 'momo_result_code')) {
                    $table->integer('momo_result_code')->nullable()->after('momo_trans_id');
                }
                if (! Schema::hasColumn('don_hang', 'momo_message')) {
                    $table->string('momo_message', 255)->nullable()->after('momo_result_code');
                }
                if (! Schema::hasColumn('don_hang', 'momo_payload')) {
                    $table->longText('momo_payload')->nullable()->after('momo_message');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('thanh_toan')) {
            Schema::table('thanh_toan', function (Blueprint $table) {
                foreach (['momo_payload', 'momo_message', 'momo_result_code', 'momo_trans_id', 'momo_qr_code', 'momo_deeplink', 'momo_pay_url', 'momo_request_id', 'momo_order_id'] as $column) {
                    if (Schema::hasColumn('thanh_toan', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('don_hang')) {
            Schema::table('don_hang', function (Blueprint $table) {
                foreach (['momo_payload', 'momo_message', 'momo_result_code', 'momo_trans_id', 'momo_qr_code', 'momo_deeplink', 'momo_pay_url', 'momo_request_id', 'momo_order_id', 'trang_thai_thanh_toan'] as $column) {
                    if (Schema::hasColumn('don_hang', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
