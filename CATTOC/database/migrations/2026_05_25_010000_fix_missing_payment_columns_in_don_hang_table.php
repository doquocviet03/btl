<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sửa lỗi thanh toán đơn hàng sản phẩm:
     * Unknown column `trang_thai_thanh_toan` in `don_hang`.
     *
     * Migration này dùng Schema::hasColumn để chạy an toàn trên database cũ/mới.
     */
    public function up(): void
    {
        if (! Schema::hasTable('don_hang')) {
            return;
        }

        Schema::table('don_hang', function (Blueprint $table) {
            if (! Schema::hasColumn('don_hang', 'trang_thai_thanh_toan')) {
                $table->string('trang_thai_thanh_toan', 50)
                    ->default('chua_thanh_toan')
                    ->after('trang_thai');
            }

            if (! Schema::hasColumn('don_hang', 'ma_giao_dich')) {
                $table->string('ma_giao_dich', 100)->nullable()->after('trang_thai_thanh_toan');
            }

            if (! Schema::hasColumn('don_hang', 'vnpay_txn_ref')) {
                $table->string('vnpay_txn_ref', 100)->nullable()->after('ma_giao_dich');
            }

            if (! Schema::hasColumn('don_hang', 'vnpay_transaction_no')) {
                $table->string('vnpay_transaction_no', 100)->nullable()->after('vnpay_txn_ref');
            }

            if (! Schema::hasColumn('don_hang', 'vnpay_response_code')) {
                $table->string('vnpay_response_code', 20)->nullable()->after('vnpay_transaction_no');
            }

            if (! Schema::hasColumn('don_hang', 'vnpay_bank_code')) {
                $table->string('vnpay_bank_code', 50)->nullable()->after('vnpay_response_code');
            }

            if (! Schema::hasColumn('don_hang', 'vnpay_pay_date')) {
                $table->string('vnpay_pay_date', 50)->nullable()->after('vnpay_bank_code');
            }

            if (! Schema::hasColumn('don_hang', 'momo_order_id')) {
                $table->string('momo_order_id', 100)->nullable()->after('vnpay_pay_date');
            }

            if (! Schema::hasColumn('don_hang', 'momo_request_id')) {
                $table->string('momo_request_id', 100)->nullable()->after('momo_order_id');
            }

            if (! Schema::hasColumn('don_hang', 'momo_trans_id')) {
                $table->string('momo_trans_id', 100)->nullable()->after('momo_request_id');
            }

            if (! Schema::hasColumn('don_hang', 'momo_result_code')) {
                $table->string('momo_result_code', 20)->nullable()->after('momo_trans_id');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('don_hang')) {
            return;
        }

        Schema::table('don_hang', function (Blueprint $table) {
            $columns = [
                'trang_thai_thanh_toan',
                'ma_giao_dich',
                'vnpay_txn_ref',
                'vnpay_transaction_no',
                'vnpay_response_code',
                'vnpay_bank_code',
                'vnpay_pay_date',
                'momo_order_id',
                'momo_request_id',
                'momo_trans_id',
                'momo_result_code',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('don_hang', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
