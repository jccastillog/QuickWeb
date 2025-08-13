<section id="categorias" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">{{ __('Categorías') }}</h2>

        @php $maxVisibleCategories = 4; @endphp

        <div x-data="{ showAllCategories: false }">
            @foreach ($categories as $index => $category)
                <div
                    x-show="showAllCategories || Number('{{ $index }}') < {{ $maxVisibleCategories }}"
                    x-transition
                >
                    <x-category-card :category="$category" :reverse="$loop->even" />
                </div>
            @endforeach

            @if ($categories->count() > $maxVisibleCategories)
                <div class="text-center mt-4">
                    <button @click="showAllCategories = !showAllCategories" class="btn btn-outline-primary">
                        <span x-show="!showAllCategories">Ver más categorías</span>
                        <span x-show="showAllCategories">Ver menos</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
</section>