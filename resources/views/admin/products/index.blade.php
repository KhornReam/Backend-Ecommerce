@extends('admin.layout')

@section('title', 'Products')

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

.wrap{
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

/* ================= ADD BUTTON ================= */

.btn-add{
    display:inline-flex;
    align-items:center;
    gap:8px;

    padding:12px 18px;

    border-radius:12px;

    background:linear-gradient(
        135deg,
        var(--primary2),
        var(--primary)
    );

    color:white;
    text-decoration:none;

    font-size:13px;
    font-weight:600;

    transition:.3s;

    box-shadow:
    0 10px 25px rgba(79,70,229,.35);
}

.btn-add:hover{
    transform:translateY(-2px);
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

/* ================= PRODUCT ================= */

.prod-name{
    color:white;
    font-size:14px;
    font-weight:600;

    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.prod-desc{
    margin-top:4px;

    color:#94a3b8;

    font-size:11px;

    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

/* ================= IMAGE ================= */

.img-thumb{
    width:48px;
    height:48px;

    border-radius:12px;

    object-fit:cover;

    border:1px solid rgba(255,255,255,.08);
}

.no-img{
    width:48px;
    height:48px;

    border-radius:12px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:#1e293b;

    color:#94a3b8;

    font-size:10px;
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

.badge-price{
    background:rgba(34,197,94,.15);
    color:#4ade80;
}

.badge-cat{
    background:rgba(59,130,246,.15);
    color:#60a5fa;
}

/* ================= STOCK ================= */

.stock-low{
    color:#f87171;
    font-weight:700;
}

.stock-normal{
    color:#4ade80;
    font-weight:600;
}

/* ================= ACTION BUTTONS ================= */

.action-wrap{
    display:flex;
    gap:8px;
}

.btn-edit,
.btn-del{
    border:none;

    padding:8px 12px;

    border-radius:10px;

    font-size:12px;
    font-weight:600;

    cursor:pointer;

    text-decoration:none;

    transition:.25s;
}

.btn-edit{
    background:rgba(59,130,246,.15);
    color:#60a5fa;
}

.btn-edit:hover{
    background:rgba(59,130,246,.25);
}

.btn-del{
    background:rgba(239,68,68,.15);
    color:#f87171;
}

.btn-del:hover{
    background:rgba(239,68,68,.25);
}

.delete-form{
    display:inline;
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

.page-links{
    display:flex;
    align-items:center;
    gap:8px;
}

.page-links a,
.page-links span{
    width:38px;
    height:38px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:10px;

    background:#111827;

    border:1px solid var(--border);

    color:#cbd5e1;

    text-decoration:none;

    transition:.25s;
}

.page-links a:hover{
    background:#1e293b;
}

.page-links .active,
.page-links span.current{
    background:linear-gradient(
        135deg,
        #2563eb,
        #4f46e5
    );

    color:white;
    border:none;
}

/* ================= EMPTY ================= */

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

@media (max-width:992px){

    .tbl-wrap{
        overflow-x:auto;
    }

    table{
        min-width:900px;
    }
}

@media (max-width:768px){

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

<div class="wrap">

    <div class="toolbar">
        <div>
            <h2>Products</h2>
            <p>{{ $products->total() }} total items</p>
        </div>

        <a href="{{ route('admin.products.create') }}" class="btn-add">
            + Add Product
        </a>
    </div>

    @if($products->isEmpty())

        <div class="tbl-wrap">
            <div class="empty-state">
                No products found. Start by adding your first product.
            </div>
        </div>

    @else

        <div class="tbl-wrap">
            <table>
                <colgroup>
                    <col style="width:60px">
                    <col>
                    <col style="width:100px">
                    <col style="width:120px">
                    <col style="width:60px">
                    <col style="width:80px">
                    <col style="width:140px">
                </colgroup>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td class="id-cell">#{{ $product->id }}</td>

                            <td>
                                <div class="prod-name">{{ $product->name }}</div>
                                <div class="prod-desc">{{ $product->description }}</div>
                            </td>

                            <td>
                                <span class="badge badge-price">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge badge-cat">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>

                            <td>
                                @if($product->image)
                                    <img class="img-thumb" src="{{ $product->image_url }}" alt="">
                                @else
                                    <div class="no-img">No img</div>
                                @endif
                            </td>

                            <td class="{{ $product->stock <= 10 ? 'stock-low' : '' }}">
                                {{ $product->stock }}
                            </td>

                            <td>
                                <div class="action-wrap">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-edit">Edit</a>

                                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                                          method="POST"
                                          class="delete-form"
                                          onsubmit="return confirm('Delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-del">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        <div class="pagination">
            <span class="pag-info">
                Showing {{ $products->firstItem() }}–{{ $products->lastItem() }}
                of {{ $products->total() }} items
            </span>

            <div class="page-links">
                {{ $products->links() }}
            </div>
        </div>

    @endif

</div>

@endsection