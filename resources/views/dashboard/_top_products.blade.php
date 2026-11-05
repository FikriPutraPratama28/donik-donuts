{{-- Partial: dashboard/_top_products.blade.php --}}
@php $maxQty = $topProducts->max('total_qty') ?: 1; @endphp

@forelse($topProducts as $i => $product)
<div class="tp-row">
    <div class="tp-rank {{ $i===0?'tp-r1':($i===1?'tp-r2':($i===2?'tp-r3':'tp-rn')) }}">
        {{ $i + 1 }}
    </div>
    <div style="flex:1;min-width:0">
        <div style="font-size:13px;font-weight:600;color:var(--sk-heading);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
            {{ $product->name }}
        </div>
        <div class="tp-prog">
            <div class="tp-prog-fill" style="width:{{ round($product->total_qty/$maxQty*100) }}%"></div>
        </div>
    </div>
    <div style="text-align:right;flex-shrink:0">
        <div style="font-size:12px;font-weight:700;color:var(--sk-primary)">{{ $product->total_qty }}x</div>
        <div style="font-size:11px;color:var(--sk-muted)">Rp {{ number_format($product->total_revenue,0,',','.') }}</div>
    </div>
</div>
@empty
<div class="text-center py-5" style="color:var(--sk-muted)">
    <i class="bi bi-inbox" style="font-size:32px;display:block;margin-bottom:8px"></i>
    <div style="font-size:13px">Belum ada penjualan hari ini</div>
</div>
@endforelse
