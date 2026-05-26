

<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page_title', 'Dashboard quản trị'); ?>

<?php $__env->startSection('content'); ?>

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.82);
        backdrop-filter: blur(18px);
        border: 1px solid rgba(226, 232, 240, 0.85);
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
    }

    .soft-bg {
        background:
            radial-gradient(circle at 10% 15%, rgba(255, 111, 0, 0.10), transparent 28%),
            radial-gradient(circle at 90% 10%, rgba(15, 23, 42, 0.08), transparent 28%),
            linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%);
    }

    .kpi-icon {
        width: 46px;
        height: 46px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
    }
</style>

<div class="soft-bg -m-6 p-6 min-h-screen rounded-[2rem] relative overflow-hidden">

    <div class="absolute -top-16 -left-10 text-[260px] font-black text-slate-200/40 leading-none select-none">
        25
    </div>

    <div class="relative z-10 space-y-6">

        
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <p class="text-orange-500 font-semibold tracking-wide uppercase text-sm">
                    Barber Admin
                </p>
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 mt-1">
                    Dashboard
                </h1>
                <p class="text-slate-500 mt-2">
                    Tổng quan lịch hẹn, khách hàng, doanh thu và hiệu suất cửa hàng.
                </p>
            </div>

            <div class="px-5 py-3 rounded-2xl bg-slate-900 text-white shadow-lg">
                <p class="text-xs text-slate-300">Doanh thu hiện tại</p>
                <p class="text-xl font-bold"><?php echo e(number_format($tongDoanhThu)); ?>đ</p>
            </div>
        </div>

        
        <div class="glass-card rounded-[2rem] p-5">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <div>
                    <label class="text-sm font-semibold text-slate-700">Năm</label>
                    <input type="number" name="year" value="<?php echo e($year); ?>"
                           class="mt-2 w-full rounded-2xl border-slate-200 bg-white/80 focus:border-orange-500 focus:ring-orange-500">
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Tháng</label>
                    <select name="month"
                            class="mt-2 w-full rounded-2xl border-slate-200 bg-white/80 focus:border-orange-500 focus:ring-orange-500">
                        <option value="">Tất cả</option>
                        <?php for($i = 1; $i <= 12; $i++): ?>
                            <option value="<?php echo e($i); ?>" <?php if($month == $i): echo 'selected'; endif; ?>>
                                Tháng <?php echo e($i); ?>

                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Từ ngày</label>
                    <input type="date" name="from" value="<?php echo e($from); ?>"
                           class="mt-2 w-full rounded-2xl border-slate-200 bg-white/80 focus:border-orange-500 focus:ring-orange-500">
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Đến ngày</label>
                    <input type="date" name="to" value="<?php echo e($to); ?>"
                           class="mt-2 w-full rounded-2xl border-slate-200 bg-white/80 focus:border-orange-500 focus:ring-orange-500">
                </div>

                <button class="h-[44px] px-5 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-2xl shadow-lg shadow-orange-500/25 transition">
                    Lọc dữ liệu
                </button>
            </form>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
            <div class="glass-card rounded-[2rem] p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 font-medium">Tổng khách hàng</p>
                        <h2 class="text-4xl font-black text-slate-900 mt-2"><?php echo e(number_format($tongKhachHang)); ?></h2>
                    </div>
                    <div class="kpi-icon bg-orange-100 text-orange-600">KH</div>
                </div>
            </div>

            <div class="glass-card rounded-[2rem] p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 font-medium">Tổng lịch hẹn</p>
                        <h2 class="text-4xl font-black text-slate-900 mt-2"><?php echo e(number_format($tongLichHen)); ?></h2>
                    </div>
                    <div class="kpi-icon bg-slate-900 text-white">LH</div>
                </div>
            </div>

            <div class="glass-card rounded-[2rem] p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 font-medium">Lịch hôm nay</p>
                        <h2 class="text-4xl font-black text-slate-900 mt-2"><?php echo e(number_format($lichHomNay)); ?></h2>
                    </div>
                    <div class="kpi-icon bg-slate-100 text-slate-700">HN</div>
                </div>
            </div>

            <div class="glass-card rounded-[2rem] p-5 bg-slate-900 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-300 font-medium">Doanh thu</p>
                        <h2 class="text-3xl font-black mt-2"><?php echo e(number_format($tongDoanhThu)); ?>đ</h2>
                    </div>
                    <div class="kpi-icon bg-orange-500 text-white">DT</div>
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="glass-card rounded-[2rem] p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-black text-slate-900">Doanh thu theo tháng</h3>
                        <p class="text-sm text-slate-500">Theo dõi tăng trưởng doanh thu</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-xs font-bold">
                        Revenue
                    </span>
                </div>
                <canvas id="revenueChart" height="130"></canvas>
            </div>

            <div class="glass-card rounded-[2rem] p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-black text-slate-900">Trạng thái lịch hẹn</h3>
                        <p class="text-sm text-slate-500">Tỷ lệ xử lý lịch hẹn</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-slate-900 text-white text-xs font-bold">
                        Status
                    </span>
                </div>
                <canvas id="statusChart" height="130"></canvas>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="glass-card rounded-[2rem] p-5">
                <h3 class="text-xl font-black text-slate-900 mb-4">Top dịch vụ</h3>

                <div class="space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $topDichVu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex justify-between items-center rounded-2xl bg-white/70 border border-slate-100 px-4 py-3">
                            <span class="font-semibold text-slate-700"><?php echo e($item->ten_dich_vu); ?></span>
                            <strong class="px-3 py-1 rounded-full bg-orange-500 text-white text-sm">
                                <?php echo e($item->tong); ?> lượt
                            </strong>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-slate-500">Chưa có dữ liệu.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="glass-card rounded-[2rem] p-5">
                <h3 class="text-xl font-black text-slate-900 mb-4">Top thợ cắt tóc</h3>

                <div class="space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $topTho; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex justify-between items-center rounded-2xl bg-white/70 border border-slate-100 px-4 py-3">
                            <span class="font-semibold text-slate-700"><?php echo e($item->tho->ho_ten ?? 'Không rõ'); ?></span>
                            <strong class="px-3 py-1 rounded-full bg-slate-900 text-white text-sm">
                                <?php echo e($item->tong); ?> lịch
                            </strong>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-slate-500">Chưa có dữ liệu.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="glass-card rounded-[2rem] p-5">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-xl font-black text-slate-900">Lịch hẹn gần đây</h3>
                    <p class="text-sm text-slate-500">Danh sách lịch hẹn mới nhất</p>
                </div>

                <a href="<?php echo e(route('admin.lich-hen.index')); ?>"
                   class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-bold hover:bg-orange-500 transition">
                    Xem tất cả
                </a>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-100">
                <table class="w-full text-sm bg-white/70">
                    <thead>
                        <tr class="bg-slate-900 text-white text-left">
                            <th class="p-4">Mã</th>
                            <th class="p-4">Khách hàng</th>
                            <th class="p-4">Thợ</th>
                            <th class="p-4">Ngày</th>
                            <th class="p-4">Tổng tiền</th>
                            <th class="p-4">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $lichHenGanDay; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-t border-slate-100 hover:bg-orange-50/60 transition">
                                <td class="p-4 font-bold text-slate-900"><?php echo e($item->ma_lich_hen); ?></td>
                                <td class="p-4"><?php echo e($item->khachHang->ho_ten ?? '-'); ?></td>
                                <td class="p-4"><?php echo e($item->tho->ho_ten ?? '-'); ?></td>
                                <td class="p-4"><?php echo e($item->ngay_hen?->format('d/m/Y')); ?></td>
                                <td class="p-4 font-bold"><?php echo e(number_format($item->tong_tien)); ?>đ</td>
                                <td class="p-4">
                                    <?php if (isset($component)) { $__componentOriginal435aefee4aa6dd7f20df034696ae03b9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal435aefee4aa6dd7f20df034696ae03b9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge-status','data' => ['status' => $item->trang_thai]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->trang_thai)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal435aefee4aa6dd7f20df034696ae03b9)): ?>
<?php $attributes = $__attributesOriginal435aefee4aa6dd7f20df034696ae03b9; ?>
<?php unset($__attributesOriginal435aefee4aa6dd7f20df034696ae03b9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal435aefee4aa6dd7f20df034696ae03b9)): ?>
<?php $component = $__componentOriginal435aefee4aa6dd7f20df034696ae03b9; ?>
<?php unset($__componentOriginal435aefee4aa6dd7f20df034696ae03b9); ?>
<?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-500">
                                    Chưa có lịch hẹn.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const revenueData = <?php echo json_encode($chartDoanhThuThang, 15, 512) ?>;

    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
            datasets: [{
                label: 'Doanh thu',
                data: revenueData,
                tension: 0.45,
                fill: true,
                borderColor: '#ff6a00',
                backgroundColor: 'rgba(255, 106, 0, 0.14)',
                pointBackgroundColor: '#ff6a00',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 3,
                pointRadius: 5
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    grid: {
                        color: 'rgba(148, 163, 184, 0.18)'
                    },
                    ticks: {
                        callback: value => new Intl.NumberFormat('vi-VN').format(value) + 'đ'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    const statusData = <?php echo json_encode($trangThaiLichHen, 15, 512) ?>;

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(statusData),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: [
                    '#ff6a00',
                    '#020617',
                    '#94a3b8',
                    '#e2e8f0',
                    '#fb923c'
                ],
                borderColor: '#ffffff',
                borderWidth: 4
            }]
        },
        options: {
            cutout: '68%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 18
                    }
                }
            }
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\STUDY\Laravel\BARBER\CATTOC\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>