
document.addEventListener('DOMContentLoaded', () => {
    // Initialisation des fonctionnalités de base
    initializeThemeNavigation();
    initializeArticleActions();
    initializeComments();
    initializeScrollToTop();

});
document.addEventListener('DOMContentLoaded', () => {
    // Notation des posts
    const posts = document.querySelectorAll('.post');
    posts.forEach(post => {
        const stars = post.querySelectorAll('.rating .stars i');
        stars.forEach(star => {
            star.addEventListener('click', () => {
                const rating = star.getAttribute('data-value');
                // Mettre à jour l'affichage des étoiles
                stars.forEach(s => {
                    if (s.getAttribute('data-value') <= rating) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
                // Sauvegarder la note dans le localStorage
                const postId = post.getAttribute('data-post-id');
                localStorage.setItem(`post-${postId}-rating`, rating);
            });

            // Charger la note depuis le localStorage
            const postId = post.getAttribute('data-post-id');
            const savedRating = localStorage.getItem(`post-${postId}-rating`);
            if (savedRating) {
                stars.forEach(s => {
                    if (s.getAttribute('data-value') <= savedRating) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            }
        });
    });


  });

function initializeThemeNavigation() {
    const list = document.querySelectorAll(".navigation li");
    const toggle = document.querySelector(".toggle");
    const navigation = document.querySelector(".navigation");
    const main = document.querySelector(".main-container");

    list.forEach(item => {
        item.addEventListener("mouseover", function() {
            list.forEach(el => el.classList.remove("hovered"));
            this.classList.add("hovered");
        });
    });

    toggle?.addEventListener('click', () => {
        navigation?.classList.toggle("active");
        main?.classList.toggle("active");
    });
}

function initializeArticleActions() {
    // Gestion des étoiles
    document.querySelectorAll('.stars').forEach(starsContainer => {
        starsContainer.addEventListener('click', handleRating);
    });

    // Gestion du bouton de sauvegarde
    document.querySelectorAll('.save-button').forEach(button => {
        button.addEventListener('click', handleSaveArticle);
    });

    // Gestion du partage
    document.querySelectorAll('.partage-button').forEach(button => {
        button.addEventListener('click', handleShare);
    });
}





function handleShare(articleId) {
    const shareUrl = `${window.location.origin}/articles/${articleId}`;

    if (navigator.share) {
        navigator.share({
            title: 'Partager l\'article',
            url: shareUrl
        }).catch(() => {
            copyToClipboard(shareUrl);
        });
    } else {
        copyToClipboard(shareUrl);
    }
}

// Fonctions utilitaires
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;

    document.body.appendChild(notification);
    setTimeout(() => notification.classList.add('show'), 10);
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text)
        .then(() => showNotification('Lien copié dans le presse-papier!'))
        .catch(() => showNotification('Erreur lors de la copie', 'error'));
}

function initializeScrollToTop() {
    const backToTop = document.querySelector('.back-to-top');
    if (backToTop) {
        backToTop.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
}


function openModal() {
    document.getElementById('articleModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('articleModal').style.display = 'none';
}

// Fermer la modal si on clique en dehors
window.onclick = function(event) {
    const modal = document.getElementById('articleModal');
    if (event.target == modal) {
        closeModal();
    }
}



document.addEventListener('DOMContentLoaded', () => {
    initializeComments();
    initializeRating();
    initializeButtons();
});



function loadComments(articleId) {
    // Simuler le chargement des commentaires depuis le serveur
    // À remplacer par un vrai appel API
    const commentList = document.getElementById(`comment-list-${articleId}`);
    if (commentList) {
        commentList.innerHTML = ''; // Nettoyer les commentaires existants

        // Exemple de commentaires (à remplacer par les données réelles)

        demoComments.forEach(comment => {
            addCommentToList(articleId, comment);
        });
    }
}

/*nouhaila
function submitComment(articleId) {
    const commentSection = document.getElementById(`comment-section-${articleId}`);
    const textarea = commentSection.querySelector('.comment-textarea');
    const commentText = textarea.value.trim();

    if (!commentText) {
        showNotification('Le commentaire ne peut pas être vide', 'error');
        return;
    }

    // Simuler l'envoi du commentaire au serveur
    const newComment = {
        id: Date.now(), // Générer un ID temporaire
        user: "h",
        content: commentText,
        date: new Date()
    };

    addCommentToList(articleId, newComment);

    // Réinitialiser le formulaire
    textarea.value = '';
    showNotification('Commentaire ajouté avec succès!');
}
*/


async function submitComment(articleId) {
    const commentSection = document.getElementById(`comment-section-${articleId}`);
    const textarea = commentSection.querySelector('.comment-textarea');
    const commentText = textarea.value.trim();

    if (!commentText) {
        showNotification('Le commentaire ne peut pas être vide', 'error');
        return;
    }

    try {
        // Ajout de logs pour déboguer
        console.log('Envoi du commentaire:', {
            content: commentText,
            article_id: articleId
        });

        const response = await fetch('/comments', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
                content: commentText,
                article_id: articleId
            })
        });

        // Ajout de logs pour voir la réponse
        console.log('Status:', response.status);
        const responseData = await response.text();
        console.log('Réponse:', responseData);

        if (response.ok) {
            const comment = JSON.parse(responseData);
            addCommentToList(articleId, {
                id: comment.id,
                user_name: comment.user_name,
                content: comment.content,
                date: comment.date
            });
            textarea.value = '';
            showNotification('Commentaire ajouté avec succès!');
        } else {
            showNotification('Erreur lors de l\'envoi du commentaire', 'error');
        }
    } catch (error) {
        console.error('Erreur détaillée:', error);
        showNotification('Erreur lors de l\'envoi du commentaire', 'error');
    }
}






function addCommentToList(articleId, comment) {
    const commentList = document.getElementById(`comment-list-${articleId}`);
    const commentHTML = `
        <div class="comment" data-comment-id="${comment.id}">
            <div class="comment-header">
                <strong>${comment.user}</strong>
                <span class="comment-date">${formatDate(comment.date)}</span>
            </div>
            <div class="comment-content">${comment.content}</div>
            <div class="comment-actions">
                <br>
                <button class="edit-comment" onclick="editComment(${comment.id})">
                    <ion-icon name="create-outline"></ion-icon>

                </button>
                <button class="delete-comment" onclick="deleteComment(${comment.id})">
                    <ion-icon name="trash-outline"></ion-icon>

                </button>
                <button class="reply-comment" onclick="replyToComment(${comment.id})">
                    <ion-icon name="arrow-undo-outline"></ion-icon>

                </button>
            </div>
            <div class="replies"></div>
        </div>
    `;

    commentList.insertAdjacentHTML('beforeend', commentHTML);
}

function cancelComment(articleId) {
    const commentSection = document.getElementById(`comment-section-${articleId}`);
    const textarea = commentSection.querySelector('.comment-textarea');
    textarea.value = '';
    commentSection.style.display = 'none';
}

function editComment(commentId) {
    const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
    const contentElement = commentElement.querySelector('.comment-content');
    const currentContent = contentElement.textContent;

    contentElement.innerHTML = `
        <textarea class="edit-textarea">${currentContent}</textarea>
        <div class="edit-actions">
            <button onclick="saveCommentEdit(${commentId})">Enregistrer</button>
            <button onclick="cancelCommentEdit(${commentId}, '${currentContent}')">Annuler</button>
        </div>
    `;
}

function saveCommentEdit(commentId) {
    const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
    const textarea = commentElement.querySelector('.edit-textarea');
    const newContent = textarea.value.trim();

    if (!newContent) {
        showNotification('Le commentaire ne peut pas être vide', 'error');
        return;
    }

    const contentElement = commentElement.querySelector('.comment-content');
    contentElement.innerHTML = newContent;
    showNotification('Commentaire modifié avec succès!');
}
//NONO
function cancelCommentEdit(commentId, originalContent) {
    const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
    const contentElement = commentElement.querySelector('.comment-content');
    contentElement.innerHTML = originalContent;
}



function replyToComment(commentId) {
    const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
    const repliesSection = commentElement.querySelector('.replies');

    if (!repliesSection.querySelector('.reply-input-area')) {
        const replyHTML = `
            <div class="reply-input-area">
                <textarea class="reply-textarea" placeholder="Écrivez votre réponse..."></textarea>
                <div class="reply-actions">
                    <button onclick="submitReply(${commentId})">Répondre</button>
                    <button onclick="cancelReply(${commentId})">Annuler</button>
                </div>
            </div>
        `;
        repliesSection.insertAdjacentHTML('beforeend', replyHTML);
    }
}

function submitReply(commentId) {
    const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
    const textarea = commentElement.querySelector('.reply-textarea');
    const replyText = textarea.value.trim();

    if (!replyText) {
        showNotification('La réponse ne peut pas être vide', 'error');
        return;
    }

    const repliesSection = commentElement.querySelector('.replies');
    const replyHTML = `
        <div class="reply">
            <div class="reply-header">
                <strong>Utilisateur actuel</strong>
                <span class="reply-date">${formatDate(new Date())}</span>
            </div>
            <div class="reply-content">${replyText}</div>
        </div>
    `;

    repliesSection.insertAdjacentHTML('beforeend', replyHTML);
    cancelReply(commentId);
    showNotification('Réponse ajoutée avec succès!');
}

function cancelReply(commentId) {
    const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
    const replyInputArea = commentElement.querySelector('.reply-input-area');
    if (replyInputArea) {
        replyInputArea.remove();
    }
}


/*

  async function submitComment(articleId) {
    const commentSection = document.getElementById(`comment-section-${articleId}`);
    const textarea = commentSection.querySelector('.comment-textarea');
    const commentText = textarea.value.trim();

    if (!commentText) {
        showNotification('Le commentaire ne peut pas être vide', 'error');
        return;
    }

    try {
        const response = await fetch('/comments', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Authorization': `Bearer ${localStorage.getItem('token')}`, // Si vous utilisez Sanctum
            },
            body: JSON.stringify({
                content: commentText,
                article_id: articleId,
            }),
        });

        if (response.ok) {
            const newComment = await response.json();
            addCommentToList(articleId, newComment); // Ajouter le commentaire à la liste
            textarea.value = ''; // Réinitialiser le champ de texte
            showNotification('Commentaire ajouté avec succès!');
        } else {
            showNotification('Erreur lors de l\'envoi du commentaire', 'error');
        }
    } catch (error) {
        showNotification('Erreur de connexion', 'error');
    }
}

function addCommentToList(articleId, comment) {
    const commentList = document.getElementById(`comment-list-${articleId}`);
    const commentHTML = `
        <div class="comment" data-comment-id="${comment.id}">
            <div class="comment-header">
                <strong>${comment.user_name}</strong> <!-- Afficher le nom de l'utilisateur -->
                <span class="comment-date">${formatDate(comment.date)}</span>
            </div>
            <div class="comment-content">${comment.content}</div>
            <div class="comment-actions">
                <button class="edit-comment" onclick="editComment(${comment.id})">
                    <ion-icon name="create-outline"></ion-icon>
                    Modifier
                </button>
                <button class="delete-comment" onclick="deleteComment(${comment.id})">
                    <ion-icon name="trash-outline"></ion-icon>
                    Supprimer
                </button>
                <button class="reply-comment" onclick="replyToComment(${comment.id})">
                    <ion-icon name="arrow-undo-outline"></ion-icon>
                    Répondre
                </button>
            </div>
            <div class="replies"></div>
        </div>
    `;

    commentList.insertAdjacentHTML('beforeend', commentHTML);
}
*/

function toggleReplyComment(id){
     let element = document.getElementById('replyComment-'+id);
     element.classList.toggle('hidden');
 }

 function togglepagecomment(){
     let element = document.getElementById('comment_page');
     element.classList.toggle('hidden');
 }



 document.querySelectorAll('.rating-form').forEach(form => {
    const stars = form.querySelectorAll('.fa-star');

    stars.forEach(star => {
        star.addEventListener('mouseover', () => {
            const value = star.parentElement.dataset.value;
            highlightStars(stars, value);
        });

        star.parentElement.addEventListener('mouseout', () => {
            resetStars(stars);
        });
    });
});

function highlightStars(stars, value) {
    stars.forEach(star => {
        const starValue = star.parentElement.dataset.value;
        star.style.color = starValue <= value ? '#ffd700' : '#ddd';
    });
}

function resetStars(stars) {
    stars.forEach(star => {
        star.style.color = '#ddd';
    });
}
