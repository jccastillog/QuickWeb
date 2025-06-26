@extends('layouts.app')

@section('content')
    <!-- Sección de slider -->
    @include('storefront.themes.default.partials.carousel')

    <!-- Sección de Categorías -->
    @include('storefront.themes.default.partials.categories')

    <!-- Sección de Productos Destacados -->
    @include('storefront.themes.default.partials.products')

    <!-- Sección de Ofertas -->
    @include('storefront.themes.default.partials.offers')

    <!-- Sección de Testimonios -->
    @include('storefront.themes.default.partials.testimonials')
@endsection