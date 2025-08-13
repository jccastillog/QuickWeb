@props([
    'category',
    'reverse' => false,
    'imageRatio' => '4x3',
])

<div class="row g-4 align-items-center mb-5 {{ $reverse ? 'flex-row-reverse' : '' }}">
    <div class="col-md-6">
        <div class="text-start text-md-{{ $reverse ? 'end' : 'start' }}">
            <h3 class="fw-bold">{{ $category->name }}</h3>
            <p class="text-muted">{{ $category->description }}</p>
        </div>
    </div>

    <div class="col-md-6">
        @if ($category->image && $category->image->media)
            <div class="ratio ratio-{{ $imageRatio }}">
                <img src="{{ $category->image->media->full_url }}"
                     alt="{{ $category->name }}"
                     class="img-fluid rounded-3 shadow-sm object-fit-cover">
            </div>
        @endif
    </div>
</div>