@extends('admin.layout')

@section('title', 'Create Product')

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
}

/* ================= PAGE ================= */

.page{
    max-width:900px;
    margin:0 auto;
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
}

.back-btn{
    padding:8px 14px;

    border-radius:10px;

    text-decoration:none;

    background:#111827;
    border:1px solid var(--border);

    color:#cbd5e1;

    transition:.25s;
}

.back-btn:hover{
    background:#1e293b;
}

.page-title{
    font-size:24px;
    font-weight:700;
    color:white;
    margin:0;
}

.page-sub{
    margin-top:4px;
    color:var(--muted);
    font-size:13px;
}

/* ================= ALERT ================= */

.alert{
    padding:14px 16px;
    border-radius:12px;
    margin-bottom:16px;
    font-size:13px;
}

.alert-error{
    background:rgba(239,68,68,.15);
    color:#f87171;
    border:1px solid rgba(239,68,68,.25);
}

.alert-success{
    background:rgba(34,197,94,.15);
    color:#4ade80;
    border:1px solid rgba(34,197,94,.25);
}

/* ================= CARD ================= */

.form-card{
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

/* ================= SECTIONS ================= */

.form-section{
    padding:24px;
    border-bottom:1px solid rgba(255,255,255,.06);
}

.form-section:last-child{
    border-bottom:none;
}

.section-label{
    font-size:11px;
    font-weight:700;

    letter-spacing:.08em;

    color:#60a5fa;

    text-transform:uppercase;

    margin-bottom:18px;
}

/* ================= GRID ================= */

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
}

.field.full{
    grid-column:span 2;
}

@media(max-width:768px){

    .form-grid{
        grid-template-columns:1fr;
    }

    .field.full{
        grid-column:span 1;
    }
}

/* ================= LABEL ================= */

label{
    display:block;

    margin-bottom:8px;

    font-size:12px;
    font-weight:600;

    color:#e2e8f0;
}

/* ================= INPUTS ================= */

input,
select,
textarea{
    width:100%;

    padding:12px 14px;

    border-radius:12px;

    background:#0f172a;

    color:white;

    border:1px solid rgba(255,255,255,.08);

    outline:none;

    transition:.25s;
}

input:focus,
select:focus,
textarea:focus{
    border-color:#4f46e5;

    box-shadow:
    0 0 0 4px rgba(79,70,229,.15);
}

textarea{
    min-height:120px;
    resize:vertical;
}

/* ================= PRICE ================= */

.input-prefix{
    display:flex;

    border-radius:12px;
    overflow:hidden;

    border:1px solid rgba(255,255,255,.08);
}

.input-prefix span{
    padding:12px 14px;

    background:rgba(79,70,229,.15);

    color:#818cf8;

    font-weight:700;
}

.input-prefix input{
    border:none;
    border-radius:0;
}

/* ================= IMAGE ================= */

.image-row{
    display:flex;
    align-items:center;
    gap:18px;
}

.img-preview-box{
    width:120px;
    height:120px;

    border-radius:16px;

    border:2px dashed rgba(255,255,255,.12);

    background:#0f172a;

    display:flex;
    align-items:center;
    justify-content:center;

    color:#94a3b8;
    font-size:12px;

    overflow:hidden;
}

.img-preview-box img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* ================= FILE UPLOAD ================= */

.file-upload-label{
    display:inline-flex;
    align-items:center;

    padding:10px 14px;

    border-radius:12px;

    background:rgba(59,130,246,.15);

    color:#60a5fa;

    border:1px solid rgba(59,130,246,.20);

    font-size:12px;
    font-weight:600;

    cursor:pointer;

    transition:.25s;
}

.file-upload-label:hover{
    background:rgba(59,130,246,.25);
}

input[type="file"]{
    display:none;
}

.upload-hint{
    margin-top:8px;
    color:#94a3b8;
    font-size:11px;
}

/* ================= FOOTER ================= */

.form-footer{
    display:flex;
    justify-content:flex-end;
    gap:12px;

    padding:20px;

    background:#0f172a;
}

/* CANCEL */

.btn-cancel{
    padding:12px 16px;

    border-radius:12px;

    text-decoration:none;

    background:#1e293b;

    border:1px solid rgba(255,255,255,.08);

    color:#cbd5e1;

    font-size:13px;
    font-weight:600;
}

/* SAVE */

.btn-save{
    padding:12px 18px;

    border:none;

    border-radius:12px;

    background:linear-gradient(
        135deg,
        #2563eb,
        #4f46e5
    );

    color:white;

    font-size:13px;
    font-weight:700;

    cursor:pointer;

    transition:.25s;

    box-shadow:
    0 10px 25px rgba(79,70,229,.35);
}

.btn-save:hover{
    transform:translateY(-2px);
}
</style>

<div class="page">

    <div class="page-header">
        <a href="{{ route('admin.products.index') }}" class="back-btn">← Back</a>
        <div>
            <p class="page-title">Create Product</p>
            <p class="page-sub">Add new product with modern UI</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0;padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-card">

            <div class="form-section">
                <div class="section-label">Basic Information</div>

                <div class="form-grid">

                    <div class="field full">
                        <label>Product Name</label>
                        <input type="text" name="name" value="{{ old('name') }}">
                    </div>

                    <div class="field">
                        <label>Price</label>
                        <div class="input-prefix">
                            <span>$</span>
                            <input type="number" step="0.01" name="price">
                        </div>
                    </div>

                    <div class="field">
                        <label>Stock</label>
                        <input type="number" name="stock">
                    </div>

                    <div class="field full">
                        <label>Category</label>
                        <select name="category_id">
                            <option>Select category</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field full">
                        <label>Description</label>
                        <textarea name="description"></textarea>
                    </div>

                </div>
            </div>

            <div class="form-section">
                <div class="section-label">Product Image</div>

                <div class="image-row">
                    <div class="img-preview-box" id="preview">No Image</div>

                    <div>
                        <label class="file-upload-label" for="image">Upload Image</label>
                        <input type="file" id="image" name="image">
                        <div class="upload-hint">PNG, JPG, WEBP</div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.products.index') }}" class="btn-cancel">Cancel</a>
                <button class="btn-save">Save Product</button>
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
        document.getElementById('preview').innerHTML =
            '<img src="'+ev.target.result+'">';
    }
    reader.readAsDataURL(file);
});
</script>

@endsection