<?php
    $cartCount = collect(session('cart', []))->sum('so_luong');
?>
<header x-data="{open:false}" class="sticky top-0 z-50 border-b border-white/10 bg-black/60 backdrop-blur-2xl">
    <div class="bh-container flex h-20 items-center justify-between gap-4">
        <a href="<?php echo e(route('public.home')); ?>" class="group flex items-center gap-3">
            <span class="relative grid h-11 w-11 place-items-center overflow-hidden rounded-2xl border border-white/10 bg-white/[.06] font-black text-white shadow-[0_0_45px_rgba(255,53,53,.22)] transition group-hover:scale-105">
                <span class="absolute inset-0 bg-gradient-to-br from-red-500 via-fuchsia-500 to-orange-400 opacity-80"></span>
                <span class="relative">BH</span>
            </span>
            <span class="leading-none">
                <span class="block text-lg font-black tracking-[-.05em] text-white">Barber House</span>
                <span class="mt-1 block text-[10px] font-bold uppercase tracking-[.24em] text-zinc-500">Cut • Care • Style</span>
            </span>
        </a>

        <?php echo $__env->make('user.layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="hidden items-center gap-2 md:flex">
            <a href="<?php echo e(route('public.gio-hang.index')); ?>" class="bh-btn-light !px-4 !py-2.5 relative">
                Cart
                <?php if($cartCount > 0): ?>
                    <span class="absolute -right-2 -top-2 grid h-6 min-w-6 place-items-center rounded-full bg-red-500 px-2 text-xs text-white"><?php echo e($cartCount); ?></span>
                <?php endif; ?>
            </a>
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('public.lich-cua-toi')); ?>" class="bh-btn-light !px-4 !py-2.5">Lịch của tôi</a>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button class="bh-btn-primary !px-4 !py-2.5">Đăng xuất</button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="bh-btn-light !px-4 !py-2.5">Đăng nhập</a>
                <a href="<?php echo e(route('register')); ?>" class="bh-btn-primary !px-4 !py-2.5">Đăng ký</a>
            <?php endif; ?>
        </div>

        <button @click="open=!open" class="bh-btn-light !px-4 !py-2.5 xl:hidden" type="button">Menu</button>
    </div>

    <div x-show="open" x-transition class="xl:hidden border-t border-white/10 bg-black/95" style="display:none">
        <div class="bh-container grid gap-2 py-4">
            <a href="<?php echo e(route('public.home')); ?>" class="rounded-2xl px-4 py-3 font-black text-white hover:bg-white/10">Trang chủ</a>
            <a href="<?php echo e(route('public.dich-vu.index')); ?>" class="rounded-2xl px-4 py-3 font-black text-white hover:bg-white/10">Dịch vụ</a>
            <a href="<?php echo e(route('public.tho-cat-toc.index')); ?>" class="rounded-2xl px-4 py-3 font-black text-white hover:bg-white/10">Thợ cắt tóc</a>
            <a href="<?php echo e(route('public.san-pham.index')); ?>" class="rounded-2xl px-4 py-3 font-black text-white hover:bg-white/10">Sản phẩm</a>
            <a href="<?php echo e(route('public.blog.index')); ?>" class="rounded-2xl px-4 py-3 font-black text-white hover:bg-white/10">Blog</a>
            <a href="<?php echo e(route('public.cua-hang.index')); ?>" class="rounded-2xl px-4 py-3 font-black text-white hover:bg-white/10">Cửa hàng</a>
            <a href="<?php echo e(route('public.dat-lich.index')); ?>" class="rounded-2xl bg-gradient-to-r from-red-500 to-orange-500 px-4 py-3 font-black text-white">Đặt lịch ngay</a>
            <a href="<?php echo e(route('public.gio-hang.index')); ?>" class="rounded-2xl px-4 py-3 font-black text-white hover:bg-white/10">Giỏ hàng <?php echo e($cartCount ? '(' . $cartCount . ')' : ''); ?></a>
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('public.lich-cua-toi')); ?>" class="rounded-2xl px-4 py-3 font-black text-white hover:bg-white/10">Lịch của tôi</a>
                <a href="<?php echo e(route('public.danh-gia.history')); ?>" class="rounded-2xl px-4 py-3 font-black text-white hover:bg-white/10">Đánh giá của tôi</a>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="px-4 py-2">
                    <?php echo csrf_field(); ?>
                    <button class="bh-btn-primary w-full">Đăng xuất</button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="rounded-2xl px-4 py-3 font-black text-white hover:bg-white/10">Đăng nhập</a>
                <a href="<?php echo e(route('register')); ?>" class="rounded-2xl px-4 py-3 font-black text-white hover:bg-white/10">Đăng ký</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<?php /**PATH D:\STUDY\Laravel\BARBER\CATTOC\resources\views/user/layouts/header.blade.php ENDPATH**/ ?>