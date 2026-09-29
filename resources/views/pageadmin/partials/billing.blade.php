@php
    $isAdmin = auth()->user()->role === 'admin';
    $status = $client->billingStatus();
    $productCount = $client->products->count();
    $productLimit = $client->productLimit();
    $supportWhatsapp = config('quickweb.support_whatsapp');
@endphp

{{-- Aviso al dueño de la tienda cuando debe renovar --}}
@if (!$isAdmin && in_array($status, ['por_vencer', 'en_gracia', 'suspendida']))
    <div class="alert alert-{{ $status === 'por_vencer' ? 'warning' : 'danger' }} d-flex flex-wrap align-items-center gap-2">
        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
        <div class="flex-grow-1">
            @if ($status === 'por_vencer')
                Tu plan vence el <strong>{{ $client->expires_at->format('d/m/Y') }}</strong>. Renueva para que tu tienda siga publicada.
            @elseif ($status === 'en_gracia')
                Tu plan venció el <strong>{{ $client->expires_at->format('d/m/Y') }}</strong>.
                Tu tienda se suspenderá el <strong>{{ $client->suspendsOn()->format('d/m/Y') }}</strong> si no renuevas.
            @else
                Tu tienda está <strong>suspendida</strong> por falta de pago. Renueva para volver a publicarla.
            @endif
        </div>
        @if ($supportWhatsapp)
            <a class="btn btn-success btn-sm" target="_blank" rel="noopener"
                href="https://wa.me/{{ $supportWhatsapp }}?text={{ rawurlencode("Hola QuickWeb, quiero renovar el plan de mi tienda {$client->store_name}.") }}">
                <i class="bi bi-whatsapp"></i> Renovar por WhatsApp
            </a>
        @endif
    </div>
@endif

<div class="card shadow-sm mb-4">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-credit-card"></i> Plan y pagos</h5>
        @if ($isAdmin)
            <button class="btn btn-sm btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#paymentForm"
                aria-expanded="{{ $errors->hasAny(['months', 'amount', 'method', 'paid_at', 'reference', 'notes']) ? 'true' : 'false' }}">
                <i class="bi bi-cash-coin"></i> Registrar pago
            </button>
        @endif
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="small text-muted">Plan</div>
                <div class="fw-semibold">{{ $client->plan?->name ?? 'Sin plan' }}</div>
                @if ($client->plan)
                    <div class="small text-muted">{{ \App\Support\Money::format($client->plan->price) }}/mes</div>
                @endif
            </div>
            <div class="col-md-3">
                <div class="small text-muted">Estado</div>
                <span class="badge bg-{{ $client->billingStatusColor() }}">{{ $client->billingStatusLabel() }}</span>
                @if ($client->expires_at)
                    <div class="small text-muted mt-1">Pagado hasta {{ $client->expires_at->format('d/m/Y') }}</div>
                @endif
            </div>
            <div class="col-md-3">
                <div class="small text-muted">Productos</div>
                <div class="fw-semibold">{{ $productCount }} / {{ $productLimit ?? '∞' }}</div>
                @if ($productLimit)
                    <div class="progress mt-1" style="height: 6px;" role="progressbar"
                        aria-valuenow="{{ $productCount }}" aria-valuemin="0" aria-valuemax="{{ $productLimit }}">
                        <div class="progress-bar {{ $productCount >= $productLimit ? 'bg-danger' : '' }}"
                            style="width: {{ min(100, round($productCount / $productLimit * 100)) }}%"></div>
                    </div>
                @endif
            </div>
            <div class="col-md-3">
                <div class="small text-muted">Dominio propio</div>
                @if ($client->custom_domain)
                    <div class="fw-semibold text-break">{{ $client->custom_domain }}</div>
                @elseif ($client->plan?->allows_custom_domain)
                    <div class="text-muted">Incluido, sin configurar</div>
                @else
                    <div class="text-muted">No incluido en el plan</div>
                @endif
            </div>
        </div>

        @if ($isAdmin)
            <div class="collapse {{ $errors->hasAny(['months', 'amount', 'method', 'paid_at', 'reference', 'notes']) ? 'show' : '' }}" id="paymentForm">
                <form method="POST" action="{{ route('clients.payments.store', $client) }}" class="border rounded p-3 mt-4 bg-light">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="payment_plan_id" class="form-label">Plan</label>
                            <select id="payment_plan_id" name="plan_id" class="form-select @error('plan_id') is-invalid @enderror" required>
                                @foreach ($plans as $plan)
                                    @if ($plan->active || $plan->id === $client->plan_id)
                                        <option value="{{ $plan->id }}" data-price="{{ (int) $plan->price }}"
                                            {{ (string) old('plan_id', $client->plan_id ?? $plans->firstWhere('active', true)?->id) === (string) $plan->id ? 'selected' : '' }}>
                                            {{ $plan->name }} ({{ \App\Support\Money::format($plan->price) }}/mes)
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('plan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-2">
                            <label for="payment_months" class="form-label">Meses</label>
                            <select id="payment_months" name="months" class="form-select @error('months') is-invalid @enderror" required>
                                @foreach (App\Models\Payment::MONTH_OPTIONS as $months)
                                    <option value="{{ $months }}" {{ (int) old('months', 1) === $months ? 'selected' : '' }}>{{ $months }}</option>
                                @endforeach
                            </select>
                            @error('months')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3">
                            <label for="payment_amount" class="form-label">Valor recibido</label>
                            <input type="number" id="payment_amount" name="amount" min="0" step="100" required
                                class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}">
                            @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3">
                            <label for="payment_paid_at" class="form-label">Fecha de pago</label>
                            <input type="date" id="payment_paid_at" name="paid_at" required max="{{ now()->toDateString() }}"
                                class="form-control @error('paid_at') is-invalid @enderror"
                                value="{{ old('paid_at', now()->toDateString()) }}">
                            @error('paid_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="payment_method" class="form-label">Medio de pago</label>
                            <select id="payment_method" name="method" class="form-select @error('method') is-invalid @enderror" required>
                                @foreach (App\Models\Payment::METHODS as $value => $label)
                                    <option value="{{ $value }}" {{ old('method') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('method')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="payment_reference" class="form-label">Referencia</label>
                            <input type="text" id="payment_reference" name="reference" maxlength="100"
                                class="form-control @error('reference') is-invalid @enderror"
                                value="{{ old('reference') }}" placeholder="N.º de comprobante">
                            @error('reference')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="payment_notes" class="form-label">Notas</label>
                            <input type="text" id="payment_notes" name="notes" maxlength="500"
                                class="form-control @error('notes') is-invalid @enderror" value="{{ old('notes') }}">
                            @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
                        <small class="text-muted">
                            Si la tienda está al día, los meses se suman desde su vencimiento; si ya venció, desde hoy.
                        </small>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check2-circle"></i> Registrar pago
                        </button>
                    </div>
                </form>
            </div>
        @endif

        @if ($client->payments->isNotEmpty())
            <h6 class="mt-4">Historial de pagos</h6>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Plan</th>
                            <th>Periodo</th>
                            <th>Medio</th>
                            <th class="text-end">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($client->payments as $payment)
                            <tr>
                                <td>{{ $payment->paid_at->format('d/m/Y') }}</td>
                                <td>{{ $payment->plan?->name ?? '—' }}</td>
                                <td class="small">
                                    {{ $payment->period_start->format('d/m/Y') }} – {{ $payment->period_end->format('d/m/Y') }}
                                    <span class="text-muted">({{ $payment->months }} {{ $payment->months === 1 ? 'mes' : 'meses' }})</span>
                                </td>
                                <td class="small">
                                    {{ $payment->method_label }}
                                    @if ($payment->reference)
                                        <span class="text-muted">· {{ $payment->reference }}</span>
                                    @endif
                                </td>
                                <td class="text-end">{{ \App\Support\Money::format($payment->amount) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@if ($isAdmin)
    @push('scripts')
        <script>
            // Sugiere el valor a cobrar: precio del plan × meses (se puede editar)
            (function () {
                const plan = document.getElementById('payment_plan_id');
                const months = document.getElementById('payment_months');
                const amount = document.getElementById('payment_amount');
                if (!plan || !months || !amount) return;

                let edited = amount.value !== '';
                amount.addEventListener('input', () => edited = true);

                function suggest() {
                    if (edited) return;
                    const price = Number(plan.selectedOptions[0]?.dataset.price || 0);
                    amount.value = price * Number(months.value);
                }

                plan.addEventListener('change', () => { edited = false; suggest(); });
                months.addEventListener('change', () => { edited = false; suggest(); });
                suggest();
            })();
        </script>
    @endpush
@endif
