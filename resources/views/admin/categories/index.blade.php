@extends('admin.layout')

@section('title', 'Categories')

@section('content')

<style>
    .wrap{
    padding:24px;
    min-height:100vh;
    background:#050816;
    color:#fff;
}

/* ================= HEADER ================= */
.toolbar{
    display:flex;
    justify-content:space-between;
    align-items:flex-end;

    margin-bottom:24px;

    background:#0b1831;
    border:1px solid rgba(255,255,255,.08);

    border-radius:18px;
    padding:20px 24px;

    box-shadow:
    0 10px 30px rgba(0,0,0,.25);
}

.toolbar h2{
    font-size:24px;
    font-weight:700;
    color:#fff;
    margin:0;
}

.toolbar p{
    color:#94a3b8;
    font-size:13px;
    margin-top:5px;
}

/* ================= BUTTON ================= */
.btn-add{
    display:inline-flex;
    align-items:center;
    gap:8px;

    background:linear-gradient(
        135deg,
        #2563eb,
        #4f46e5
    );

    color:#fff;
    font-size:13px;
    font-weight:600;

    padding:12px 16px;

    border-radius:12px;
    text-decoration:none;

    box-shadow:
    0 10px 25px rgba(79,70,229,.35);

    transition:.25s;
}

.btn-add:hover{
    transform:translateY(-2px);
}

/* ================= ALERT ================= */
.alert{
    margin-bottom:16px;
    padding:14px 16px;
    border-radius:12px;
    font-size:13px;
}

.success{
    background:rgba(34,197,94,.12);
    color:#4ade80;
    border:1px solid rgba(34,197,94,.3);
}

.error{
    background:rgba(239,68,68,.12);
    color:#f87171;
    border:1px solid rgba(239,68,68,.3);
}

/* ================= TABLE CARD ================= */
.tbl-wrap{
    background:#111827;

    border-radius:20px;

    overflow:hidden;

    border:1px solid rgba(255,255,255,.08);

    box-shadow:
    0 15px 40px rgba(0,0,0,.25);
}

/* ================= TABLE ================= */
table{
    width:100%;
    border-collapse:collapse;
}

thead th{
    background:#0f172a;

    color:#94a3b8;

    font-size:11px;
    font-weight:600;

    text-transform:uppercase;
    letter-spacing:.08em;

    padding:16px;
    text-align:left;

    border-bottom:1px solid rgba(255,255,255,.08);
}

tbody td{
    padding:16px;
    font-size:13px;

    color:#e2e8f0;

    border-bottom:1px solid rgba(255,255,255,.05);

    vertical-align:middle;
}

tbody tr{
    transition:.25s;
}

tbody tr:hover{
    background:#1a2236;
}

tbody tr:last-child td{
    border-bottom:none;
}

/* ================= TEXT ================= */
.id-cell{
    color:#64748b;
    font-family:monospace;
    font-size:12px;
}

.category-name{
    color:#fff;
    font-size:14px;
    font-weight:600;
}

.slug{
    font-size:11px;
    color:#64748b;
    margin-top:4px;
}

/* ================= BADGE ================= */
.badge{
    display:inline-flex;
    align-items:center;

    padding:6px 12px;

    border-radius:999px;

    font-size:11px;
    font-weight:700;
}

.badge-products{
    background:rgba(59,130,246,.15);
    color:#60a5fa;
    border:1px solid rgba(59,130,246,.25);
}

/* ================= ACTION BUTTONS ================= */
.action-wrap{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
}

.btn-view,
.btn-edit,
.btn-del{
    padding:8px 12px;
    border-radius:10px;
    font-size:12px;
    font-weight:600;
    text-decoration:none;
    transition:.25s;
}

.btn-view{
    background:#1e293b;
    color:#cbd5e1;
}

.btn-view:hover{
    background:#334155;
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
    border:none;
    cursor:pointer;
}

.btn-del:hover{
    background:rgba(239,68,68,.25);
}

.delete-form{
    display:inline;
}

/* ================= EMPTY ================= */
.empty-state{
    text-align:center;
    padding:80px 20px;
    background:#111827;
    color:#94a3b8;
}

/* ================= RESPONSIVE ================= */
@media (max-width:768px){

    .toolbar{
        flex-direction:column;
        align-items:flex-start;
        gap:12px;
    }

    .action-wrap{
        flex-direction:column;
        align-items:flex-start;
    }

    .tbl-wrap{
        overflow-x:auto;
    }
}
</style>

<div class="wrap">

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    {{-- HEADER --}}
    <div class="toolbar">
        <div>
            <h2>Categories</h2>
            <p>{{ $categories->total() }} total categories</p>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="btn-add">
            + Add Category
        </a>
    </div>

    {{-- TABLE --}}
    @if($categories->isEmpty())
        <div class="tbl-wrap">
            <div class="empty-state">
                No categories found. Create your first category.
            </div>
        </div>
    @else
        <div class="tbl-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Products</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td class="id-cell">#{{ $category->id }}</td>

                            <td>
                                <div class="category-name">{{ $category->name }}</div>
                                <div class="slug">{{ $category->slug }}</div>
                            </td>

                            <td>
                                <span class="badge badge-products">
                                    {{ $category->products_count ?? 0 }} products
                                </span>
                            </td>

                            <td>
                                {{ $category->created_at->format('Y-m-d') }}
                            </td>

                            <td>
                                <div class="action-wrap">

                                    <a href="{{ route('admin.categories.show', $category->id) }}"
                                       class="btn-view">View</a>

                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                       class="btn-edit">Edit</a>

                                    <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                          method="POST"
                                          class="delete-form"
                                          onsubmit="return confirm('Delete this category?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-del">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div style="margin-top:1rem; font-size:12px; color:#64748b;">
            Showing {{ $categories->firstItem() }}–{{ $categories->lastItem() }}
            of {{ $categories->total() }} categories

            <div style="margin-top:8px;">
                {{ $categories->links() }}
            </div>
        </div>
    @endif

</div>

@endsection