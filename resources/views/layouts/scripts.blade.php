<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const infoModal = document.getElementById('infoModal');
    if (infoModal) {
        infoModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const title = button.getAttribute('data-title');
            let content = button.getAttribute('data-content');

            // Intenta decodificar correctamente si viene como string JSON escapado
            try {
                content = JSON.parse(content); // convierte \u00e1 → á y \n → saltos reales
            } catch (_) {
                // fallback: lo deja como viene si falla parseo
            }

            // Separar por dobles saltos y envolver en párrafos
            content = content
                .split(/\n{2,}/)
                .map(p => p.trim())
                .filter(p => p.length > 0)
                .map(p => `<p>${p}</p>`)
                .join('');

            document.getElementById('infoModalTitle').textContent = title;
            document.getElementById('infoModalBody').innerHTML = content;
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('newsletterForm');
        const message = document.getElementById('newsletterMessage');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                .then(async response => {
                    if (!response.ok) {
                        throw new Error(`Respuesta HTTP ${response.status}`);
                    }

                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        const data = await response.json();
                        message.innerText = data.message;
                        message.classList.remove('text-danger');
                        message.classList.add('text-success');
                        message.style.display = 'block';
                        form.reset();
                    } else {
                        throw new Error('La respuesta no fue JSON');
                    }
                })
                .catch(error => {
                    console.error('Error al enviar newsletter:', error);
                    message.innerText = 'Ocurrió un error técnico: ' + error.message;
                    message.classList.remove('text-success');
                    message.classList.add('text-danger');
                    message.style.display = 'block';
                });
        });
    });
</script>
