@extends('admin.layout')

@section('title', 'Edit Product')

@section('content')

<style>
 :root {
    --primary: #1D9E75;
    --primary-dark: #0F6E56;
    --blue: #3b82f6;
    --blue-light: rgba(59,130,246,0.15);

    --danger: #ef4444;
    --danger-bg: rgba(239,68,68,0.15);

    --border: #1f2937;
    --text: #f3f4f6;
    --muted: #9ca3af;

    --bg: #0b1220;
    --card: #111827;
}

/* PAGE */
.page {
    font-family: inherit;
    max-width: 720px;
    margin: 0 auto;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
    padding: 16px;
}

/* HEADER */
.page-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 18px;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    padding: 6px 10px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: var(--card);
    color: var(--muted);
    text-decoration: none;
    transition: .2s;
}

.back-btn:hover {
    background: #0f172a;
    transform: translateY(-1px);
    color: var(--text);
}

.page-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--text);
    margin: 0;
}

.page-sub {
    font-size: 12px;
    color: var(--muted);
}

/* ALERT */
.alert {
    padding: 10px 12px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 12px;
}

.alert-error {
    background: var(--danger-bg);
    color: var(--danger);
    border: 1px solid rgba(239,68,68,0.3);
}

.alert-success {
    background: rgba(34,197,94,0.12);
    color: #22c55e;
    border: 1px solid rgba(34,197,94,0.25);
}

/* CARD */
.form-card {
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    background: var(--card);
    box-shadow: 0 12px 30px rgba(0,0,0,0.4);
}

.form-section {
    padding: 18px;
    border-bottom: 1px solid var(--border);
}

.section-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--muted);
    margin-bottom: 12px;
}

/* GRID */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

.field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.field.full {
    grid-column: span 2;
}

label {
    font-size: 12px;
    color: var(--text);
    font-weight: 500;
}

/* INPUTS */
input, select, textarea {
    padding: 10px 12px;
    border-radius: 10px;
    border: 1px solid var(--border);
    font-size: 13px;
    outline: none;
    transition: .2s;
    background: #0b1220;
    color: var(--text);
}

input:focus, select:focus, textarea:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px var(--blue-light);
}

textarea {
    min-height: 90px;
    resize: vertical;
}

/* PRICE INPUT */
.input-prefix {
    display: flex;
    border: 1px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
    background: #0b1220;
}

.input-prefix span {
    padding: 10px;
    background: #0f172a;
    color: var(--muted);
    border-right: 1px solid var(--border);
    font-size: 13px;
}

.input-prefix input {
    border: none;
    flex: 1;
    background: transparent;
}

/* IMAGE */
.image-row {
    display: flex;
    gap: 16px;
    align-items: center;
}

.img-preview-box {
    width: 110px;
    height: 110px;
    border-radius: 12px;
    border: 1px dashed var(--border);
    background: #0b1220;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.img-preview-label {
    font-size: 11px;
    color: var(--muted);
}

.file-upload-label {
    display: inline-flex;
    padding: 8px 12px;
    border-radius: 10px;
    font-size: 12px;
    color: var(--blue);
    background: rgba(59,130,246,0.12);
    border: 1px solid rgba(59,130,246,0.25);
    cursor: pointer;
}

.file-upload-label:hover {
    background: rgba(59,130,246,0.2);
}

input[type="file"] {
    display: none;
}

/* FOOTER */
.form-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 14px 18px;
    background: #0b1220;
    border-top: 1px solid var(--border);
}

.btn-cancel {
    padding: 9px 14px;
    border-radius: 10px;
    border: 1px solid var(--border);
    background: var(--card);
    color: var(--text);
    text-decoration: none;
    font-size: 13px;
}

.btn-save {
    padding: 9px 16px;
    border-radius: 10px;
    border: none;
    background: var(--primary);
    color: white;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}

.btn-save:hover {
    background: var(--primary-dark);
}

/* MOBILE */
@media(max-width:768px){
    .form-grid {
        grid-template-columns: 1fr;
    }

    .field.full {
        grid-column: span 1;
    }

    .image-row {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<div class="page">

    <div class="page-header">
        <a href="{{ route('admin.products.index') }}" class="back-btn">← Back</a>
        <div>
            <p class="page-title">Edit Product</p>
            <p class="page-sub">{{ $product->name }} · #{{ $product->id }}</p>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-card">

            <div class="form-section">
                <div class="section-label">Basic Information</div>

                <div class="form-grid">

                    <div class="field full">
                        <label>Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}">
                    </div>

                    <div class="field">
                        <label>Price</label>
                        <div class="input-prefix">
                            <span>$</span>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}">
                        </div>
                    </div>

                    <div class="field">
                        <label>Stock</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}">
                    </div>

                    <div class="field full">
                        <label>Category</label>
                        <select name="category_id">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field full">
                        <label>Description</label>
                        <textarea name="description">{{ old('description', $product->description) }}</textarea>
                    </div>

                </div>
            </div>

            <div class="form-section">
                <div class="section-label">Product Image</div>

                <div class="image-row">

                    <div class="img-preview-box" id="previewBox">
                        @if($product->image)
                            <img src="{{ $product->image_url }}">
                        @else
                            <span class="img-preview-label">No image</span>
                        @endif
                    </div>

                    <div>
                        <label class="file-upload-label" for="image">Upload Image</label>
                        <input type="file" id="image" name="image">

                        <div style="font-size:11px;color:#6b7280;margin-top:6px;">
                            JPG, PNG, WebP
                        </div>
                    </div>

                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.products.index') }}" class="btn-cancel">Cancel</a>
                <button class="btn-save">Save Changes</button>
            </div>

        </div>
    </form>
</div>

<script>
document.getElementById('image').addEventListener('change', function(e){
    const file = e.target.files[0];
    if(!file) return;

    const reader = new FileReader();
    reader.onload = function(ev){
        document.getElementById('previewBox').innerHTML =
            `<img src="${ev.target.result}">`;
    };
    reader.readAsDataURL(file);
});
</script>

@endsection