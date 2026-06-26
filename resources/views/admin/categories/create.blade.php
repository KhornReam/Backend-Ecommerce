@extends('admin.layout')

@section('title', 'Create Category')

@section('content')

<style>
    :root {
    --primary: #22c55e;
    --primary-dark: #16a34a;

    --bg: #0b1220;
    --card: #111827;

    --border: #1f2937;
    --text: #f3f4f6;
    --muted: #9ca3af;

    --danger: #ef4444;
    --danger-bg: rgba(239,68,68,0.15);
}

/* ===== BODY ===== */
body {
    background: var(--bg);
    color: var(--text);
}

/* ===== CARD ===== */
.card {
    background: var(--card);
    padding: 22px;
    border-radius: 14px;
    box-shadow: 0 14px 35px rgba(0, 0, 0, 0.45);
    max-width: 520px;
    margin: 0 auto;
    border: 1px solid var(--border);
    transition: 0.2s ease;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 45px rgba(0, 0, 0, 0.55);
}

/* ===== LABEL ===== */
label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 6px;
}

/* ===== INPUT ===== */
input {
    width: 100%;
    padding: 11px 12px;
    border-radius: 10px;
    border: 1px solid var(--border);
    outline: none;
    transition: all 0.2s ease;
    margin-bottom: 14px;
    font-size: 13px;
    background: #0b1220;
    color: var(--text);
}

input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59,130,246,0.25);
}

/* ===== BUTTON ===== */
.btn {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    padding: 12px;
    border: none;
    border-radius: 10px;
    width: 100%;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: 0.2s ease;
    box-shadow: 0 8px 20px rgba(34,197,94,0.25);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(34,197,94,0.35);
}

/* ===== ALERT ===== */
.alert {
    padding: 12px 14px;
    border-radius: 10px;
    margin-bottom: 15px;
    font-size: 13px;
    font-weight: 500;
    border: 1px solid transparent;
}

.error {
    background: var(--danger-bg);
    color: var(--danger);
    border-color: rgba(239,68,68,0.3);
}

.success {
    background: rgba(34,197,94,0.12);
    color: #22c55e;
    border-color: rgba(34,197,94,0.25);
}

/* ===== HELPER TEXT ===== */
.helper-text {
    font-size: 12px;
    color: var(--muted);
    margin-top: -8px;
    margin-bottom: 14px;
}
</style>

<div class="card">

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert error">
            <ul style="margin:0;padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2 style="margin-bottom:15px;">Add Category</h2>

    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf

        <label>Category Name</label>
        <input type="text" name="name" placeholder="e.g. Electronics" required value="{{ old('name') }}">
        <p class="helper-text">URL-friendly slug will be generated automatically</p>

        <button class="btn">Save Category</button>
    </form>

</div>

@endsection