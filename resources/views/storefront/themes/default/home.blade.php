@extends('layouts.app')

@section('content')
    <!-- Sección de slider -->
    @include('storefront.themes.default.partials.carousel')

    <!-- Sección de Categorías -->
    <section id="categorias" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">{{ __('Categorías') }}</h2>
            @foreach ($categories as $category)
                <div class="row align-items-center mb-4 @if ($loop->even) flex-row-reverse @endif">
                    <div class="col-md-6">
                        <h4>{{ $category->name }}</h4>
                        <p>{{ $category->description }}</p>
                        <a href="{{ route('category.show', ['domain' => $client->domain, 'category' => $category->slug]) }}"
                            class="btn btn-primary">
                            {{ __('Ver más') }}
                        </a>
                    </div>
                    <div class="col-md-6 text-center">
                        @if ($category->image)
                            <img src="{{ asset($category->image->path) }}" class="img-fluid" alt="{{ $category->name }}">
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Sección de Productos Destacados -->
    <section id="productos" class="py-5 text-center">
        <div class="container">
            <h2 class="mb-4">{{ __('Productos Destacados') }}</h2>
            <div class="row">
                @foreach ($featuredProducts as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card product-card p-3 h-100">
                            @if ($product->images->count() > 0)
                                <img src="{{ asset($product->images->first()->path) }}" class="img-fluid"
                                    alt="{{ $product->name }}">
                            @endif
                            <h4 class="mt-3">{{ $product->name }}</h4>
                            <p>{{ Str::limit($product->description, 100) }}</p>
                            <div class="mt-auto">
                                <span class="text-primary fw-bold">${{ number_format($product->price, 2) }}</span>
                                <a href="{{ route('product.show', ['domain' => $client->domain, 'product' => $product->slug]) }}"
                                    class="btn btn-outline-primary rounded-pill px-4 py-2 mt-2">
                                    {{ __('Comprar') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sección de Testimonios -->
    @include('storefront.themes.default.partials.testimonials')
@endsection
