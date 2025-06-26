<div class="col-md-3 text-center">
    <h5 class="fw-bold">Síguenos</h5>
    <div class="social-icons">
        @foreach($client->socialNetworks as $network)
            <a href="{{ $network->url }}" target="_blank">
                <i class="bi bi-{{ $network->platform }}"></i>
            </a>
        @endforeach
    </div>
</div>