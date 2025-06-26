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