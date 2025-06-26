<div class="col-md-3">
    <h5 class="fw-bold">Contacto</h5>
    <p><i class="bi bi-envelope"></i> {{ $client->siteSettings->email }}</p>
    <p><i class="bi bi-phone"></i> {{ $client->siteSettings->phone }}</p>
    <p><i class="bi bi-geo-alt"></i>{{ $client->siteSettings->street_address }} - {{ $client->siteSettings->city }}</p>
</div>