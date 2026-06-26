@extends('admin.layout')

@section('title', 'Orders')

@section('content')

<style>
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
    min-height:100vh;
    color:var(--text);
}

/* ================= HEADER ================= */

.toolbar{
    display:flex;
    justify-content:space-between;
    align-items:flex-end;

    margin-bottom:24px;

    background:#0b1831;
    border:1px solid var(--border);

    border-radius:20px;

    padding:22px 24px;

    box-shadow:
    0 15px 35px rgba(0,0,0,.25);
}

.toolbar h2{
    margin:0;
    font-size:28px;
    font-weight:700;
    color:white;
}

.toolbar p{
    margin-top:5px;
    font-size:13px;
    color:var(--muted);
}

/* ================= TABLE CARD ================= */

.tbl-wrap{
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

    color:#94a3b8;

    font-size:11px;
    font-weight:700;

    text-transform:uppercase;
    letter-spacing:.08em;

    text-align:left;

    border-bottom:1px solid var(--border);
}

tbody td{
    padding:16px;

    color:#e2e8f0;

    font-size:13px;

    border-bottom:1px solid rgba(255,255,255,.05);

    vertical-align:middle;
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

/* ================= ID ================= */

.id-cell{
    color:#64748b;
    font-family:monospace;
    font-size:12px;
}

/* ================= CUSTOMER ================= */

.user-name{
    font-weight:600;
    color:white;
    font-size:13px;
}

.email-cell{
    color:#94a3b8;
    font-size:12px;

    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

/* ================= TOTAL ================= */

.total-cell{
    font-size:14px;
    font-weight:700;
    color:#4ade80;
}

/* ================= DATE ================= */

.date-cell{
    color:#94a3b8;
    font-size:12px;
}

/* ================= STATUS ================= */

.status-select{
    width:100%;

    background:#1e293b;
    color:white;

    border:1px solid rgba(255,255,255,.08);

    border-radius:10px;

    padding:8px 10px;

    font-size:12px;

    outline:none;

    transition:.25s;
}

.status-select:focus{
    border-color:#4f46e5;

    box-shadow:
    0 0 0 4px rgba(79,70,229,.15);
}

/* ================= STATUS COLORS ================= */

.status-pending{
    color:#fbbf24;
}

.status-processing{
    color:#60a5fa;
}

.status-completed{
    color:#4ade80;
}

.status-cancelled{
    color:#f87171;
}

/* ================= VIEW BUTTON ================= */

.btn-view{
    display:inline-flex;
    align-items:center;
    justify-content:center;

    padding:8px 12px;

    border-radius:10px;

    background:rgba(59,130,246,.15);

    color:#60a5fa;

    text-decoration:none;

    font-size:12px;
    font-weight:600;

    transition:.25s;
}

.btn-view:hover{
    background:rgba(59,130,246,.25);

    transform:translateY(-1px);
}

/* ================= PAGINATION ================= */

.pagination{
    margin-top:24px;

    display:flex;
    justify-content:space-between;
    align-items:center;
}

.pag-info{
    color:#94a3b8;
    font-size:12px;
}

.pag-links{
    display:flex;
    align-items:center;
    gap:8px;
}

.pag-links a,
.pag-links span{
    width:38px;
    height:38px;

    display:flex;
    align-items:center;
    justify-content:center;

    text-decoration:none;

    border-radius:10px;

    background:#111827;

    border:1px solid var(--border);

    color:#cbd5e1;

    transition:.25s;
}

.pag-links a:hover{
    background:#1e293b;
}

.pag-links .active,
.pag-links span.current{
    background:linear-gradient(
        135deg,
        #2563eb,
        #4f46e5
    );

    color:white;
    border:none;
}

/* ================= EMPTY STATE ================= */

.empty-state{
    text-align:center;

    padding:90px 20px;

    color:#94a3b8;

    font-size:14px;
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

    .tbl-wrap{
        overflow-x:auto;
    }

    table{
        min-width:1000px;
    }
}

@media(max-width:768px){

    .toolbar{
        flex-direction:column;
        align-items:flex-start;
        gap:12px;
    }

    .toolbar h2{
        font-size:24px;
    }

    .pagination{
        flex-direction:column;
        gap:15px;
    }
}

</style>
</style>

<div class="page">

    <div class="toolbar">
        <div>
            <h2>Orders</h2>
            <p>{{ $orders->total() }} total orders</p>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="tbl-wrap">
            <div class="empty-state">No orders found.</div>
        </div>
    @else

        <div class="tbl-wrap">
            <table>
                <colgroup>
                    <col style="width:60px">
                    <col style="width:140px">
                    <col>
                    <col style="width:90px">
                    <col style="width:140px">
                    <col style="width:100px">
                    <col style="width:80px">
                </colgroup>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td class="id-cell">#{{ $order->id }}</td>

                            <td>
                                <div class="user-name">
                                    {{ $order->user->name ?? 'N/A' }}
                                </div>
                            </td>

                            <td>
                                <div class="email-cell">
                                    {{ $order->user->email ?? 'N/A' }}
                                </div>
                            </td>

                            <td class="total-cell">
                                ${{ number_format($order->total, 2) }}
                            </td>

                            <td>
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <select name="status"
                                            class="status-select"
                                            onchange="this.form.submit()">

                                        @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                                            <option value="{{ $s }}"
                                                {{ $order->status === $s ? 'selected' : '' }}>
                                                {{ ucfirst($s) }}
                                            </option>
                                        @endforeach

                                    </select>
                                </form>
                            </td>

                            <td class="date-cell">
                                {{ $order->created_at->format('Y-m-d') }}
                            </td>

                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-view">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        <div class="pagination">
            <span class="pag-info">
                Showing {{ $orders->firstItem() }}–{{ $orders->lastItem() }}
                of {{ $orders->total() }} orders
            </span>

            <div class="pag-links">
                {{ $orders->links() }}
            </div>
        </div>

    @endif

</div>

@endsection