@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('topbar-actions')
<a href="{{ route('transactions.print', $transaction) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
    <i class="bi bi-printer me-1"></i>Cetak Struk
</a>
<a href="{{ route('transactions.index') }}" class="btn btn-light btn-sm ms-1">
    <i class="bi bi-arrow-left me-1"></i>Kembali
</a>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-receipt me-2"></i>Item Transaksi</span>
                <span class="fw-bold" style="font-family:monospace;font-size:13px;color:#2f855a">
                    {{ $transaction->invoice_number }}
                </span>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->items as $item)
                        <tr>
                            <td>
                                <div class="fw-semibold" style="font-size:14px">{{ $item->product_name }}</div>
                            </td>
                            <td class="text-end" style="font-size:13px">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark">{{ $item->quantity }}</span>
                            </td>
                            <td class="text-end fw-semibold" style="color:#2f855a">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end fw-semibold">Subtotal</td>
                            <td class="text-end">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @if($transaction->discount > 0)
                        <tr>
                            <td colspan="3" class="text-end text-danger">Diskon</td>
                            <td class="text-end text-danger">- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="3" class="text-end fw-bold fs-6">Total</td>
                            <td class="text-end fw-bold fs-6" style="color:#2f855a">
                                Rp {{ number_format($transaction->total, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-info-circle me-2"></i>Info Transaksi</div>
            <div class="card-body">
                @php
                $rows = [
                    ['Invoice', $transaction->invoice_number],
                    ['Tanggal', $transaction->created_at->format('d M Y H:i')],
                    ['Kasir', $transaction->user->name],
                    ['Pelanggan', $transaction->customer_name ?: '—'],
                    ['Metode Bayar', strtoupper($transaction->payment_method)],
                    ['Dibayar', 'Rp ' . number_format($transaction->payment_amount, 0, ',', '.')],
                    ['Kembalian', 'Rp ' . number_format($transaction->change_amount, 0, ',', '.')],
                ];
                @endphp

                @foreach($rows as [$label, $value])
                <div class="d-flex justify-content-between py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <span class="text-muted" style="font-size:13px">{{ $label }}</span>
                    <span class="fw-semibold" style="font-size:13px">{{ $value }}</span>
                </div>
                @endforeach

                @if($transaction->notes)
                <div class="mt-3 pt-3 border-top">
                    <div class="text-muted mb-1" style="font-size:12px">Catatan:</div>
                    <div style="font-size:13px">{{ $transaction->notes }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
