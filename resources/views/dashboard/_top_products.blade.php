{{-- Partial: dashboard/_top_products.blade.php
     Dipakai untuk server-side initial render di dashboard.blade.php --}}

@php $maxQty = $topProducts->max('total_qty') ?: 1; @endphp

@forelse($topProducts as $i => $product)
<div class="top-prod-row">
    <div class="rank-badge {{ $i === 0 ? 'rank-1' : ($i === 1 ? 'rank-2' : ($i === 2 ? 'rank-3' : 'rank-n')) }}">
        {{ $i + 1 }}
    </div>
    <div style="flex:1;min-width:0">
        <div style="font-size:13px;font-weight:600;color:#1c1c1e;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
            {{ $product->name }}
        </div>
        <div class="prog-bar">
            <div class="prog-fill" style="width:{{ round($product->total_qty / $maxQty * 100) }}%"></div>
        </div>
    </div>
    <div style="text-align:right;flex-shrink:0">
        <div style="font-size:12px;font-weight:700;color:#3d6b4f">{{ $product->total_qty }}x</div>
        <div style="font-size:11px;color:#9ca3af">Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</div>
    </div>
</div>
@empty
<div style="padding:40px 20px;text-align:center;color:#9ca3af">
    <i class="bi bi-inbox" style="font-size:32px;display:block;margin-bottom:8px"></i>
    <div style="font-size:13px">Belum ada penjualan hari ini</div>
</div>
@endforelse
