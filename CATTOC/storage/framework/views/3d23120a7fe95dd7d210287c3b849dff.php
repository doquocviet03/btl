<?php $__env->startSection('title', 'Dịch vụ cắt tóc nam cao cấp - Barber House'); ?>
<?php $__env->startSection('meta_description', 'Xem bảng giá dịch vụ cắt tóc nam, gội massage, tạo kiểu và chăm sóc tóc tại Barber House. Đặt lịch nhanh, chọn barber theo phong cách.'); ?>
<?php $__env->startSection('content'); ?>
<section class="bh-page-hero">
    <div class="bh-container grid gap-8 lg:grid-cols-[1fr_.45fr] lg:items-end">
        <div>
            <p class="bh-eyebrow">Menu Services</p>
            <h1 class="bh-section-title mt-4 max-w-5xl">Dịch vụ cắt tóc & chăm sóc tóc có gu.</h1>
            <p class="mt-5 max-w-2xl text-zinc-400">Từ fade, layer, uốn nhẹ đến gội massage da đầu — mọi dịch vụ đều được thiết kế để bạn ra khỏi ghế với diện mạo sắc nét hơn.</p>
        </div>
        <form method="GET" class="bh-card p-4 grid gap-3">
            <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Tìm dịch vụ..." class="bh-input">
            <select name="danh_muc_id" class="bh-input">
                <option value="">Tất cả danh mục</option>
                <?php $__currentLoopData = $danhMuc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dm->id); ?>" <?php if(request('danh_muc_id') == $dm->id): echo 'selected'; endif; ?>><?php echo e($dm->ten_danh_muc); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button class="bh-btn-primary">Lọc dịch vụ</button>
        </form>
    </div>
</section>

<section class="bh-container py-12">
    <div class="grid gap-5 md:grid-cols-3">
        <?php $__empty_1 = true; $__currentLoopData = $dichVu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $dv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="group bh-card flex flex-col p-6 transition duration-300 hover:-translate-y-2">
                <div class="flex items-start justify-between gap-5">
                    <span class="text-5xl font-black tracking-[-.08em] <?php echo e($index === 0 ? 'bh-gradient-text' : 'text-white'); ?>"><?php echo e(str_pad(($dichVu->firstItem() ?? 1) + $index, 2, '0', STR_PAD_LEFT)); ?></span>
                    <span class="bh-chip"><?php echo e($dv->danhMuc->ten_danh_muc ?? 'Service'); ?></span>
                </div>
                <div class="mt-10 flex-1">
                    <h2 class="text-2xl font-black leading-tight tracking-[-.04em] text-white group-hover:text-red-300"><?php echo e($dv->ten_dich_vu); ?></h2>
                    <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-zinc-400"><?php echo e($dv->mo_ta ?? 'Dịch vụ chuyên nghiệp, thực hiện bởi đội ngũ barber có kinh nghiệm.'); ?></p>
                </div>
                <div class="mt-8 flex items-end justify-between gap-4">
                    <div>
                        <strong class="bh-price"><?php echo e(number_format($dv->gia)); ?>đ</strong>
                        <p class="text-xs font-bold text-zinc-500"><?php echo e($dv->thoi_gian); ?> phút</p>
                    </div>
                    <a href="<?php echo e(route('public.dich-vu.show', $dv)); ?>" class="rounded-full bg-white px-4 py-2 text-xs font-black text-black transition hover:bg-red-500 hover:text-white">Chi tiết</a>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="bh-card p-12 text-center text-zinc-400 md:col-span-3">Không tìm thấy dịch vụ phù hợp.</div>
        <?php endif; ?>
    </div>
    <div class="mt-10"><?php echo e($dichVu->links()); ?></div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\STUDY\Laravel\BARBER\CATTOC\resources\views/user/services/index.blade.php ENDPATH**/ ?>