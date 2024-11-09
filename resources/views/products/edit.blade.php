@extends('layout')

@section('content')
<h1>Edit Product</h1>
<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="product_id">Product ID</label>
        <input type="text" name="product_id" class="form-control" value="{{ $product->product_id }}" required>
    </div>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
    </div>
    <div class="form-group">
        <label for="price">Price</label>
        <input type="text" name="price" class="form-control" value="{{ $product->price }}" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" class="form-control">{{ $product->description }}</textarea>
    </div>
    <div class="form-group">
        <label for="stock">Stock</label>
        <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" class="form-control-file">
        @if($product->image)
            <img class="my-3" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" height="50px" width="50px">
        @endif
    </div>
    <button type="submit" class="btn btn-success">Update Product</button>
</form>
@endsection
