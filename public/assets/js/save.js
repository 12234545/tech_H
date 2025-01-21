document.addEventListener('DOMContentLoaded', function() {
    // Gérer le clic sur le bouton Enregistrer
    document.querySelectorAll('.save-button').forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.closest('.post').dataset.postId;

            fetch('/saves', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ post_id: postId })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                this.classList.add('saved');
            });
        });
    });

    // Gérer le retrait des sauvegardes
    document.querySelectorAll('.unsave-button').forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.dataset.postId;

            fetch(`/saves/${postId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                this.closest('.post').remove();
                alert(data.message);
            });
        });
    });
});
