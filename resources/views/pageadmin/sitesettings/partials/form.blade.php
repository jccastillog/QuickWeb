<div class="row">
    <!-- Columna 1: Información de Contacto -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Información de Contacto</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="phone">Teléfono*</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                        name="phone" value="{{ old('phone', $siteSettings->phone ?? '') }}" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="whatsapp">WhatsApp*</label>
                    <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" id="whatsapp"
                        name="whatsapp" value="{{ old('whatsapp', $siteSettings->whatsapp ?? '') }}" required>
                    @error('whatsapp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email*</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email', $siteSettings->email ?? '') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="business_hours">Horario*</label>
                    <textarea class="form-control @error('business_hours') is-invalid @enderror" id="business_hours" name="business_hours"
                        rows="2">{{ old('business_hours', $siteSettings->business_hours ?? 'Lunes a Viernes: 9:00 - 18:00') }}</textarea>
                    @error('business_hours')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Columna 2: Dirección -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Dirección</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="street_address">Calle y Número*</label>
                    <input type="text" class="form-control @error('street_address') is-invalid @enderror"
                        id="street_address" name="street_address"
                        value="{{ old('street_address', $siteSettings->street_address ?? '') }}" required>
                    @error('street_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city">Ciudad*</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror"
                                id="city" name="city" value="{{ old('city', $siteSettings->city ?? '') }}"
                                required>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="state">Estado/Provincia*</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror"
                                id="state" name="state" value="{{ old('state', $siteSettings->state ?? '') }}"
                                required>
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country">País*</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror"
                                id="country" name="country"
                                value="{{ old('country', $siteSettings->country ?? '') }}" required>
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="postal_code">Código Postal*</label>
                            <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                id="postal_code" name="postal_code"
                                value="{{ old('postal_code', $siteSettings->postal_code ?? '') }}" required>
                            @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Columna 3: Información General -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Información General</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="about_text">Acerca de</label>
                    <textarea class="form-control @error('about_text') is-invalid @enderror" id="about_text" name="about_text"
                        rows="4">{{ old('about_text', $siteSettings->about_text ?? '') }}</textarea>
                    @error('about_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Columna 4: SEO y Analytics -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">SEO y Analytics</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="meta_title">Meta Título</label>
                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                        id="meta_title" name="meta_title"
                        value="{{ old('meta_title', $siteSettings->meta_title ?? '') }}">
                    @error('meta_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="meta_description">Meta Descripción</label>
                    <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description"
                        name="meta_description" rows="2">{{ old('meta_description', $siteSettings->meta_description ?? '') }}</textarea>
                    @error('meta_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="google_analytics_id">Google Analytics ID</label>
                    <input type="text" class="form-control @error('google_analytics_id') is-invalid @enderror"
                        id="google_analytics_id" name="google_analytics_id"
                        value="{{ old('google_analytics_id', $siteSettings->google_analytics_id ?? '') }}">
                    @error('google_analytics_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
