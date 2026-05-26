<?php $__env->startSection('title', 'Sản phẩm chăm sóc tóc nam - Barber House'); ?>
<?php $__env->startSection('meta_description', 'Mua sản phẩm chăm sóc tóc nam, sáp vuốt tóc, dầu gội, combo tạo kiểu và chăm sóc da đầu tại Barber House.'); ?>
<?php $__env->startSection('content'); ?>
<section class="bh-page-hero">
    <div class="bh-container grid items-center gap-10 lg:grid-cols-[1.15fr_.85fr]">
        <div>
            <p class="bh-eyebrow">Hair Care Shop</p>
            <h1 class="bh-section-title mt-4 max-w-5xl">Sản phẩm giữ form tóc sau salon.</h1>
            <p class="mt-5 max-w-2xl text-zinc-400">Sáp vuốt tóc, dầu gội, tinh dầu dưỡng và combo chăm sóc tóc được chọn lọc cho chất tóc nam Việt Nam.</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="<?php echo e(route('public.gio-hang.index')); ?>" class="bh-btn-primary">Xem giỏ hàng</a>
                <a href="<?php echo e(route('public.dat-lich.index')); ?>" class="bh-btn-light">Đặt lịch tư vấn</a>
            </div>
        </div>
        <div class="bh-dark-card p-8">
            <p class="text-sm font-bold text-zinc-400">Barber House Care</p>
            <div class="mt-6 grid grid-cols-2 gap-4">
                <div class="rounded-3xl bg-white/10 p-5"><div class="text-3xl font-black text-orange-400">100%</div><p class="mt-2 text-sm text-zinc-400">sản phẩm chọn lọc</p></div>
                <div class="rounded-3xl bg-white/10 p-5"><div class="text-3xl font-black text-orange-400">COD</div><p class="mt-2 text-sm text-zinc-400">thanh toán khi nhận</p></div>
            </div>
        </div>
    </div>
</section>

<section class="bh-container py-12">
    <form method="GET" class="bh-card mb-8 grid gap-3 p-4 md:grid-cols-4">
        <input name="q" value="<?php echo e(request('q')); ?>" class="bh-input md:col-span-2" placeholder="Tìm sản phẩm, thương hiệu...">
        <select name="loai_san_pham" class="bh-input">
            <option value="">Tất cả loại</option>
            <?php $__currentLoopData = $loaiSanPham; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value); ?>" <?php if(request('loai_san_pham') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="sap_xep" class="bh-input">
            <option value="">Mới / nổi bật</option>
            <option value="gia_tang" <?php if(request('sap_xep') === 'gia_tang'): echo 'selected'; endif; ?>>Giá tăng dần</option>
            <option value="gia_giam" <?php if(request('sap_xep') === 'gia_giam'): echo 'selected'; endif; ?>>Giá giảm dần</option>
        </select>
        <button class="bh-btn-primary md:col-span-4">Lọc sản phẩm</button>
    </form>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        <?php $__empty_1 = true; $__currentLoopData = $sanPham; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="group bh-card overflow-hidden transition duration-300 hover:-translate-y-2">
                <a href="<?php echo e(route('public.san-pham.show', $sp)); ?>" class="relative block h-52 overflow-hidden bg-black/40">
                    <div class="absolute inset-5 grid place-items-center rounded-[1.8rem] bg-[radial-gradient(circle_at_55%_25%,rgba(255,106,42,.72),transparent_25%),radial-gradient(circle_at_45%_55%,rgba(183,43,255,.55),transparent_45%),rgba(255,255,255,.06)] text-5xl font-black text-white transition group-hover:scale-105"><?php echo e(mb_substr($sp->ten_san_pham,0,1)); ?></div>
                    <?php if($sp->gia_khuyen_mai): ?>
                        <span class="absolute left-4 top-4 rounded-full bg-red-500 px-3 py-1 text-xs font-black text-white">Sale</span>
                    <?php endif; ?>
                </a>
                <div class="p-5">
                    <p class="text-xs font-black uppercase tracking-[.22em] text-zinc-500"><?php echo e($sp->thuong_hieu ?? 'Barber House'); ?></p>
                    <a href="<?php echo e(route('public.san-pham.show', $sp)); ?>" class="mt-2 block text-lg font-black leading-tight text-white hover:text-red-300"><?php echo e($sp->ten_san_pham); ?></a>
                    <p class="mt-2 line-clamp-2 text-sm text-zinc-400"><?php echo e($sp->mo_ta_ngan); ?></p>
                    <div class="mt-5 flex items-end justify-between gap-3">
                        <div>
                            <div class="text-xl font-black text-orange-400"><?php echo e(number_format($sp->gia_ban)); ?>đ</div>
                            <?php if($sp->gia_khuyen_mai): ?>
                                <div class="text-xs text-zinc-600 line-through"><?php echo e(number_format($sp->gia)); ?>đ</div>
                            <?php endif; ?>
                        </div>
                        <form method="POST" action="<?php echo e(route('public.gio-hang.add', $sp)); ?>">
                            <?php echo csrf_field(); ?>
                            <button class="rounded-full bg-white px-4 py-3 text-xs font-black text-black transition hover:bg-red-500 hover:text-white">Thêm</button>
                        </form>
                    </div>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="bh-card p-12 text-center font-bold text-zinc-400 sm:col-span-2 lg:col-span-4">Chưa có sản phẩm phù hợp.</div>
        <?php endif; ?>
    </div>

    <div class="mt-10"><?php echo e($sanPham->links()); ?></div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\STUDY\Laravel\BARBER\CATTOC\resources\views/user/shop/index.blade.php ENDPATH**/ ?>