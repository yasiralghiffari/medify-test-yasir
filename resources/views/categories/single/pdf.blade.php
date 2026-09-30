<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Master Kategori {{ $category->kode }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
            color: #1a365d;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .meta-table td {
            padding: 4px 8px;
        }
        .meta-title {
            font-weight: bold;
            width: 120px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 1px solid #ccc;
            padding-top: 5px;
            font-size: 10px;
            color: #666;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN MASTER KATEGORI ITEMS</h2>
    </div>

    <table class="meta-table">
        <tr>
            <td class="meta-title">Nama Kategori</td>
            <td>: <strong>{{ $category->nama }}</strong></td>
        </tr>
        <tr>
            <td class="meta-title">Kode Kategori</td>
            <td>: <strong>{{ $category->kode }}</strong></td>
        </tr>
    </table>

    <h4 style="margin-bottom: 5px;">Daftar Item dalam Kategori Ini:</h4>
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Kode Item</th>
                <th>Nama Item</th>
                <th>Jenis</th>
                <th>Supplier</th>
                <th class="text-right">Harga Beli</th>
                <th class="text-right">Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            @forelse($category->masterItems as $index => $item)
                @php
                    $hargaJual = round($item->harga_beli + ($item->harga_beli * $item->laba / 100));
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ $item->supplier }}</td>
                    <td class="text-right">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($hargaJual, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; font-style: italic;">Tidak ada item pada kategori ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ $printed_at }}
    </div>
</body>
</html>
