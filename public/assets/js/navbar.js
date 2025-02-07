
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


