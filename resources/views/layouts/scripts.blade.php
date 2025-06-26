<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const infoModal = document.getElementById('infoModal');
    if (infoModal) {
        infoModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const title = button.getAttribute('data-title');
            const content = button.getAttribute('data-content');

            console.log('Título:', title);
            console.log('Contenido:', content);


            document.getElementById('infoModalTitle').textContent = title;
            document.getElementById('infoModalBody').innerHTML = content;
        });
    }
</script>