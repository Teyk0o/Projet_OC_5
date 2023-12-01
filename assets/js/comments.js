document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("submit-comment-btn").addEventListener("click", function(event) {
        event.preventDefault(); // Empêche le formulaire de soumettre normalement
    
        const commentText = document.getElementById("comment-message").value;
        const postId = document.getElementById("post-id").value; // Récupérez la valeur de post-id (en supposant que c'est un champ input. Si c'est un autre élément, ajustez en conséquence)
    
        fetch('?action=comment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `comment-message=${encodeURIComponent(commentText)}&post-id=${encodeURIComponent(postId)}`
        })
        .then(data => data.json())
        .then(data => {
            alert(data.message);
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        })
        .catch((error) => {
            console.error("Erreur :", error);
            alert("Une erreur est survenue lors de l'envoi du commentaire.");
        });
    });
    
});
