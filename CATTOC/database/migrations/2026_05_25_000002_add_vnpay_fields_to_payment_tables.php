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
                if (! Schema::hasColumn('thanh_toan', 'vnpay_txn_ref')) {
                    $table->string('vnpay_txn_ref', 220)->nullable()->unique()->after('momo_payload');
                }
                if (! Schema::hasColumn('thanh_toan', 'vnpay_payment_url')) {
                    $table->text('vnpay_payment_url')->nullable()->after('vnpay_txn_ref');
                }
                if (! Schema::hasColumn('thanh_toan', 'vnpay_transaction_no')) {
                    $table->string('vnpay_transaction_no', 120)->nullable()->after('vnpay_payment_url');
                }
                if (! Schema::hasColumn('thanh_toan', 'vnpay_response_code')) {
                    $table->string('vnpay_response_code', 20)->nullable()->after('vnpay_transaction_no');
                }
                if (! Schema::hasColumn('thanh_toan', 'vnpay_transaction_status')) {
                    $table->string('vnpay_transaction_status', 20)->nullable()->after('vnpay_response_code');
                }
                if (! Schema::hasColumn('thanh_toan', 'vnpay_bank_code')) {
                    $table->string('vnpay_bank_code', 60)->nullable()->after('vnpay_transaction_status');
                }
                if (! Schema::hasColumn('thanh_toan', 'vnpay_pay_date')) {
                    $table->string('vnpay_pay_date', 30)->nullable()->after('vnpay_bank_code');
                }
                if (! Schema::hasColumn('thanh_toan', 'vnpay_payload')) {
                    $table->longText('vnpay_payload')->nullable()->after('vnpay_pay_date');
                }
            });
        }

        if (Schema::hasTable('don_hang')) {
            if (DB::getDriverName() === 'mysql') {
                DB::statement("ALTER TABLE don_hang MODIFY phuong_thuc_thanh_toan ENUM('cod','chuyen_khoan','momo','vnpay') NOT NULL DEFAULT 'cod'");
            }

            Schema::table('don_hang', function (Blueprint $table) {
                if (! Schema::hasColumn('don_hang', 'vnpay_txn_ref')) {
                    $table->string('vnpay_txn_ref', 220)->nullable()->unique()->after('momo_payload');
                }
                if (! Schema::hasColumn('don_hang', 'vnpay_payment_url')) {
                    $table->text('vnpay_payment_url')->nullable()->after('vnpay_txn_ref');
                }
                if (! Schema::hasColumn('don_hang', 'vnpay_transaction_no')) {
                    $table->string('vnpay_transaction_no', 120)->nullable()->after('vnpay_payment_url');
                }
                if (! Schema::hasColumn('don_hang', 'vnpay_response_code')) {
                    $table->string('vnpay_response_code', 20)->nullable()->after('vnpay_transaction_no');
                }
                if (! Schema::hasColumn('don_hang', 'vnpay_transaction_status')) {
                    $table->string('vnpay_transaction_status', 20)->nullable()->after('vnpay_response_code');
                }
                if (! Schema::hasColumn('don_hang', 'vnpay_bank_code')) {
                    $table->string('vnpay_bank_code', 60)->nullable()->after('vnpay_transaction_status');
                }
                if (! Schema::hasColumn('don_hang', 'vnpay_pay_date')) {
                    $table->string('vnpay_pay_date', 30)->nullable()->after('vnpay_bank_code');
                }
                if (! Schema::hasColumn('don_hang', 'vnpay_payload')) {
                    $table->longText('vnpay_payload')->nullable()->after('vnpay_pay_date');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('thanh_toan')) {
            Schema::table('thanh_toan', function (Blueprint $table) {
                foreach (['vnpay_payload', 'vnpay_pay_date', 'vnpay_bank_code', 'vnpay_transaction_status', 'vnpay_response_code', 'vnpay_transaction_no', 'vnpay_payment_url', 'vnpay_txn_ref'] as $column) {
                    if (Schema::hasColumn('thanh_toan', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('don_hang')) {
            Schema::table('don_hang', function (Blueprint $table) {
                foreach (['vnpay_payload', 'vnpay_pay_date', 'vnpay_bank_code', 'vnpay_transaction_status', 'vnpay_response_code', 'vnpay_transaction_no', 'vnpay_payment_url', 'vnpay_txn_ref'] as $column) {
                    if (Schema::hasColumn('don_hang', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
