<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\BaiViet;
use App\Models\ChiTietDonHang;
use App\Models\CuaHang;
use App\Models\DonHang;
use App\Models\SanPham;
use App\Models\ThongBao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ShopController extends Controller
{
    public function products(Request $request)
    {
        $sanPham = SanPham::query()
            ->where('trang_thai', 1)
            ->when($request->q, fn ($q) => $q->where(function ($sub) use ($request) {
                $sub->where('ten_san_pham', 'like', '%' . $request->q . '%')
                    ->orWhere('thuong_hieu', 'like', '%' . $request->q . '%');
            }))
            ->when($request->loai_san_pham, fn ($q) => $q->where('loai_san_pham', $request->loai_san_pham))
            ->when($request->sap_xep === 'gia_tang', fn ($q) => $q->orderByRaw('COALESCE(gia_khuyen_mai, gia) ASC'))
            ->when($request->sap_xep === 'gia_giam', fn ($q) => $q->orderByRaw('COALESCE(gia_khuyen_mai, gia) DESC'))
            ->when(! $request->sap_xep, fn ($q) => $q->orderByDesc('noi_bat')->latest())
            ->paginate(12)
            ->withQueryString();

        $loaiSanPham = [
            'cham_soc_toc' => 'Chăm sóc tóc',
            'cham_soc_da_dau' => 'Chăm sóc da đầu',
            'tao_kieu' => 'Tạo kiểu',
            'combo' => 'Combo',
        ];

        return view('user.shop.index', compact('sanPham', 'loaiSanPham'));
    }

    public function productShow(SanPham $sanPham)
    {
        abort_if(! $sanPham->trang_thai, 404);

        $lienQuan = SanPham::where('trang_thai', 1)
            ->where('id', '!=', $sanPham->id)
            ->where('loai_san_pham', $sanPham->loai_san_pham)
            ->limit(4)
            ->get();

        return view('user.shop.show', compact('sanPham', 'lienQuan'));
    }

    public function cart()
    {
        $cart = $this->cartData();
        return view('user.cart.index', $cart);
    }

    public function addToCart(Request $request, SanPham $sanPham)
    {
        abort_if(! $sanPham->trang_thai, 404);

        $data = $request->validate([
            'so_luong' => ['nullable', 'integer', 'min:1', 'max:20'],
        ]);

        $cart = session()->get('cart', []);
        $qty = (int) ($data['so_luong'] ?? 1);
        $current = (int) ($cart[$sanPham->id]['so_luong'] ?? 0);

        $cart[$sanPham->id] = [
            'san_pham_id' => $sanPham->id,
            'so_luong' => min($current + $qty, 20),
        ];

        session()->put('cart', $cart);

        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function updateCart(Request $request, SanPham $sanPham)
    {
        $data = $request->validate([
            'so_luong' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$sanPham->id])) {
            $cart[$sanPham->id]['so_luong'] = (int) $data['so_luong'];
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Đã cập nhật giỏ hàng.');
    }

    public function removeFromCart(SanPham $sanPham)
    {
        $cart = session()->get('cart', []);
        unset($cart[$sanPham->id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    public function checkout(Request $request)
    {
        $cartData = $this->cartData();

        if ($cartData['items']->isEmpty()) {
            return redirect()->route('public.gio-hang.index')->with('error', 'Giỏ hàng đang trống.');
        }

        $khachHang = auth()->user()?->khachHang;

        $data = $request->validate([
            'ho_ten' => ['required', 'string', 'max:120'],
            'so_dien_thoai' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'dia_chi' => ['required', 'string', 'max:255'],
            'phuong_thuc_thanh_toan' => ['required', Rule::in(['cod', 'chuyen_khoan', 'momo', 'vnpay'])],
            'ghi_chu' => ['nullable', 'string', 'max:1000'],
        ]);

        $donHang = DB::transaction(function () use ($cartData, $data, $khachHang) {
            $donHang = DonHang::create([
                'ma_don_hang' => $this->makeOrderCode(),
                'khach_hang_id' => $khachHang?->id,
                'ho_ten' => $data['ho_ten'],
                'so_dien_thoai' => $data['so_dien_thoai'],
                'email' => $data['email'] ?? null,
                'dia_chi' => $data['dia_chi'],
                'tong_tien' => $cartData['tongTien'],
                'phuong_thuc_thanh_toan' => $data['phuong_thuc_thanh_toan'],
                'trang_thai' => 'cho_xac_nhan',
                'trang_thai_thanh_toan' => $data['phuong_thuc_thanh_toan'] === 'cod' ? 'chua_thanh_toan' : 'dang_cho_xac_nhan',
                'ghi_chu' => $data['ghi_chu'] ?? null,
            ]);

            foreach ($cartData['items'] as $item) {
                ChiTietDonHang::create([
                    'don_hang_id' => $donHang->id,
                    'san_pham_id' => $item['san_pham']->id,
                    'ten_san_pham' => $item['san_pham']->ten_san_pham,
                    'don_gia' => $item['gia'],
                    'so_luong' => $item['so_luong'],
                    'thanh_tien' => $item['thanh_tien'],
                ]);
            }

            ThongBao::create([
                'tieu_de' => 'Có đơn hàng mới',
                'noi_dung' => $donHang->ho_ten . ' vừa đặt đơn hàng ' . $donHang->ma_don_hang,
                'loai' => 'don_hang',
                'lien_ket' => route('admin.don-hang.index', [], false),
                'da_doc' => 0,
            ]);

            return $donHang;
        });

        session()->forget('cart');

        return redirect()->route('public.gio-hang.thanh-cong', $donHang)->with('success', 'Đặt hàng thành công. Barber House sẽ liên hệ xác nhận.');
    }

    public function checkoutSuccess(DonHang $donHang)
    {
        $donHang->load('chiTiet');
        return view('user.cart.success', compact('donHang'));
    }

    public function blog(Request $request)
    {
        $baiViet = BaiViet::where('trang_thai', 1)
            ->when($request->q, fn ($q) => $q->where('tieu_de', 'like', '%' . $request->q . '%'))
            ->orderByDesc('xuat_ban_luc')
            ->paginate(9)
            ->withQueryString();

        return view('user.blog.index', compact('baiViet'));
    }

    public function blogShow(BaiViet $baiViet)
    {
        abort_if(! $baiViet->trang_thai, 404);

        $baiVietLienQuan = BaiViet::where('trang_thai', 1)
            ->where('id', '!=', $baiViet->id)
            ->latest('xuat_ban_luc')
            ->limit(3)
            ->get();

        return view('user.blog.show', compact('baiViet', 'baiVietLienQuan'));
    }

    public function stores(Request $request)
    {
        $cuaHang = CuaHang::where('trang_thai', 1)
            ->when($request->thanh_pho, fn ($q) => $q->where('thanh_pho', $request->thanh_pho))
            ->when($request->q, fn ($q) => $q->where(function ($sub) use ($request) {
                $sub->where('ten_cua_hang', 'like', '%' . $request->q . '%')
                    ->orWhere('dia_chi', 'like', '%' . $request->q . '%');
            }))
            ->orderBy('thanh_pho')
            ->orderBy('ten_cua_hang')
            ->paginate(10)
            ->withQueryString();

        $thanhPho = CuaHang::where('trang_thai', 1)->select('thanh_pho')->distinct()->orderBy('thanh_pho')->pluck('thanh_pho');

        return view('user.stores.index', compact('cuaHang', 'thanhPho'));
    }

    private function cartData(): array
    {
        $cart = session()->get('cart', []);
        $ids = collect($cart)->pluck('san_pham_id')->filter()->values();
        $products = SanPham::whereIn('id', $ids)->get()->keyBy('id');

        $items = collect($cart)->map(function ($row) use ($products) {
            $sanPham = $products->get($row['san_pham_id']);
            if (! $sanPham) {
                return null;
            }

            $soLuong = max(1, (int) ($row['so_luong'] ?? 1));
            $gia = $sanPham->gia_ban;

            return [
                'san_pham' => $sanPham,
                'so_luong' => $soLuong,
                'gia' => $gia,
                'thanh_tien' => $gia * $soLuong,
            ];
        })->filter()->values();

        return [
            'items' => $items,
            'tongSoLuong' => $items->sum('so_luong'),
            'tongTien' => $items->sum('thanh_tien'),
        ];
    }

    private function makeOrderCode(): string
    {
        do {
            $code = 'DH' . now()->format('ymdHis') . Str::upper(Str::random(4));
        } while (DonHang::where('ma_don_hang', $code)->exists());

        return $code;
    }
}
