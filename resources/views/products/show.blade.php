@extends('layout')

@section('content')



<div class="d-flex justify-content-around">
    <div>
        <h1>{{ $product->name }}</h1>
        <p><strong>Product ID:</strong> {{ $product->product_id }}</p>
        <p><strong>Price:</strong> ${{ $product->price }}</p>
        <p><strong>Stock:</strong> {{ $product->stock ?? 'N/A' }}</p>
        <p><strong>Description:</strong> {{ $product->description }}</p>
    </div>
    <div>
        @if($product->image)
            <p><strong>Image:</strong></p>
            <img class="my-3" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="200" class="rounded">
        @else
            <p>No Image Available</p>
        @endif
        <div>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Back to Products</a>
        </div>
    </div>
</div>
@endsection
