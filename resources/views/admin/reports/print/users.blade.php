<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengguna - Dinasti Sushi</title>
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
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #666; font-size: 11px; }
        @media print { body { print-color-adjust: exact; -webkit-print-color-adjust: exact; } }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Dinasti Sushi" style="height: 80px; margin-bottom: 10px;">
            <h1>Dinasti Sushi</h1>
            <p>Laporan Pengguna</p>
        </div>

        <div class="period">
            <strong>Periode:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
        </div>

        <h3 style="margin-bottom: 10px;">Daftar Pengguna</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th class="text-right">Pesanan</th>
                    <th class="text-right">Total Belanja</th>
                    <th>Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>#{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="text-right">{{ $user->orders_count }}</td>
                    <td class="text-right">Rp {{ number_format($user->orders_sum_total_price ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
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
