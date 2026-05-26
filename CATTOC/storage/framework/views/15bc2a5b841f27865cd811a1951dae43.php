<?php $__env->startSection('title', '404 - Không tìm thấy trang'); ?>
<?php $__env->startSection('content'); ?>
<section class="hero-bg py-24">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="text-8xl font-black text-orange-500">404</div>
        <h1 class="text-4xl font-black mt-4">Không tìm thấy trang</h1>
        <p class="text-slate-600 mt-3">Trang hoặc dữ liệu bạn đang tìm không tồn tại.</p>
        <a href="<?php echo e(route('public.home')); ?>" class="inline-flex mt-8 px-6 py-4 rounded-2xl bg-slate-950 text-white font-black hover:bg-orange-500 transition">Về trang chủ</a>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\STUDY\Laravel\BARBER\CATTOC\resources\views/errors/404.blade.php ENDPATH**/ ?>