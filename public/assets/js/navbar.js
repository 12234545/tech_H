/*
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.find input');
    const searchResults = document.createElement('div');
    searchResults.className = 'search-results';
    document.querySelector('.find').appendChild(searchResults);

    let timeoutId;

    // Récupérer le token CSRF depuis la meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        const searchTerm = this.value.trim();

        if (searchTerm.length === 0) {
            searchResults.style.display = 'none';
            return;
        }

        timeoutId = setTimeout(() => {
            fetch('/article-history/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    search_term: searchTerm
                })
            })
            .then(response => response.json())
            .then(data => {
                searchResults.innerHTML = '';

                if (data.length > 0) {
                    data.forEach(article => {
                        const link = document.createElement('a');
                        link.href = `/dashboard?highlight=${article.id}`;
                        link.textContent = article.title;
                        link.className = 'search-result-item';
                        link.id = 'resultat';
                        searchResults.appendChild(link);
                    });
                    searchResults.style.display = 'block';
                } else {
                    searchResults.style.display = 'none';
                }
            });
        }, 300);
    });

    // Cacher les résultats quand on clique ailleurs
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.find')) {
            searchResults.style.display = 'none';
        }
    });
});


//////////////////:
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.search-input');
    const searchResults = document.querySelector('.search-results');

    searchInput.addEventListener('input', (e) => {
      if (e.target.value.length > 0) {
        searchResults.classList.add('active');
      } else {
        searchResults.classList.remove('active');
      }
    });
  });
*/


/*
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.find input');
    const suggestionsContainer = document.createElement('div');
    suggestionsContainer.className = 'search-results';
    searchInput.parentElement.appendChild(suggestionsContainer);

    let searchTimeout;

    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        const query = e.target.value.trim();

        if (query.length >= 2) {
            searchTimeout = setTimeout(() => {
                fetch(`/api/search?term=${query}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    displaySuggestions(data);
                })
                .catch(error => console.error('Erreur:', error));
            }, 300);
        } else {
            suggestionsContainer.classList.remove('active');
        }
    });

    function displaySuggestions(results) {
        suggestionsContainer.innerHTML = '';

        if (results.length === 0) {
            suggestionsContainer.classList.remove('active');
            return;
        }

        results.forEach(result => {
            const item = document.createElement('div');
            item.className = 'suggestion-item';

            // Création de la miniature de l'article
            item.innerHTML = `
                <div class="suggestion-content">
                    <div class="suggestion-image">
                        <img src="${result.image || '/default-article.jpg'}" alt="${result.title}">
                    </div>
                    <div class="suggestion-info">
                        <div class="suggestion-title">${result.title}</div>
                        <div class="suggestion-theme">${result.theme}</div>
                    </div>
                </div>
            `;

            item.addEventListener('click', () => {
                navigateToArticle(result.id);
            });

            suggestionsContainer.appendChild(item);
        });

        suggestionsContainer.classList.add('active');
    }

    function navigateToArticle(articleId) {
        const article = document.querySelector(`[data-article-id="${articleId}"]`);
        if (article) {
            // Scroll vers l'article avec animation
            article.scrollIntoView({ behavior: 'smooth', block: 'center' });

            // Ajouter un effet de surbrillance
            article.classList.add('highlight-article');
            setTimeout(() => {
                article.classList.remove('highlight-article');
            }, 2000);

            // Fermer les suggestions
            suggestionsContainer.classList.remove('active');
            searchInput.value = '';
        }
    }

    // Fermer les suggestions en cliquant en dehors
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
            suggestionsContainer.classList.remove('active');
        }
    });
});
*/

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.find input');
    const searchResults = document.createElement('div');
    searchResults.className = 'search-results';
    document.querySelector('.find').appendChild(searchResults);

    let timeoutId;

    // Récupérer le token CSRF depuis la meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        const searchTerm = this.value.trim();

        if (searchTerm.length === 0) {
            searchResults.style.display = 'none';
            return;
        }

        timeoutId = setTimeout(() => {
            fetch('/article-history/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    search_term: searchTerm
                })
            })
            .then(response => response.json())
            .then(data => {
                searchResults.innerHTML = '';

                if (data.length > 0) {

                    data.forEach(article => {
                        const link = document.createElement('a');
                        link.href = `/article-history/show/${article.id}`;
                        link.textContent = article.title;
                        link.id = 'resultat';
                        link.className = 'search-result-item';

                        searchResults.appendChild(link);
                    });


                    searchResults.style.display = 'block';
                } else {
                    searchResults.style.display = 'none';
                }
            });
        }, 300);
    });

    // Cacher les résultats quand on clique ailleurs
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.find')) {
            searchResults.style.display = 'none';
        }
    });
});
