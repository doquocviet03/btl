<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'Barber House - đặt lịch cắt tóc nam, chọn barber, thanh toán online và mua sản phẩm chăm sóc tóc chính hãng.'); ?>">
    <title><?php echo $__env->yieldContent('title', 'Barber House'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="antialiased">
    <div class="bh-noise"></div>
    <div class="bh-site-shell min-h-screen flex flex-col">
        <?php echo $__env->make('user.layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <main class="flex-1">
            <div class="bh-container pt-4">
                <?php echo $__env->make('components.alert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <?php echo $__env->yieldContent('content'); ?>
        </main>
        <?php echo $__env->make('user.layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\STUDY\Laravel\BARBER\CATTOC\resources\views/user/layouts/app.blade.php ENDPATH**/ ?>