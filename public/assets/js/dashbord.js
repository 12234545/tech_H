let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

// Menu Toggle le button de cacher le menu des themes
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main-container");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};
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
//la boite de partage
const viewbtn = document.querySelector(".partage-button");
const popup = document.querySelector(".popup");
const close = popup.querySelector(".close");
const field = popup.querySelector(".field");
const input = popup.querySelector(".input1");
const copier = popup.querySelector(".copier");

viewbtn.onclick = () => {
  popup.classList.toggle("show");
}

close.onclick = () => {
  viewbtn.onclick();
}

copier.onclick = () => {
  input.select();
  if (document.execCommand("copy")) {
    field.classList.add("active");
    copier.innerText = "copiee";
    setTimeout(() => {
      field.classList.remove("active");
      copier.innerText = "copier";
      window.getSelection().removeAllRanges();
    }, 3000);
  }
}
/// Gestion des commentaires
const posts = document.querySelectorAll('.post');

posts.forEach(post => {
    const commentButton = post.querySelector('.publish-comment');
    const commentSection = post.querySelector('.comment-section');

    // Créer le bouton commentaire avec icône
    commentButton.innerHTML = '<ion-icon class="icon-comments" name="chatbox-ellipses-outline"></ion-icon>';

    // Créer la zone de commentaire stylisée
    const commentArea = `
        <div class="comment-input-area" style="display: none;">
            <textarea class="comment-textarea" placeholder="Écrivez votre commentaire..."></textarea>
            <div class="comment-actions">
                <button class="submit-comment"><ion-icon class="icon-comments" name="checkmark-done-outline">Publier</ion-icon></button>
                <button class="cancel-comment"><ion-icon class="icon-comments" name="close-circle-outline">Annuler</ion-icon></button>
            </div>
        </div>
    `;
    commentSection.insertAdjacentHTML('beforeend', commentArea);

    // Gérer l'affichage de la zone de commentaire
    commentButton.addEventListener('click', () => {
        const inputArea = post.querySelector('.comment-input-area');
        inputArea.style.display = inputArea.style.display === 'none' ? 'block' : 'none';
    });

    // Gérer la publication des commentaires
    const submitComment = post.querySelector('.submit-comment');
    const cancelComment = post.querySelector('.cancel-comment');

    submitComment.addEventListener('click', () => {
        const textarea = post.querySelector('.comment-textarea');
        const commentText = textarea.value.trim();
        if (commentText) {
            const commentHTML = `
                <div class="comment">
                    <div class="comment-content">${commentText}</div><br>
                    <div class="comment-actions">
                        <button class="edit-comment"><ion-icon class="icon-comments" name="create-outline">Modifier</ion-icon></button>
                        <button class="delete-comment"><ion-icon class="icon-comments" name="trash-outline">Supprimer</ion-icon></button>
                        <button class="reply-comment"><ion-icon class="icon-comments" name="arrow-undo-outline">Répondre</ion-icon></button>
                    </div>
                    <div class="replies"></div>
                </div>
            `;
            post.querySelector('.comment-list').insertAdjacentHTML('beforeend', commentHTML);
            textarea.value = '';
            post.querySelector('.comment-input-area').style.display = 'none';
        }
    });

    cancelComment.addEventListener('click', () => {
        post.querySelector('.comment-input-area').style.display = 'none';
    });

    // Délégation d'événements pour les actions sur les commentaires
    post.querySelector('.comment-list').addEventListener('click', (e) => {
        const comment = e.target.closest('.comment');

        if (e.target.classList.contains('edit-comment')) {
            const content = comment.querySelector('.comment-content');
            const text = content.textContent;
            content.innerHTML = `
                <textarea class="edit-textarea">${text}</textarea>
                <button class="save-edit"><ion-icon class="icon-comments" name="save-outline">Sauvegarder</ion-icon></button><br>
            `;
        }

        if (e.target.classList.contains('delete-comment')) {
            comment.remove();
        }

        if (e.target.classList.contains('reply-comment')) {
            const replyArea = `
                <div class="reply-input-area">
                    <textarea class="reply-textarea" placeholder="Votre réponse..."></textarea>
                    <div class="reply-actions">
                        <button class="submit-reply"><ion-icon class="icon-comments" name="checkmark-done-outline">Publier</ion-icon></button>
                        <button class="cancel-reply"><ion-icon class="icon-comments" name="close-circle-outline">Annuler</ion-icon></button>
                    </div>
                </div>
            `;
            comment.querySelector('.replies').insertAdjacentHTML('beforeend', replyArea);
        }

        if (e.target.classList.contains('save-edit')) {
            const textarea = comment.querySelector('.edit-textarea');
            const content = comment.querySelector('.comment-content');
            content.innerHTML = textarea.value;
        }
    });

    // Gérer les réponses
    post.querySelector('.comment-list').addEventListener('click', (e) => {
        if (e.target.classList.contains('submit-reply')) {
            const replyArea = e.target.closest('.reply-input-area');
            const textarea = replyArea.querySelector('.reply-textarea');
            const replyText = textarea.value.trim();
            if (replyText) {
                const replyHTML = `
                    <div class="reply">
                        <div class="reply-content">${replyText}</div>
                    </div>
                `;
                replyArea.insertAdjacentHTML('beforebegin', replyHTML);
                replyArea.remove();
            }
        }

        if (e.target.classList.contains('cancel-reply')) {
            const replyArea = e.target.closest('.reply-input-area');
            replyArea.remove();
        }
    });
});

// Sélectionnez le bouton "Enregistrer"
const saveButton = document.querySelector('.save-button');

// Gestionnaire d'événement pour le clic sur le bouton
saveButton.addEventListener('click', () => {
// Vérifiez si le bouton est déjà en mode "Enregistré"
if (saveButton.classList.contains('saved')) {
// Si oui, annulez l'enregistrement
saveButton.classList.remove('saved');
saveButton.innerHTML = '<i class="fas fa-bookmark"></i> Enregistrer';
 showNotification('Poste désenregistré.', 'error');
} else {
     // Sinon, marquez comme enregistré
        saveButton.classList.add('saved');
        saveButton.innerHTML = '<i class="fas fa-check"></i> Enregistré';
        showNotification('Poste enregistré avec succès !');
    }
});
// Fonction pour afficher une notification
function showNotification(message, type = 'success') {
  // Vérifiez s'il existe déjà une notification, et la supprimez si c'est le cas
  const existingNotification = document.querySelector('.notification');
  if (existingNotification) {
      existingNotification.remove();
  }

// Créez une nouvelle notification
const notification = document.createElement('div');
notification.className = `notification ${type === 'error' ? 'error' : ''}`;
notification.textContent = message;

// Ajoutez la notification au body
document.body.appendChild(notification);

// Affichez la notification
setTimeout(() => {
  notification.classList.add('show');
}, 10);

// Masquez et supprimez la notification après 3 secondes
setTimeout(() => {
  notification.classList.remove('show');
  setTimeout(() => {
      notification.remove();
  }, 300);
}, 3000);
}
//le bouton de scrolle vers le haut
            // Back to top functionality
            const backToTop = document.querySelector('.back-to-top');
            backToTop.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
//
