<footer class="mt-20 border-t border-white/10 bg-black/70">
    <div class="bh-container py-12">
        <div class="bh-section-dark p-6 md:p-10">
            <div class="grid gap-10 lg:grid-cols-[1.15fr_.65fr_.5fr]">
                <div>
                    <p class="bh-eyebrow">Barber House</p>
                    <h2 class="mt-5 max-w-3xl text-4xl font-black leading-[.95] tracking-[-.06em] text-white md:text-6xl">
                        Không chỉ là cắt tóc. Đây là nơi bạn nâng cấp <span class="bh-gradient-text">thần thái</span>.
                    </h2>
                    <p class="mt-5 max-w-2xl text-zinc-400">Đặt lịch nhanh, chọn barber phù hợp, thanh toán linh hoạt và mua sản phẩm chăm sóc tóc trong một trải nghiệm liền mạch.</p>
                </div>
                <div>
                    <h3 class="font-black text-white">Khám phá</h3>
                    <div class="mt-4 grid gap-2 text-sm font-bold text-zinc-400">
                        <a class="hover:text-white" href="<?php echo e(route('public.dich-vu.index')); ?>">Dịch vụ cắt tóc nam</a>
                        <a class="hover:text-white" href="<?php echo e(route('public.tho-cat-toc.index')); ?>">Đội ngũ barber</a>
                        <a class="hover:text-white" href="<?php echo e(route('public.san-pham.index')); ?>">Sản phẩm chăm sóc tóc</a>
                        <a class="hover:text-white" href="<?php echo e(route('public.blog.index')); ?>">Blog kiểu tóc nam</a>
                        <a class="hover:text-white" href="<?php echo e(route('public.cua-hang.index')); ?>">Hệ thống cửa hàng</a>
                    </div>
                </div>
                <div>
                    <h3 class="font-black text-white">Giờ mở cửa</h3>
                    <p class="mt-4 text-sm font-bold text-zinc-400">08:00 - 18:00<br>Thứ 2 - Chủ nhật</p>
                    <a href="<?php echo e(route('public.dat-lich.index')); ?>" class="bh-btn-primary mt-6 w-full">Đặt lịch</a>
                </div>
            </div>
        </div>
        <div class="flex flex-col justify-between gap-3 py-6 text-sm text-zinc-500 md:flex-row">
            <p>© <?php echo e(date('Y')); ?> Barber House. Premium barber booking website.</p>
            <p>Designed with dark neon agency style.</p>
        </div>
    </div>
</footer>
<?php /**PATH D:\STUDY\Laravel\BARBER\CATTOC\resources\views/user/layouts/footer.blade.php ENDPATH**/ ?>