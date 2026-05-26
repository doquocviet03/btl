<?php $__env->startSection('title', 'Đội ngũ barber - Barber House'); ?>
<?php $__env->startSection('meta_description', 'Chọn thợ cắt tóc nam chuyên nghiệp tại Barber House theo tên, chuyên môn, kinh nghiệm và số lịch đã phục vụ.'); ?>
<?php $__env->startSection('content'); ?>
<section class="bh-page-hero">
    <div class="bh-container grid gap-8 lg:grid-cols-[1fr_.42fr] lg:items-end">
        <div>
            <p class="bh-eyebrow">Barber Team</p>
            <h1 class="bh-section-title mt-4 max-w-5xl">Chọn người tạo nên phong cách của bạn.</h1>
            <p class="mt-5 max-w-2xl text-zinc-400">Mỗi barber có thế mạnh riêng: fade sắc, layer tự nhiên, uốn nhẹ, tư vấn form tóc và chăm sóc da đầu.</p>
        </div>
        <form method="GET" class="bh-card flex gap-3 p-4">
            <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Tên hoặc chuyên môn..." class="bh-input flex-1">
            <button class="bh-btn-primary">Tìm</button>
        </form>
    </div>
</section>

<section class="bh-container py-12">
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <?php $__empty_1 = true; $__currentLoopData = $thoCatToc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tho): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('public.tho-cat-toc.show', $tho)); ?>" class="group bh-card overflow-hidden transition duration-300 hover:-translate-y-2 hover:bg-white hover:text-black">
                <div class="relative h-56 bg-black/40">
                    <div class="absolute inset-5 rounded-[1.7rem] bg-[radial-gradient(circle_at_50%_22%,rgba(255,53,53,.8),transparent_24%),radial-gradient(circle_at_48%_50%,rgba(183,43,255,.66),transparent_45%),rgba(255,255,255,.06)] grid place-items-center text-7xl font-black text-white group-hover:text-black">
                        <?php echo e(mb_substr($tho->ho_ten,0,1)); ?>

                    </div>
                    <span class="absolute left-5 top-5 rounded-full bg-white px-3 py-1 text-xs font-black text-black"><?php echo e(str_pad(($thoCatToc->firstItem() ?? 1) + $index, 2, '0', STR_PAD_LEFT)); ?></span>
                </div>
                <div class="p-5">
                    <h2 class="text-xl font-black tracking-[-.04em] text-white group-hover:text-black"><?php echo e($tho->ho_ten); ?></h2>
                    <p class="mt-1 text-sm text-zinc-400 group-hover:text-zinc-600"><?php echo e($tho->chuyen_mon ?? 'Barber chuyên nghiệp'); ?></p>
                    <div class="mt-5 grid grid-cols-2 gap-3 text-sm font-black">
                        <div class="rounded-2xl bg-white/10 p-3 group-hover:bg-black/5"><span class="block text-zinc-500">Kinh nghiệm</span><?php echo e($tho->kinh_nghiem); ?> năm</div>
                        <div class="rounded-2xl bg-white/10 p-3 group-hover:bg-black/5"><span class="block text-zinc-500">Lịch</span><?php echo e($tho->lich_hen_count); ?></div>
                    </div>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="bh-card p-12 text-center text-zinc-400 lg:col-span-4">Không tìm thấy thợ phù hợp.</div>
        <?php endif; ?>
    </div>
    <div class="mt-10"><?php echo e($thoCatToc->links()); ?></div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\STUDY\Laravel\BARBER\CATTOC\resources\views/user/barbers/index.blade.php ENDPATH**/ ?>