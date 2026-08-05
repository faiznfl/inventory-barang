<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Mutasi Stok - Fixoria Sales</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #141b2b;
            margin: 0;
            padding: 24px;
            background-color: #ffffff;
            font-size: 13px;
            line-height: 1.4;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }
        .brand {
            font-size: 22px;
            font-weight: 800;
            color: #2563eb;
        }
        .subtitle {
            font-size: 14px;
            color: #474555;
            margin-top: 2px;
        }
        .meta-info {
            text-align: right;
            font-size: 12px;
            color: #585f6c;
        }
        .filter-info {
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            display: flex;
            gap: 24px;
            font-size: 12px;
        }
        .filter-info strong {
            color: #141b2b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #eff6ff;
            color: #474555;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            padding: 10px 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }
        th.text-right, td.text-right {
            text-align: right;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 12px;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-in {
            background-color: #dcfce7;
            color: #15803d;
        }
        .badge-out {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .summary-box {
            display: flex;
            justify-content: flex-end;
            gap: 32px;
            background-color: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 8px;
            padding: 12px 20px;
            margin-top: 16px;
        }
        .summary-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
        }
        .summary-item strong {
            font-size: 15px;
        }
        .text-primary { color: #2563eb; }
        .text-error { color: #dc2626; }
        .no-print {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        .btn-print {
            background-color: #2563eb;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" class="btn-print">Cetak / Simpan PDF</button>
    </div>

    <div class="header">
        <div>
            <div class="brand">Fixoria Sales</div>
            <div class="subtitle">Laporan Rekapitulasi Mutasi Stok</div>
        </div>
        <div class="meta-info">
            <div><strong>Dicetak pada:</strong> {{ now()->format('d M Y H:i') }}</div>
            <div><strong>Oleh:</strong> {{ auth()->user()->name ?? 'System Admin' }}</div>
        </div>
    </div>

    <div class="filter-info">
        <div>
            <strong>Rentang Tanggal:</strong>
            @if($startDate || $endDate)
                {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : 'Awal' }} - {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d M Y') : 'Sekarang' }}
            @else
                Semua Tanggal
            @endif
        </div>
        <div>
            <strong>Jenis Mutasi:</strong>
            @if($type === 'in') Barang Masuk @elseif($type === 'out') Barang Keluar @else Semua @endif
        </div>
        <div>
            <strong>Kategori:</strong> {{ $selectedCategory ?? 'Semua Kategori' }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>SKU</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Jenis</th>
                <th class="text-right">Qty</th>
                <th>User Input</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $index => $report)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $report->transaction_date ? $report->transaction_date->format('d/m/Y H:i') : ($report->created_at ? $report->created_at->format('d/m/Y H:i') : '-') }}</td>
                    <td><strong>{{ $report->product->sku ?? '-' }}</strong></td>
                    <td>{{ $report->product->name ?? '-' }}</td>
                    <td>{{ $report->product->category->name ?? '-' }}</td>
                    <td>
                        @if($report->type === 'in')
                            <span class="badge badge-in">Masuk</span>
                        @else
                            <span class="badge badge-out">Keluar</span>
                        @endif
                    </td>
                    <td class="text-right"><strong>{{ number_format($report->quantity) }}</strong></td>
                    <td>{{ $report->user->name ?? '-' }}</td>
                    <td>{{ $report->notes ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 24px; color: #585f6c;">
                        Tidak ada data transaksi mutasi stok sesuai kriteria filter.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary-box">
        <div class="summary-item">
            <span>Total Barang Masuk:</span>
            <strong class="text-primary">{{ number_format($totalInQty) }}</strong>
        </div>
        <div class="summary-item">
            <span>Total Barang Keluar:</span>
            <strong class="text-error">{{ number_format($totalOutQty) }}</strong>
        </div>
        <div class="summary-item">
            <span>Total Transaksi:</span>
            <strong>{{ number_format($reports->count()) }}</strong>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // Auto trigger print dialogue when opened
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
