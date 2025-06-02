<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h3>📩 Thư mời phỏng vấn</h3>
    <p>Xin chào <strong>{{ $details['full_name'] }}</strong>,</p>

    <p>Bạn đã được mời tham gia phỏng vấn tại vị trí: <strong>{{ $details['position'] }}</strong>.</p>

    <p><strong>⏰ Thời gian:</strong> {{ \Carbon\Carbon::parse($details['interview_time'])->format('H:i d/m/Y') }}</p>

    @if (!empty($details['note']))
    <p><strong>📌 Ghi chú:</strong> {{ $details['note'] }}</p>
    @endif

    <p>Vui lòng xác nhận lại với chúng tôi qua email này.</p>

    <br>
    <p>Trân trọng,<br><strong>Công ty MT Á Châu</strong></p>
</body>
</html>
