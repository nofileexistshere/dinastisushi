<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rating - Dinasti Sushi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; line-height: 1.5; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #f97316; padding-bottom: 20px; }
        .header h1 { font-size: 24px; color: #f97316; margin-bottom: 5px; }
        .header p { color: #666; }
        .period { background: #fff7ed; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        .summary { display: flex; justify-content: center; gap: 40px; margin-bottom: 30px; }
        .summary-item { text-align: center; }
        .summary-item .value { font-size: 20px; font-weight: bold; color: #f97316; }
        .summary-item .label { font-size: 11px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #f9fafb; font-weight: 600; color: #374151; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .stars { color: #f59e0b; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #666; font-size: 11px; }
        @media print { body { print-color-adjust: exact; -webkit-print-color-adjust: exact; } }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Dinasti Sushi" style="height: 80px; margin-bottom: 10px;">
            <h1>Dinasti Sushi</h1>
            <p>Laporan Rating</p>
        </div>

        <div class="period">
            <strong>Periode:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
        </div>

        <div class="summary">
            <div class="summary-item">
                <div class="value">{{ $ratings->count() }}</div>
                <div class="label">Total Rating</div>
            </div>
            <div class="summary-item">
                <div class="value">{{ number_format($averageRating, 1) }} ★</div>
                <div class="label">Rata-rata Rating</div>
            </div>
        </div>

        <h3 style="margin-bottom: 10px;">Detail Rating</h3>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Menu</th>
                    <th class="text-center">Rating</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ratings as $rating)
                <tr>
                    <td>{{ $rating->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $rating->user->name ?? '-' }}</td>
                    <td>{{ $rating->menuItem->name ?? '-' }}</td>
                    <td class="text-center stars">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $rating->rating ? '★' : '☆' }}
                        @endfor
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Dicetak pada: {{ now()->format('d M Y H:i:s') }}</p>
            <p>Dinasti Sushi - Sistem Rekomendasi Sushi Berbasis AI</p>
        </div>
    </div>
</body>
</html>
