@extends('admin.layout')

@section('title', $category->name)

@section('content')

<style>
    .wrap {
        font-family: inherit;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #6b7280;
        text-decoration: none;
        font-size: 13px;
        margin-bottom: 16px;
    }

    .btn-back:hover {
        color: #111827;
    }

    .card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .card-header {
        padding: 16px 20px;
        border-bottom: 1px solid #e5e7eb;
        background: #fafafa;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h2,
    .card-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #111827;
    }

    .card-body {
        padding: 20px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .info-item {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #f9fafb;
        padding: 12px;
    }

    .info-label {
        font-size: 11px;
        text-transform: uppercase;
        color: #9ca3af;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
    }

    .btn-edit {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fff;
        color: #185FA5;
        border: 1px solid #B5D4F4;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 13px;
        text-decoration: none;
        transition: .15s;
    }

    .btn-edit:hover {
        background: #E6F1FB;
    }

    .tbl-wrap {
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead th {
        background: #f9fafb;
        color: #6b7280;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .05em;
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    tbody td {
        padding: 12px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 13px;
        color: #111827;
        vertical-align: middle;
    }

    tbody tr:hover td {
        background: #f9fafb;
    }

    .id-cell {
        color: #9ca3af;
        font-family: monospace;
    }

    .product-name {
        font-weight: 500;
    }

    .badge-price {
        display: inline-block;
        background: #E1F5EE;
        color: #0F6E56;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .stock-low {
        color: #dc2626;
        font-weight: 600;
    }

    .img-thumb {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .no-img {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        color: #9ca3af;
    }

    .empty-state {
        padding: 40px;
        text-align: center;
        color: #6b7280;
    }

    @media(max-width:768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="wrap">

<a href="{{ route('admin.categories.index') }}" class="btn-back">
    ← Back to Categories
</a>

<div class="card">

    <div class="card-header">

        <h2>{{ $category->name }}</h2>

        <a href="{{ route('admin.categories.edit', $category->id) }}"
           class="btn-edit">
            ✏ Edit Category
        </a>

    </div>

    <div class="card-body">

        <div class="info-grid">

            <div class="info-item">
                <div class="info-label">Category ID</div>
                <div class="info-value">#{{ $category->id }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Slug</div>
                <div class="info-value">{{ $category->slug }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Products</div>
                <div class="info-value">
                    {{ $category->products_count ?? $category->products->count() }}
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">Created</div>
                <div class="info-value">
                    {{ $category->created_at->format('Y-m-d') }}
                </div>
            </div>

        </div>

    </div>

</div>

<div class="card">

    <div class="card-header">
        <h3>
            Products in this Category
            ({{ $category->products->count() }})
        </h3>
    </div>

    @if($category->products->isEmpty())

        <div class="empty-state">
            No products found in this category.
        </div>

    @else

        <div class="tbl-wrap">

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($category->products as $product)

                    <tr>

                        <td class="id-cell">
                            #{{ $product->id }}
                        </td>

                        <td>
                            <div class="product-name">
                                {{ $product->name }}
                            </div>
                        </td>

                        <td>
                            <span class="badge-price">
                                ${{ number_format($product->price, 2) }}
                            </span>
                        </td>

                        <td class="{{ $product->stock <= 10 ? 'stock-low' : '' }}">
                            {{ $product->stock }}
                        </td>

                        <td>
                            @if($product->image)
                                <img
                                    src="{{ $product->image_url }}"
                                    class="img-thumb"
                                    alt="{{ $product->name }}">
                            @else
                                <div class="no-img">None</div>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                               class="btn-edit">
                                Edit
                            </a>
                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>


</div>

@endsection
