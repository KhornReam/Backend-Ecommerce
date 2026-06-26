@extends('admin.layout')

@section('title', 'Order #' . $order->id)

@section('content')

<style>
:root{
    --bg:#050816;
    --card:#111827;
    --card-dark:#0f172a;
    --border:rgba(255,255,255,.08);

    --text:#ffffff;
    --muted:#94a3b8;

    --primary:#4f46e5;
    --primary2:#2563eb;

    --success:#22c55e;
    --danger:#ef4444;
    --warning:#f59e0b;
}

/* ================= PAGE ================= */

.page{
    padding:24px;
    color:var(--text);
}

/* ================= HEADER ================= */

.page-header{
    display:flex;
    align-items:center;
    gap:12px;

    margin-bottom:24px;

    background:#0b1831;
    border:1px solid var(--border);

    border-radius:20px;
    padding:20px;

    box-shadow:0 15px 35px rgba(0,0,0,.25);
}

.back-btn{
    display:inline-flex;
    align-items:center;
    gap:6px;

    padding:8px 14px;

    border-radius:10px;

    background:#111827;
    border:1px solid var(--border);

    color:#cbd5e1;
    text-decoration:none;

    transition:.25s;
}

.back-btn:hover{
    background:#1e293b;
}

.page-title{
    font-size:24px;
    font-weight:700;
    color:#fff;
    margin:0;
}

.page-sub{
    font-size:13px;
    color:var(--muted);
    margin-top:4px;
}

/* ================= CARDS ================= */

.info-card,
.items-card{
    background:linear-gradient(
        180deg,
        #16182e,
        #111827
    );

    border-radius:24px;
    overflow:hidden;

    border:1px solid rgba(99,102,241,.18);

    box-shadow:
    0 20px 45px rgba(0,0,0,.30);

    margin-bottom:24px;
}

.card-header{
    padding:18px 24px;

    background:#0f172a;

    border-bottom:1px solid rgba(255,255,255,.06);
}

.card-header p{
    margin:0;

    color:#94a3b8;

    font-size:11px;
    font-weight:700;

    text-transform:uppercase;
    letter-spacing:.08em;
}

/* ================= INFO GRID ================= */

.info-grid{
    display:grid;
    grid-template-columns:repeat(5,1fr);
}

.info-item{
    padding:22px;
    border-right:1px solid rgba(255,255,255,.05);
}

.info-item:last-child{
    border-right:none;
}

.info-label{
    font-size:11px;
    color:#64748b;
    margin-bottom:6px;
}

.info-value{
    font-size:14px;
    font-weight:600;
    color:#fff;
}

.info-value.email{
    color:#cbd5e1;
    font-size:13px;
}

.info-value.total{
    color:#4ade80;
    font-size:18px;
    font-weight:700;
}

/* ================= BADGES ================= */

.badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;

    padding:6px 12px;

    border-radius:999px;

    font-size:11px;
    font-weight:700;
}

.pending{
    background:rgba(245,158,11,.15);
    color:#fbbf24;
}

.processing{
    background:rgba(99,102,241,.15);
    color:#818cf8;
}

.shipped{
    background:rgba(59,130,246,.15);
    color:#60a5fa;
}

.delivered{
    background:rgba(34,197,94,.15);
    color:#4ade80;
}

.cancelled{
    background:rgba(239,68,68,.15);
    color:#f87171;
}

/* ================= TABLE ================= */

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#0f172a;
}

thead th{
    padding:16px;

    text-align:left;

    color:#94a3b8;

    font-size:11px;
    font-weight:700;

    text-transform:uppercase;
    letter-spacing:.08em;

    border-bottom:1px solid rgba(255,255,255,.06);
}

tbody td{
    padding:16px;

    color:#e2e8f0;
    font-size:13px;

    border-bottom:1px solid rgba(255,255,255,.05);
}

tbody tr{
    transition:.25s;
}

tbody tr:hover{
    background:rgba(99,102,241,.06);
}

tbody tr:last-child td{
    border-bottom:none;
}

.prod-name{
    color:#fff;
    font-weight:600;
}

/* ================= TOTAL ROW ================= */

.total-row{
    background:#0f172a;
}

.total-row td{
    padding:18px 16px;
}

.total-label{
    text-align:right;

    color:#94a3b8;

    font-size:13px;
    font-weight:600;
}

.total-amount{
    color:#4ade80;

    font-size:18px;
    font-weight:700;
}

/* ================= SCROLLBAR ================= */

::-webkit-scrollbar{
    width:8px;
    height:8px;
}

::-webkit-scrollbar-track{
    background:#0f172a;
}

::-webkit-scrollbar-thumb{
    background:#334155;
    border-radius:10px;
}

/* ================= RESPONSIVE ================= */

@media(max-width:992px){

    .info-grid{
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:768px){

    .page{
        padding:16px;
    }

    .page-header{
        flex-direction:column;
        align-items:flex-start;
    }

    .info-grid{
        grid-template-columns:1fr;
    }

    .items-card{
        overflow-x:auto;
    }

    table{
        min-width:700px;
    }

    .page-title{
        font-size:20px;
    }
}
</style>

<div class="page">

    <div class="page-header">
        <a href="{{ route('admin.orders.index') }}" class="back-btn">← Orders</a>
        <div>
            <p class="page-title">Order #{{ $order->id }}</p>
            <p class="page-sub">Placed on {{ $order->created_at->format('Y-m-d') }} at {{ $order->created_at->format('H:i') }}</p>
        </div>
    </div>

    {{-- Summary card --}}
    <div class="info-card">
        <div class="card-header"><p>Order summary</p></div>
        <div class="info-grid">
            <div class="info-item">
                <p class="info-label">Customer</p>
                <p class="info-value">{{ $order->user->name ?? 'N/A' }}</p>
            </div>
            <div class="info-item">
                <p class="info-label">Email</p>
                <p class="info-value email">{{ $order->user->email ?? 'N/A' }}</p>
            </div>
            <div class="info-item">
                <p class="info-label">Status</p>
                <p class="info-value">
                    <span class="badge {{ $order->status }}">{{ ucfirst($order->status) }}</span>
                </p>
            </div>
            <div class="info-item">
                <p class="info-label">Order date</p>
                <p class="info-value">{{ $order->created_at->format('Y-m-d H:i') }}</p>
            </div>
            <div class="info-item">
                <p class="info-label">Total</p>
                <p class="info-value total">${{ number_format($order->total, 2) }}</p>
            </div>
        </div>
    </div>

    {{-- Items card --}}
    <div class="items-card">
        <div class="card-header"><p>Order items</p></div>

        @if($order->items->isEmpty())
            <p style="padding:1.25rem;font-size:13px;color:#6b7280;">No items in this order.</p>
        @else
            <table>
                <colgroup>
                    <col><col style="width:80px"><col style="width:70px"><col style="width:90px">
                </colgroup>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td><span class="prod-name">{{ $item->product->name ?? 'Deleted product' }}</span></td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <table style="border-top:1px solid #e5e7eb;">
                <colgroup>
                    <col><col style="width:80px"><col style="width:70px"><col style="width:90px">
                </colgroup>
                <tbody>
                    <tr class="total-row">
                        <td colspan="3" class="total-label">Order total</td>
                        <td class="total-amount">${{ number_format($order->total, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>

</div>

@endsection