<?php $__env->startSection('title', $baiViet->tieu_de . ' - Barber House'); ?>
<?php $__env->startSection('content'); ?>
<section class="hero-gradient py-16">
    <div class="bh-container max-w-4xl text-center">
        <p class="bh-eyebrow"><?php echo e($baiViet->tac_gia); ?> • <?php echo e(optional($baiViet->xuat_ban_luc)->format('d/m/Y')); ?></p>
        <h1 class="bh-section-title mt-4"><?php echo e($baiViet->tieu_de); ?></h1>
        <p class="bh-muted mt-6"><?php echo e($baiViet->tom_tat); ?></p>
    </div>
</section>
<section class="bh-container py-12 grid lg:grid-cols-[1fr_.35fr] gap-8">
    <article class="bh-card p-8 md:p-10">
        
        <div class="text-lg leading-8 text-slate-700 whitespace-pre-line"><?php echo e($baiViet->noi_dung); ?></div>
    </article>
    <aside class="space-y-4">
        <div class="bh-dark-card p-6">
            <h3 class="text-xl font-black">Cần tư vấn kiểu tóc?</h3>
            <p class="text-slate-400 mt-2 text-sm">Đặt lịch với thợ để được tư vấn theo khuôn mặt và chất tóc.</p>
            <a href="<?php echo e(route('public.dat-lich.index')); ?>" class="bh-btn-primary mt-5 w-full">Đặt lịch</a>
        </div>
        <?php $__currentLoopData = $baiVietLienQuan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('public.blog.show', $post)); ?>" class="block bh-card p-5 hover:border-orange-300 transition">
                <div class="text-xs font-black text-orange-500">Bài liên quan</div>
                <div class="font-black mt-2 leading-tight"><?php echo e($post->tieu_de); ?></div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </aside>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\STUDY\Laravel\BARBER\CATTOC\resources\views/user/blog/show.blade.php ENDPATH**/ ?>