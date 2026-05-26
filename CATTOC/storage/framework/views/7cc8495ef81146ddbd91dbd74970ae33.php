<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?> - Barber House</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="admin-grid-bg bg-slate-100 text-slate-950 antialiased">
    <div class="min-h-screen flex">
        <?php echo $__env->make('admin.layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="flex-1 flex flex-col min-w-0">
            <?php echo $__env->make('admin.layouts.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <main class="p-4 md:p-6 lg:p-8 flex-1">
                <?php echo $__env->make('components.alert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php echo $__env->yieldContent('content'); ?>
            </main>
            <?php echo $__env->make('admin.layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\STUDY\Laravel\BARBER\CATTOC\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>