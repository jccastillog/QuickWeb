@props([
    'category',
    'reverse' => false,
    'imageRatio' => '4x3',
])

@php
    $storeClient = $currentClient ?? $category->client;
    $categoryUrl = $storeClient->storeUrl('categoria/' . $category->slug);
@endphp

<div class="row g-4 align-items-center mb-5 {{ $reverse ? 'flex-row-reverse' : '' }}">
    <div class="col-md-6">
        <div class="text-start text-md-{{ $reverse ? 'end' : 'start' }}">
            <h3 class="fw-bold">{{ $category->name }}</h3>
            <p class="text-muted">{{ $category->description }}</p>
            <a href="{{ $categoryUrl }}" class="btn btn-outline-primary">
                Ver productos <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <div class="col-md-6">
        @if ($category->image && $category->image->media)
            <a href="{{ $categoryUrl }}" class="ratio ratio-{{ $imageRatio }} d-block">
                <img src="{{ $category->image->media->full_url }}"
                     alt="{{ $category->name }}"
                     class="img-fluid rounded-3 shadow-sm object-fit-cover" loading="lazy">
            </a>
        @endif
    </div>
</div>
