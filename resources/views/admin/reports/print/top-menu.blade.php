<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Menu Terlaris - Dinasti Sushi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; line-height: 1.5; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #f97316; padding-bottom: 20px; }
        .header h1 { font-size: 24px; color: #f97316; margin-bottom: 5px; }
        .header p { color: #666; }
        .period { background: #fff7ed; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #f9fafb; font-weight: 600; color: #374151; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .rank-1 { background: #fef3c7; }
        .rank-2 { background: #f3f4f6; }
        .rank-3 { background: #ffedd5; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #666; font-size: 11px; }
        @media print { body { print-color-adjust: exact; -webkit-print-color-adjust: exact; } }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Dinasti Sushi" style="height: 80px; margin-bottom: 10px;">
            <h1>Dinasti Sushi</h1>
            <p style="font-size: 11px; color: #666; margin-bottom: 5px;">Jl. Raya Cipanas No.58, Gadog, Kec. Pacet, Kabupaten Cianjur, Jawa Barat 43253</p>
            <p style="font-size: 14px; font-weight: bold; margin-top: 10px;">Laporan Menu Terlaris</p>
        </div>

        <div class="period">
            <strong>Periode:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
        </div>

        <h3 style="margin-bottom: 10px;">Ranking Menu</h3>
        <table>
            <thead>
                <tr>
                    <th class="text-center">Rank</th>
                    <th>Menu</th>
                    <th>Kategori</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Terjual</th>
                    <th class="text-right">Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topMenuItems as $index => $item)
                <tr class="{{ $index == 0 ? 'rank-1' : ($index == 1 ? 'rank-2' : ($index == 2 ? 'rank-3' : '')) }}">
                    <td class="text-center"><strong>{{ $index + 1 }}</strong></td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category }}</td>
                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right"><strong>{{ $item->total_sold }}</strong></td>
                    <td class="text-right">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="signature" style="text-align: right; margin-top: 50px; margin-bottom: 30px;">
            <p style="font-weight: bold;">MENGETAHUI</p>
            <p>Cipanas, {{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
            <br><br><br>
            <p style="font-weight: bold; text-decoration: underline;">Moh Ardi Kurniawan</p>
        </div>

        <div class="footer">
            <p>Dicetak pada: {{ now()->format('d M Y H:i:s') }}</p>
            <p>Dinasti Sushi - Sistem Rekomendasi Sushi Berbasis AI</p>
        </div>
    </div>
</body>
</html>
