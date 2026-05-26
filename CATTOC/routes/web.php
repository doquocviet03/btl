<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DanhGiaController;
use App\Http\Controllers\Admin\DanhMucDichVuController;
use App\Http\Controllers\Admin\DichVuController;
use App\Http\Controllers\Admin\KhachHangController;
use App\Http\Controllers\Admin\LichHenController;
use App\Http\Controllers\Admin\LichLamViecThangController;
use App\Http\Controllers\Admin\DonHangController;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\TaiKhoanController;
use App\Http\Controllers\Admin\ThanhToanController;
use App\Http\Controllers\Admin\ThoCatTocController;
use App\Http\Controllers\Admin\ThongBaoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Payment\MomoPaymentController;
use App\Http\Controllers\Payment\VnpayPaymentController;
use App\Http\Controllers\PublicSite\BookingController as PublicBookingController;
use App\Http\Controllers\PublicSite\ShopController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC WEBSITE
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicBookingController::class, 'home'])->name('public.home');
Route::get('/dich-vu', [PublicBookingController::class, 'services'])->name('public.dich-vu.index');
Route::get('/dich-vu/{dichVu}', [PublicBookingController::class, 'serviceShow'])->name('public.dich-vu.show');
Route::get('/tho-cat-toc', [PublicBookingController::class, 'barbers'])->name('public.tho-cat-toc.index');
Route::get('/tho-cat-toc/{thoCatToc}', [PublicBookingController::class, 'barberShow'])->name('public.tho-cat-toc.show');
Route::get('/dat-lich', [PublicBookingController::class, 'index'])->name('public.dat-lich.index');
Route::post('/dat-lich', [PublicBookingController::class, 'store'])->name('public.dat-lich.store');
Route::get('/dat-lich/{lichHen}/thanh-cong', [PublicBookingController::class, 'success'])->name('public.dat-lich.success');

Route::get('/blog', [ShopController::class, 'blog'])->name('public.blog.index');
Route::get('/blog/{baiViet:slug}', [ShopController::class, 'blogShow'])->name('public.blog.show');
Route::get('/he-thong-cua-hang', [ShopController::class, 'stores'])->name('public.cua-hang.index');
Route::get('/san-pham', [ShopController::class, 'products'])->name('public.san-pham.index');
Route::get('/san-pham/{sanPham:slug}', [ShopController::class, 'productShow'])->name('public.san-pham.show');
Route::get('/gio-hang', [ShopController::class, 'cart'])->name('public.gio-hang.index');
Route::post('/gio-hang/{sanPham}/them', [ShopController::class, 'addToCart'])->name('public.gio-hang.add');
Route::patch('/gio-hang/{sanPham}', [ShopController::class, 'updateCart'])->name('public.gio-hang.update');
Route::delete('/gio-hang/{sanPham}', [ShopController::class, 'removeFromCart'])->name('public.gio-hang.remove');
Route::post('/gio-hang/dat-hang', [ShopController::class, 'checkout'])->name('public.gio-hang.checkout');
Route::get('/gio-hang/dat-hang/{donHang}/thanh-cong', [ShopController::class, 'checkoutSuccess'])->name('public.gio-hang.thanh-cong');


/*
|--------------------------------------------------------------------------
| MOMO PAYMENT
|--------------------------------------------------------------------------
*/

Route::post('/momo/ipn', [MomoPaymentController::class, 'ipn'])->name('momo.ipn');
Route::get('/momo/lich-hen/{lichHen}/ket-qua', [MomoPaymentController::class, 'appointmentReturn'])->name('momo.appointment.return');
Route::get('/momo/don-hang/{donHang}/ket-qua', [MomoPaymentController::class, 'orderReturn'])->name('momo.order.return');
Route::post('/momo/don-hang/{donHang}/thanh-toan', [MomoPaymentController::class, 'createForOrder'])->name('momo.order.create');

/*
|--------------------------------------------------------------------------
| VNPAY PAYMENT SANDBOX
|--------------------------------------------------------------------------
*/
Route::get('/vnpay/ipn', [VnpayPaymentController::class, 'ipn'])->name('vnpay.ipn');
Route::get('/vnpay/lich-hen/{lichHen}/ket-qua', [VnpayPaymentController::class, 'appointmentReturn'])->name('vnpay.appointment.return');
Route::get('/vnpay/don-hang/{donHang}/ket-qua', [VnpayPaymentController::class, 'orderReturn'])->name('vnpay.order.return');
Route::post('/vnpay/don-hang/{donHang}/thanh-toan', [VnpayPaymentController::class, 'createForOrder'])->name('vnpay.order.create');

Route::get('/dashboard', function () {
    $user = Auth::user();

    return $user && $user->vai_tro === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('public.lich-cua-toi');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/lich-cua-toi', [PublicBookingController::class, 'myBookings'])->name('public.lich-cua-toi');
    Route::patch('/lich-cua-toi/{lichHen}/huy', [PublicBookingController::class, 'cancel'])->name('public.lich-cua-toi.cancel');
    Route::get('/lich-cua-toi/{lichHen}/thanh-toan', [PublicBookingController::class, 'payment'])->name('public.thanh-toan.index');
    Route::post('/lich-cua-toi/{lichHen}/thanh-toan/momo', [MomoPaymentController::class, 'createForAppointment'])->name('momo.appointment.create');
    Route::post('/lich-cua-toi/{lichHen}/thanh-toan/vnpay', [VnpayPaymentController::class, 'createForAppointment'])->name('vnpay.appointment.create');
    Route::post('/lich-cua-toi/{lichHen}/thanh-toan', [PublicBookingController::class, 'paymentConfirm'])->name('public.thanh-toan.confirm');
    Route::get('/lich-cua-toi/{lichHen}/thanh-toan/thanh-cong', [PublicBookingController::class, 'paymentSuccess'])->name('public.thanh-toan.success');
    Route::get('/lich-cua-toi/{lichHen}/danh-gia', [PublicBookingController::class, 'reviewCreate'])->name('public.danh-gia.create');
    Route::post('/lich-cua-toi/{lichHen}/danh-gia', [PublicBookingController::class, 'reviewStore'])->name('public.danh-gia.store');
    Route::get('/danh-gia-cua-toi', [PublicBookingController::class, 'reviewHistory'])->name('public.danh-gia.history');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('khach-hang', KhachHangController::class)
            ->parameters(['khach-hang' => 'khachHang'])
            ->except(['show']);

        Route::resource('tho-cat-toc', ThoCatTocController::class)
            ->parameters(['tho-cat-toc' => 'thoCatToc'])
            ->except(['show']);

        Route::resource('danh-muc-dich-vu', DanhMucDichVuController::class)
            ->parameters(['danh-muc-dich-vu' => 'danhMucDichVu'])
            ->except(['show']);

        Route::resource('dich-vu', DichVuController::class)
            ->parameters(['dich-vu' => 'dichVu'])
            ->except(['show']);

        Route::resource('tai-khoan', TaiKhoanController::class)
            ->parameters(['tai-khoan' => 'taiKhoan'])
            ->except(['show']);

        Route::resource('lich-hen', LichHenController::class)
            ->parameters(['lich-hen' => 'lichHen'])
            ->except(['show']);

        Route::resource('danh-gia', DanhGiaController::class)
            ->parameters(['danh-gia' => 'danhGia'])
            ->except(['show']);

        Route::resource('san-pham', SanPhamController::class)
            ->parameters(['san-pham' => 'sanPham'])
            ->except(['show']);

        Route::resource('don-hang', DonHangController::class)
            ->parameters(['don-hang' => 'donHang'])
            ->except(['show', 'create', 'store']);

        Route::get('/lich-lam-viec-thang', [LichLamViecThangController::class, 'index'])->name('lich-lam-viec-thang.index');
        Route::post('/lich-lam-viec-thang', [LichLamViecThangController::class, 'store'])->name('lich-lam-viec-thang.store');

        Route::get('/thanh-toan', [ThanhToanController::class, 'index'])->name('thanh-toan.index');
        Route::get('/thanh-toan/{thanhToan}/edit', [ThanhToanController::class, 'edit'])->name('thanh-toan.edit');
        Route::put('/thanh-toan/{thanhToan}', [ThanhToanController::class, 'update'])->name('thanh-toan.update');
        Route::delete('/thanh-toan/{thanhToan}', [ThanhToanController::class, 'destroy'])->name('thanh-toan.destroy');
        Route::post('/lich-hen/{lichHen}/tao-thanh-toan', [ThanhToanController::class, 'createForAppointment'])->name('thanh-toan.create-for-appointment');
        Route::post('/thanh-toan/{thanhToan}/xac-nhan', [ThanhToanController::class, 'markPaid'])->name('thanh-toan.mark-paid');
        Route::get('/lich-hen/{lichHen}/hoa-don', [ThanhToanController::class, 'invoice'])->name('thanh-toan.invoice');

        Route::get('/thong-bao/latest', [ThongBaoController::class, 'latest'])->name('thong-bao.latest');
        Route::post('/thong-bao/read', [ThongBaoController::class, 'markAsRead'])->name('thong-bao.read');
    });

require __DIR__.'/auth.php';
