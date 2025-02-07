/*
function filterHistory(theme) {
    const filterButtons = document.querySelectorAll('.filter-chip');
    const historyItems = document.querySelectorAll('.history-item');

    // Animation des boutons
    filterButtons.forEach(button => {
        button.classList.remove('active');
        if (button.textContent === theme || (theme === 'all' && button.textContent === 'Tous')) {
            button.classList.add('active');
        }
    });

    // Animation des items
    historyItems.forEach(item => {
        const matchesTheme = theme === 'all' || item.getAttribute('data-theme') === theme;

        if (matchesTheme) {
            item.classList.remove('filtered-out');
            item.classList.add('filtered-in');
        } else {
            item.classList.remove('filtered-in');
            item.classList.add('filtered-out');
        }

        // Mettre à jour l'affichage après l'animation
        setTimeout(() => {
            item.style.display = matchesTheme ? 'flex' : 'none';
            if (matchesTheme) {
                item.classList.remove('filtered-in');
            }
        }, 300);
    });
}

// Fonction pour filtrer l'historique par texte de recherche
function searchHistory() {
    const query = document.getElementById('searchInput').value.toLowerCase();
    const historyItems = document.querySelectorAll('.history-item');

    historyItems.forEach(item => {
        const title = item.querySelector('h3').textContent.toLowerCase();
        const theme = item.getAttribute('data-theme').toLowerCase();

        // Afficher ou masquer l'élément en fonction de la recherche et du filtre de thème
        if (title.includes(query) && (item.style.display !== 'none')) {
            item.style.display = 'flex';
        } else if (!title.includes(query) || item.style.display === 'none') {
            item.style.display = 'none';
        }
    });
}

// Initialisation : afficher tout l'historique par défaut
window.onload = () => filterHistory('all');

*/









//////////////////////////////

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.find input');
    const suggestionsContainer = document.createElement('div');
    suggestionsContainer.className = 'search-suggestions';
    searchInput.parentElement.appendChild(suggestionsContainer);

    let searchTimeout;

    // Gestionnaire de recherche
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        const query = e.target.value.trim();

        if (query.length >= 2) {
            searchTimeout = setTimeout(() => {
                fetchSearchResults(query);
            }, 300);
        } else {
            suggestionsContainer.classList.remove('active');
        }
    });

    // Récupérer les résultats de recherche
    function fetchSearchResults(query) {
        fetch(`/api/search?term=${query}`)
            .then(response => response.json())
            .then(data => {
                displaySuggestions(data);
            })
            .catch(error => console.error('Erreur:', error));
    }

    // Afficher les suggestions
    function displaySuggestions(results) {
        suggestionsContainer.innerHTML = '';

        if (results.length === 0) {
            suggestionsContainer.classList.remove('active');
            return;
        }

        results.forEach(result => {
            const item = document.createElement('div');
            item.className = 'suggestion-item';
            item.innerHTML = `
                <i class='bx bx-search-alt'></i>
                <span>${result.title}</span>
            `;

            item.addEventListener('click', () => {
                saveToHistory(result);
                navigateToArticle(result.id);
            });

            suggestionsContainer.appendChild(item);
        });

        suggestionsContainer.classList.add('active');
    }

    // Sauvegarder dans l'historique
    function saveToHistory(result) {
        fetch('/history/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                article_id: result.id,
                title: result.title
            })
        });
    }

    // Naviguer vers l'article

    function navigateToArticle(articleId) {
        window.location.href = `/dashboard?highlight=${articleId}`;
    }

    // Highlight article si nécessaire
    const urlParams = new URLSearchParams(window.location.search);
    const highlightId = urlParams.get('highlight');
    if (highlightId) {
        const article = document.querySelector(`[data-article-id="${highlightId}"]`);
        if (article) {
            article.classList.add('article-highlight');
            article.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    // Gestionnaire pour la page historique


        // Navigation depuis l'historique

        document.querySelectorAll('.history-item').forEach(item => {
            item.addEventListener('click', function() {
                const articleId = this.dataset.articleId;
                window.location.href = `/dashboard?highlight=${articleId}`;
            });
        });


        const historyContainer = document.querySelector('.history-list');
        if (historyContainer) {
            // Effacer l'historique
            document.querySelector('.clear-history-btn')?.addEventListener('click', function() {
                //if (confirm('Voulez-vous vraiment effacer tout l\'historique ?')) {
                    fetch('/article-history/clear', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            historyContainer.innerHTML = '<div class="no-results">Aucun historique de recherche</div>';
                            // Optionnel : Afficher un message de succès
                            showNotification('L\'historique a été effacé', 'success');
                        } else {
                            // Optionnel : Afficher un message d'erreur
                            showNotification('Erreur lors de la suppression de l\'historique', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        // Optionnel : Afficher un message d'erreur
                        showNotification('Une erreur s\'est produite lors de la suppression de l\'historique', 'error');
                    });
                //}
            });
        }









    });


   ////********** */






