@extends('layouts.app')

@php
    $categoryUrl = $client->storeUrl('categoria/' . $category->slug);
    $summary = Str::limit(strip_tags($category->description ?? ''), 160) ?: "Productos de {$category->name} en {$client->store_name}";
@endphp

@section('title', $category->name . ' | ' . $client->store_name)
@section('description', $summary)

@section('meta-tags')
    <link rel="canonical" href="{{ $categoryUrl }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $client->store_name }}">
    <meta property="og:title" content="{{ $category->name }} | {{ $client->store_name }}">
    <meta property="og:description" content="{{ $summary }}">
    <meta property="og:url" content="{{ $categoryUrl }}">
    @if ($category->image?->media)
        <meta property="og:image" content="{{ $category->image->media->full_url }}">
    @endif
@endsection

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ $client->storeUrl() }}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
            </ol>
        </nav>

        <header class="mb-4">
            <h1 class="fw-bold h2">{{ $category->name }}</h1>
            @if ($category->description)
                <p class="text-muted mb-0">{{ $category->description }}</p>
            @endif
        </header>

        @if ($category->products->isNotEmpty())
            <div class="row">
                @foreach ($category->products as $product)
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-muted py-5">
                <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                Pronto tendremos productos en esta categoría.
                <div class="mt-3">
                    <a href="{{ $client->storeUrl() }}" class="btn btn-outline-primary">Volver al inicio</a>
                </div>
            </div>
        @endif
    </div>
@endsection
