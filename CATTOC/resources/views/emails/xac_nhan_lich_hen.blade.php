<h2>Xác nhận lịch hẹn</h2>
<p>Xin chào {{ $lichHen->khachHang->ho_ten ?? 'quý khách' }},</p>
<p>Lịch hẹn {{ $lichHen->ma_lich_hen }} của bạn đã được ghi nhận.</p>
<p>Thời gian: {{ $lichHen->ngay_hen?->format('d/m/Y') }} {{ $lichHen->gio_bat_dau?->format('H:i') }}.</p>
<p>Cảm ơn bạn đã sử dụng dịch vụ Barber House.</p>
