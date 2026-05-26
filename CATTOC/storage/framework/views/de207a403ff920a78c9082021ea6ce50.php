<?php $__env->startSection('title', 'Blog tóc nam & chăm sóc tóc - Barber House'); ?>
<?php $__env->startSection('meta_description', 'Blog Barber House chia sẻ kiểu tóc nam, mẹo chăm sóc tóc, chọn sáp vuốt tóc, gội đầu và phong cách barber hiện đại.'); ?>
<?php $__env->startSection('content'); ?>
<section class="bh-page-hero">
    <div class="bh-container grid gap-8 lg:grid-cols-[1fr_.42fr] lg:items-end">
        <div>
            <p class="bh-eyebrow">Barber Journal</p>
            <h1 class="bh-section-title mt-4 max-w-5xl">Blog chăm sóc tóc & phong cách nam.</h1>
            <p class="mt-5 max-w-2xl text-zinc-400">Nội dung SEO có chất riêng: ngắn gọn, dễ hiểu, có gu và giúp người xem chọn đúng kiểu tóc, đúng sản phẩm.</p>
        </div>
        <form method="GET" class="bh-card flex gap-3 p-4">
            <input name="q" value="<?php echo e(request('q')); ?>" class="bh-input" placeholder="Tìm bài viết...">
            <button class="bh-btn-primary">Tìm</button>
        </form>
    </div>
</section>

<section class="bh-container py-12">
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <?php $__empty_1 = true; $__currentLoopData = $baiViet; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="group bh-card overflow-hidden transition duration-300 hover:-translate-y-2">
                <a href="<?php echo e(route('public.blog.show', $post)); ?>" class="relative block h-52 overflow-hidden bg-black/40">
                    <div class="absolute inset-5 grid place-items-center rounded-[1.8rem] bg-[radial-gradient(circle_at_55%_25%,rgba(255,53,53,.72),transparent_25%),radial-gradient(circle_at_45%_55%,rgba(183,43,255,.55),transparent_45%),rgba(255,255,255,.06)] text-6xl font-black text-white transition group-hover:scale-105"><?php echo e(mb_substr($post->tieu_de,0,1)); ?></div>
                </a>
                <div class="p-6">
                    <p class="text-xs font-black uppercase tracking-[.24em] text-red-300"><?php echo e(optional($post->xuat_ban_luc)->format('d/m/Y') ?? 'Blog'); ?></p>
                    <a href="<?php echo e(route('public.blog.show', $post)); ?>" class="mt-3 block text-2xl font-black leading-tight tracking-[-.05em] text-white hover:text-red-300"><?php echo e($post->tieu_de); ?></a>
                    <p class="mt-3 line-clamp-3 text-zinc-400"><?php echo e($post->tom_tat); ?></p>
                    <a href="<?php echo e(route('public.blog.show', $post)); ?>" class="mt-5 inline-flex text-sm font-black text-white hover:text-orange-400">Đọc bài viết →</a>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="bh-card p-12 text-center font-bold text-zinc-400 md:col-span-3">Chưa có bài viết phù hợp.</div>
        <?php endif; ?>
    </div>
    <div class="mt-10"><?php echo e($baiViet->links()); ?></div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\STUDY\Laravel\BARBER\CATTOC\resources\views/user/blog/index.blade.php ENDPATH**/ ?>