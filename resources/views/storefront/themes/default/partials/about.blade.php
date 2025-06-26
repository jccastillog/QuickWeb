<div class="col-md-3">
    <div class="text-center mb-4">
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#infoModal"
            data-title="{{ $client->store_name }}" data-content="{!! htmlspecialchars($client->siteSettings->about_text, ENT_QUOTES) !!}">
            Acerca de Nosotros
        </button>
    </div>
</div>