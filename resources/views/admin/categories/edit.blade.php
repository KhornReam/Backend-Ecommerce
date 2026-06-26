@extends('admin.layout')

@section('title', 'Edit Category')

@section('content')

<style>
   /* ===== BASE WRAPPER ===== */
.wrap {
    font-family: inherit;
    padding: 1.5rem;
    background: #0b1220; /* dark dashboard background */
    min-height: 100vh;
    color: #e5e7eb;
}

/* ===== HEADER ===== */
.toolbar {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 1.5rem;
}

.toolbar h2 {
    font-size: 20px;
    font-weight: 700;
    color: #f9fafb;
    margin: 0;
}

.toolbar p {
    font-size: 13px;
    color: #9ca3af;
    margin-top: 4px;
}

/* ===== BACK BUTTON ===== */
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    color: #9ca3af;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 16px;
    transition: 0.2s ease;
}

.btn-back:hover {
    color: #ffffff;
    transform: translateX(-2px);
}

/* ===== CARD ===== */
.form-card {
    background: #111827; /* dark card */
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    border: 1px solid #1f2937;
}

.card-header {
    padding: 16px 20px;
    border-bottom: 1px solid #1f2937;
    background: linear-gradient(135deg, #111827, #0b1220);
}

.card-body {
    padding: 22px;
}

/* ===== INFO GRID ===== */
.info-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-bottom: 22px;
}

.info-item {
    background: #0f172a;
    border: 1px solid #1f2937;
    border-radius: 12px;
    padding: 12px 14px;
    transition: 0.2s ease;
}

.info-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
}

.info-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #6b7280;
    margin-bottom: 5px;
}

.info-value {
    font-size: 14px;
    font-weight: 600;
    color: #f3f4f6;
}

/* ===== FORM ===== */
.form-group {
    margin-bottom: 18px;
}

label {
    display: block;
    margin-bottom: 6px;
    font-size: 13px;
    font-weight: 600;
    color: #d1d5db;
}

input {
    width: 100%;
    padding: 11px 12px;
    border-radius: 10px;
    border: 1px solid #374151;
    font-size: 13px;
    background: #0b1220;
    color: #f3f4f6;
    transition: 0.2s ease;
}

input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59,130,246,0.25);
}

.helper {
    margin-top: 6px;
    font-size: 12px;
    color: #6b7280;
}

/* ===== BUTTON ===== */
.btn-submit {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 11px 18px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s ease;
    box-shadow: 0 8px 20px rgba(34,197,94,0.25);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 26px rgba(34,197,94,0.35);
}

/* ===== ALERTS ===== */
.alert {
    margin-bottom: 16px;
    padding: 12px 14px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 500;
}

.alert-success {
    background: rgba(34,197,94,0.15);
    color: #22c55e;
    border: 1px solid rgba(34,197,94,0.3);
}

.alert-error {
    background: rgba(239,68,68,0.15);
    color: #ef4444;
    border: 1px solid rgba(239,68,68,0.3);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .info-grid {
        grid-template-columns: 1fr;
    }

    .toolbar {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}
</style>

<div class="wrap">

```
<a href="{{ route('admin.categories.index') }}" class="btn-back">
    ← Back to Categories
</a>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-error">
        <ul style="margin:0;padding-left:18px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="toolbar">
    <div>
        <h2>Edit Category</h2>
        <p>Update category information</p>
    </div>
</div>

<div class="form-card">

    <div class="card-header">
        Category Information
    </div>

    <div class="card-body">

        <div class="info-grid">

            <div class="info-item">
                <div class="info-label">Category ID</div>
                <div class="info-value">#{{ $category->id }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Products</div>
                <div class="info-value">
                    {{ $category->products_count ?? 0 }}
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">Created At</div>
                <div class="info-value">
                    {{ $category->created_at->format('Y-m-d') }}
                </div>
            </div>

        </div>

        <form method="POST"
              action="{{ route('admin.categories.update', $category->id) }}">

            @csrf
            @method('PUT')

            <div class="form-group">

                <label>Category Name</label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    placeholder="Enter category name"
                    required>

                <div class="helper">
                    Category slug can be generated automatically.
                </div>

            </div>

            <button type="submit" class="btn-submit">
                Update Category
            </button>

        </form>

    </div>

</div>


</div>

@endsection
