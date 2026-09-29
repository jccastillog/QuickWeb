{{-- Carrito de pedidos por WhatsApp: se guarda en el navegador del visitante, por tienda --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="cartOffcanvasLabel"><i class="bi bi-bag me-2"></i>Tu pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column">
        <div data-cart-empty class="text-center text-muted my-auto">
            <i class="bi bi-bag fs-1 d-block mb-2"></i>
            Tu carrito está vacío.
        </div>

        <ul class="list-unstyled mb-3" data-cart-items></ul>

        <div data-cart-checkout class="mt-auto d-none">
            <div class="d-flex justify-content-between align-items-center border-top pt-3 mb-3">
                <span class="fw-semibold">Total</span>
                <span class="fs-4 fw-bold text-primary" data-cart-total>$0</span>
            </div>

            <div class="mb-2">
                <label for="cartCustomerName" class="form-label small mb-1">Tu nombre</label>
                <input type="text" id="cartCustomerName" class="form-control" maxlength="80" autocomplete="name">
            </div>
            <div class="mb-3">
                <label for="cartNote" class="form-label small mb-1">Nota (dirección, talla, horario…)</label>
                <textarea id="cartNote" class="form-control" rows="2" maxlength="500"></textarea>
            </div>

            @if ($client->siteSettings?->whatsapp_number)
                <button type="button" class="btn btn-success w-100 btn-lg" data-cart-send>
                    <i class="bi bi-whatsapp me-2"></i>Enviar pedido por WhatsApp
                </button>
                <p class="small text-muted text-center mt-2 mb-0">
                    El negocio confirmará disponibilidad, precio final y forma de pago.
                </p>
            @else
                <div class="alert alert-warning small mb-0">Esta tienda aún no tiene WhatsApp configurado.</div>
            @endif

            <div data-cart-sent class="alert alert-success small mt-3 mb-0 d-none">
                ¿Ya enviaste el pedido por WhatsApp?
                <button type="button" class="btn btn-sm btn-outline-success ms-1" data-cart-clear>Vaciar carrito</button>
            </div>
        </div>
    </div>
</div>

{{-- Aviso breve al agregar un producto --}}
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
    <div id="cartToast" class="toast align-items-center text-bg-dark border-0" role="status" aria-live="polite">
        <div class="d-flex">
            <div class="toast-body"><i class="bi bi-check-circle me-1"></i><span data-cart-toast-text></span></div>
            <button type="button" class="btn btn-sm btn-light m-2" data-bs-toggle="offcanvas"
                data-bs-target="#cartOffcanvas">Ver pedido</button>
        </div>
    </div>
</div>

@php
    $cartConfig = [
        'storageKey' => 'quickweb_cart_' . $client->domain,
        'storeName' => $client->store_name,
        'storeUrl' => $client->storeUrl(),
        'whatsapp' => $client->siteSettings?->whatsapp_number,
    ];
@endphp

@push('scripts')
<script>
(function () {
    const config = @json($cartConfig);

    const money = new Intl.NumberFormat('es-CO', { maximumFractionDigits: 0 });
    const format = amount => '$' + money.format(Math.round(amount));

    // localStorage puede no estar disponible (modo privado, bloqueado): el carrito funciona igual en memoria
    let items = load();

    function load() {
        try {
            const parsed = JSON.parse(localStorage.getItem(config.storageKey) || '[]');
            return Array.isArray(parsed) ? parsed : [];
        } catch (_) {
            return [];
        }
    }

    function save() {
        try {
            localStorage.setItem(config.storageKey, JSON.stringify(items));
        } catch (_) {}
        render();
    }

    function add(product, qty) {
        const existing = items.find(item => item.id === product.id);
        if (existing) {
            existing.qty += qty;
            existing.price = product.price; // precio actual de la página
        } else {
            items.push({ ...product, qty });
        }
        save();
    }

    function setQty(id, qty) {
        items = qty > 0
            ? items.map(item => item.id === id ? { ...item, qty } : item)
            : items.filter(item => item.id !== id);
        save();
    }

    const total = () => items.reduce((sum, item) => sum + item.price * item.qty, 0);
    const count = () => items.reduce((sum, item) => sum + item.qty, 0);

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text ?? '';
        return div.innerHTML;
    }

    function render() {
        document.querySelectorAll('[data-cart-count]').forEach(badge => {
            badge.textContent = count();
            badge.classList.toggle('d-none', count() === 0);
        });

        const list = document.querySelector('[data-cart-items]');
        if (!list) return;

        list.innerHTML = items.map(item => `
            <li class="d-flex gap-2 align-items-center py-2 border-bottom">
                ${item.image ? `<img src="${escapeHtml(item.image)}" alt="" class="rounded object-fit-cover" style="width:56px;height:56px;">` : ''}
                <div class="flex-grow-1 small">
                    <a href="${escapeHtml(item.url)}" class="fw-semibold text-dark text-decoration-none d-block">${escapeHtml(item.name)}</a>
                    <span class="text-muted">${format(item.price)} c/u</span>
                </div>
                <div class="btn-group btn-group-sm" role="group" aria-label="Cantidad">
                    <button type="button" class="btn btn-outline-secondary" data-cart-dec="${item.id}" aria-label="Quitar uno">−</button>
                    <span class="btn btn-outline-secondary disabled text-dark">${item.qty}</span>
                    <button type="button" class="btn btn-outline-secondary" data-cart-inc="${item.id}" aria-label="Agregar uno">+</button>
                </div>
                <button type="button" class="btn btn-sm btn-link text-danger" data-cart-remove="${item.id}" aria-label="Eliminar">
                    <i class="bi bi-trash"></i>
                </button>
            </li>`).join('');

        document.querySelector('[data-cart-empty]').classList.toggle('d-none', items.length > 0);
        document.querySelector('[data-cart-checkout]').classList.toggle('d-none', items.length === 0);
        document.querySelector('[data-cart-total]').textContent = format(total());
    }

    function buildMessage() {
        const name = document.getElementById('cartCustomerName').value.trim();
        const note = document.getElementById('cartNote').value.trim();

        const lines = [`Hola ${config.storeName}, quiero hacer este pedido:`, ''];
        items.forEach(item => {
            lines.push(`• ${item.qty} x ${item.name} — ${format(item.price * item.qty)}`);
        });
        lines.push('', `*Total: ${format(total())}*`);
        if (name) lines.push('', `Nombre: ${name}`);
        if (note) lines.push(`Nota: ${note}`);
        lines.push('', `Pedido desde ${config.storeUrl}`);

        return lines.join('\n');
    }

    document.addEventListener('click', event => {
        const addButton = event.target.closest('[data-add-to-cart]');
        if (addButton) {
            const qtyInput = addButton.dataset.qtyInput ? document.querySelector(addButton.dataset.qtyInput) : null;
            const qty = Math.max(1, parseInt(qtyInput?.value, 10) || 1);

            add({
                id: Number(addButton.dataset.id),
                name: addButton.dataset.name,
                price: Number(addButton.dataset.price),
                image: addButton.dataset.image || null,
                url: addButton.dataset.url,
            }, qty);

            const toastText = document.querySelector('[data-cart-toast-text]');
            if (toastText && window.bootstrap) {
                toastText.textContent = `${addButton.dataset.name} agregado al pedido`;
                bootstrap.Toast.getOrCreateInstance(document.getElementById('cartToast')).show();
            }
            return;
        }

        const control = event.target.closest('[data-cart-inc], [data-cart-dec], [data-cart-remove]');
        if (control) {
            const { cartInc, cartDec, cartRemove } = control.dataset;
            const id = Number(cartInc ?? cartDec ?? cartRemove);
            const item = items.find(i => i.id === id);
            if (item) setQty(id, cartRemove !== undefined ? 0 : item.qty + (cartInc !== undefined ? 1 : -1));
            return;
        }

        if (event.target.closest('[data-cart-send]') && items.length && config.whatsapp) {
            window.open(`https://wa.me/${config.whatsapp}?text=${encodeURIComponent(buildMessage())}`, '_blank', 'noopener');
            document.querySelector('[data-cart-sent]').classList.remove('d-none');
            return;
        }

        if (event.target.closest('[data-cart-clear]')) {
            items = [];
            save();
            document.querySelector('[data-cart-sent]').classList.add('d-none');
        }
    });

    // Mantiene sincronizadas varias pestañas abiertas de la misma tienda
    window.addEventListener('storage', event => {
        if (event.key === config.storageKey) {
            items = load();
            render();
        }
    });

    render();
})();
</script>
@endpush
