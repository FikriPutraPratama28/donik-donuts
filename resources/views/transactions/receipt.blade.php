@php
    $storeName   = \App\Models\Setting::get('store_name', 'Donik Donuts');
    $storeAddr   = \App\Models\Setting::get('store_address', '');
    $storePhone  = \App\Models\Setting::get('store_phone', '');
    $footerMsg   = \App\Models\Setting::get('receipt_footer', 'Terima kasih sudah berkunjung!');
    $logoPath    = \App\Models\Setting::get('store_logo_path', '');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk {{ $transaction->invoice_number }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 13px;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        .receipt { background:#fff; width:300px; padding:20px 16px; }
        .rh { text-align:center; margin-bottom:12px; }
        .rh img { height:48px; margin-bottom:6px; }
        .rh .brand { font-size:18px; font-weight:900; margin-bottom:3px; }
        .rh .sub { font-size:10px; color:#555; line-height:1.5; }
        .div { border-top:1px dashed #aaa; margin:8px 0; }
        .r { display:flex; justify-content:space-between; margin-bottom:3px; font-size:12px; }
        .r .l { color:#555; }
        table { width:100%; border-collapse:collapse; }
        td { padding:2px 0; font-size:12px; }
        td:last-child { text-align:right; }
        .total-row { font-weight:bold; font-size:14px; }
        .footer { text-align:center; margin-top:14px; font-size:11px; color:#555; line-height:1.6; }
        .btn-print { display:block; margin:0 auto 16px; padding:8px 24px;
            background:#2f855a; color:#fff; border:none; border-radius:8px;
            font-size:13px; font-weight:700; cursor:pointer; }
        @media print {
            body { background:none; padding:0; }
            .receipt { width:100%; }
            .no-print { display:none; }
        }
    </style>
</head>
<body>

<div class="no-print" style="text-align:center;margin-bottom:12px">
    <button class="btn-print" onclick="window.print()">
        Cetak Struk
    </button>
</div>

<div class="receipt">
    {{-- Header --}}
    <div class="rh">
        @if($logoPath && file_exists(public_path($logoPath)))
            <img src="{{ asset($logoPath) }}" alt="Logo">
        @else
            <svg width="40" height="40" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-bottom:6px">
                <circle cx="22" cy="22" r="22" fill="#d4522a"/>
                <circle cx="22" cy="22" r="18" fill="#ffffff"/>
                <circle cx="22" cy="22" r="11" fill="#f97316" stroke="#d4522a" stroke-width="1.5"/>
                <circle cx="22" cy="22" r="5" fill="#ffffff"/>
                <rect x="16" y="12" width="3" height="1.5" rx="0.75" fill="#ec4899" transform="rotate(-30 16 12)"/>
                <rect x="26" y="13" width="3" height="1.5" rx="0.75" fill="#3b82f6" transform="rotate(20 26 13)"/>
                <rect x="29" y="21" width="3" height="1.5" rx="0.75" fill="#22c55e" transform="rotate(-10 29 21)"/>
                <rect x="26" y="29" width="3" height="1.5" rx="0.75" fill="#f59e0b" transform="rotate(40 26 29)"/>
                <rect x="16" y="30" width="3" height="1.5" rx="0.75" fill="#ec4899" transform="rotate(-20 16 30)"/>
                <rect x="12" y="22" width="3" height="1.5" rx="0.75" fill="#a855f7" transform="rotate(10 12 22)"/>
                <text x="22" y="24.5" text-anchor="middle" font-family="Arial Black,sans-serif" font-weight="900" font-size="5.5" fill="#7c2d12">DONIK</text>
                <text x="22" y="30.5" text-anchor="middle" font-family="Arial Black,sans-serif" font-weight="900" font-size="4" fill="#7c2d12">DONUTS</text>
            </svg>
        @endif
        <div class="brand">{{ $storeName }}</div>
        @if($storeAddr)
        <div class="sub">{{ $storeAddr }}</div>
        @endif
        @if($storePhone)
        <div class="sub">Telp: {{ $storePhone }}</div>
        @endif
    </div>

    <div class="div"></div>

    {{-- Info Transaksi --}}
    <div class="r"><span class="l">Invoice</span><span>{{ $transaction->invoice_number }}</span></div>
    <div class="r"><span class="l">Tanggal</span><span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span></div>
    <div class="r"><span class="l">Kasir</span><span>{{ $transaction->user->name }}</span></div>
    @if($transaction->customer_name)
    <div class="r"><span class="l">Pelanggan</span><span>{{ $transaction->customer_name }}</span></div>
    @endif

    <div class="div"></div>

    {{-- Item --}}
    <table>
        @foreach($transaction->items as $item)
        <tr><td colspan="2"><strong>{{ $item->product_name }}</strong></td></tr>
        <tr>
            <td>{{ $item->quantity }} x {{ number_format($item->price, 0, ',', '.') }}</td>
            <td>{{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="div"></div>

    {{-- Summary --}}
    <div class="r"><span>Subtotal</span><span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span></div>
    @if($transaction->discount > 0)
    <div class="r"><span>Diskon</span><span>- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span></div>
    @endif
    <div class="div"></div>
    <div class="r total-row"><span>TOTAL</span><span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span></div>
    <div class="r"><span style="text-transform:uppercase">{{ $transaction->payment_method }}</span>
        <span>Rp {{ number_format($transaction->payment_amount, 0, ',', '.') }}</span></div>
    @if($transaction->change_amount > 0)
    <div class="r"><span>Kembalian</span><span>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span></div>
    @endif

    <div class="div"></div>

    {{-- Footer --}}
    <div class="footer">
        {{ $footerMsg }}
    </div>
</div>

<script>
    window.addEventListener('load', function(){ setTimeout(function(){ window.print(); }, 500); });
</script>
</body>
</html>
