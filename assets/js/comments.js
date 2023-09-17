document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("submit-comment-btn").addEventListener("click", function(event) {
        event.preventDefault(); // Empêche le formulaire de soumettre normalement
    
        const commentText = document.getElementById("comment-message").value;
        const postId = document.getElementById("post-id").value; // Récupérez la valeur de post-id (en supposant que c'est un champ input. Si c'est un autre élément, ajustez en conséquence)
    
        fetch('/assets/forms/comments_handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `comment-message=${encodeURIComponent(commentText)}&post-id=${encodeURIComponent(postId)}`
        })
        .then(response => response.text())
        .then(data => {
            alert('Votre commentaire a bien été envoyé.');
        })
        .catch((error) => {
            console.error("Erreur :", error);
            alert('Une erreur est survenue lors de l\'envoi du commentaire.');
        });
    });
    
});
