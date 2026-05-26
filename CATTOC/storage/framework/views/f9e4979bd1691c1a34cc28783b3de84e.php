<?php $__env->startSection('title', 'Hệ thống cửa hàng Barber House'); ?>
<?php $__env->startSection('meta_description', 'Tìm cửa hàng Barber House gần bạn để đặt lịch cắt tóc, chăm sóc tóc hoặc mua sản phẩm trực tiếp tại các chi nhánh.'); ?>
<?php $__env->startSection('content'); ?>
<section class="bh-page-hero">
    <div class="bh-container grid gap-8 lg:grid-cols-[1fr_.42fr] lg:items-end">
        <div>
            <p class="bh-eyebrow">Store System</p>
            <h1 class="bh-section-title mt-4 max-w-5xl">Hệ thống Barber House tại Việt Nam.</h1>
            <p class="mt-5 max-w-2xl text-zinc-400">Tìm chi nhánh gần bạn để đặt lịch cắt tóc, chăm sóc tóc hoặc mua sản phẩm trực tiếp.</p>
        </div>
        <form method="GET" class="bh-card grid gap-3 p-4">
            <input name="q" value="<?php echo e(request('q')); ?>" class="bh-input" placeholder="Tìm địa chỉ hoặc tên chi nhánh...">
            <select name="thanh_pho" class="bh-input">
                <option value="">Tất cả thành phố</option>
                <?php $__currentLoopData = $thanhPho; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($city); ?>" <?php if(request('thanh_pho') === $city): echo 'selected'; endif; ?>><?php echo e($city); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button class="bh-btn-primary">Lọc cửa hàng</button>
        </form>
    </div>
</section>

<section class="bh-container grid gap-8 py-12 lg:grid-cols-[.55fr_1fr]">
    <div class="bh-dark-card h-fit p-8 lg:sticky lg:top-28">
        <p class="bh-eyebrow">Map Preview</p>
        <h2 class="mt-4 text-4xl font-black leading-[.95] tracking-[-.06em] text-white">Phủ sóng các thành phố lớn.</h2>
        <p class="mt-5 text-zinc-400">Bạn có thể bổ sung link Google Maps cho từng cửa hàng trong database trường <strong>ban_do_url</strong>.</p>
        <div class="mt-8 grid grid-cols-2 gap-4">
            <div class="rounded-3xl bg-white/10 p-5"><div class="text-3xl font-black text-orange-400"><?php echo e($cuaHang->total()); ?></div><p class="mt-2 text-sm text-zinc-400">chi nhánh</p></div>
            <div class="rounded-3xl bg-white/10 p-5"><div class="text-3xl font-black text-orange-400">08-18</div><p class="mt-2 text-sm text-zinc-400">giờ mở cửa</p></div>
        </div>
    </div>
    <div class="space-y-4">
        <?php $__empty_1 = true; $__currentLoopData = $cuaHang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="bh-card grid gap-5 p-6 md:grid-cols-[1fr_auto] md:items-center">
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="text-2xl font-black tracking-[-.04em] text-white"><?php echo e($store->ten_cua_hang); ?></h2>
                        <span class="bh-chip"><?php echo e($store->thanh_pho); ?></span>
                    </div>
                    <p class="mt-3 font-bold text-zinc-300"><?php echo e($store->dia_chi); ?></p>
                    <p class="mt-2 text-sm text-zinc-500"><?php echo e($store->mo_ta); ?></p>
                    <div class="mt-4 flex flex-wrap gap-3 text-sm font-black text-zinc-400">
                        <span>☎ <?php echo e($store->so_dien_thoai ?? 'Đang cập nhật'); ?></span>
                        <span>•</span>
                        <span><?php echo e($store->gio_mo_cua); ?></span>
                    </div>
                </div>
                <div class="flex gap-3 md:flex-col">
                    <?php if($store->ban_do_url): ?>
                        <a href="<?php echo e($store->ban_do_url); ?>" target="_blank" class="bh-btn-light">Bản đồ</a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('public.dat-lich.index')); ?>" class="bh-btn-primary">Đặt lịch</a>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="bh-card p-12 text-center font-bold text-zinc-400">Chưa tìm thấy cửa hàng phù hợp.</div>
        <?php endif; ?>
        <div class="mt-8"><?php echo e($cuaHang->links()); ?></div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\STUDY\Laravel\BARBER\CATTOC\resources\views/user/stores/index.blade.php ENDPATH**/ ?>