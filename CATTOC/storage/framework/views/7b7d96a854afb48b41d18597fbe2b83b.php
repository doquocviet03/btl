<?php if(session('success')): ?>
    <div class="mb-4 rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<?php if($errors->any()): ?>
    <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3">
        <ul class="list-disc pl-5">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?><?php /**PATH D:\STUDY\Laravel\BARBER\CATTOC\resources\views/components/alert.blade.php ENDPATH**/ ?>