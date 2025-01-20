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
