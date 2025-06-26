<div class="col-md-3">
    <h5 class="fw-bold">Términos y Políticas</h5>

    @php
        $chunks = $client->pages->chunk(ceil($client->pages->count() / 2));
    @endphp

    <div class="row g-2">
        @foreach ($chunks as $chunk)
            <div class="col-6">
                @foreach ($chunk as $page)
                    <button
                        type="button"
                        class="btn btn-outline-light btn-sm w-100 text-start"
                        data-bs-toggle="modal"
                        data-bs-target="#infoModal"
                        data-title="{{ $page->title }}"
                        data-content='@json($page->content)'>
                        {{ $page->title }}
                    </button>
                @endforeach
            </div>
        @endforeach
    </div>
</div>