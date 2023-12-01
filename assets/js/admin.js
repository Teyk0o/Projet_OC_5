console.log('admin.js chargé 1');

document.addEventListener("DOMContentLoaded", function() {
    console.log('admin.js chargé');

    const addArticleForm = document.querySelector("#addArticleForm");
    const modifyArticleForm = document.querySelector("#modifyArticleForm");
    const modifyButtons = document.querySelectorAll('.btn-warning[data-article-id]'); // Sélectionne tous les boutons de modification d'article
    const deleteButtons = document.querySelectorAll('[data-toggle="modal"][data-target="#deleteArticleModal"]'); // Sélectionne tous les boutons de suppression d'article

    const approvedCommentBtn = document.getElementById('approveComment');
    const disapprovedCommentBtn = document.getElementById('disapproveComment');

    let articleIdToDelete = null;

    addArticleForm.addEventListener("submit", function(event) {
        event.preventDefault();
        sendArticleData(this, "addArticle");
    });

    modifyArticleForm.addEventListener("submit", function(event) {
        event.preventDefault();
        sendArticleData(this, "modifyArticle");
    });

    modifyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const articleId = this.getAttribute('data-article-id');
            fetchArticleData(articleId);
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            articleIdToDelete = this.getAttribute('data-article-id');
        });
    });

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (articleIdToDelete) {
            fetch('?action=deleteArticle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=delete_article&article_id=${encodeURIComponent(articleIdToDelete)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error("Erreur:", error);
                alert('Une erreur est survenue lors de la suppression de l\'article.');
            });
        }
    });

    approvedCommentBtn.addEventListener('click', function() {
        const commentId = this.getAttribute('data-comment-id');
        sendArticleData(null, "approveComment", commentId);
    });

    disapprovedCommentBtn.addEventListener('click', function() {
        const commentId = this.getAttribute('data-comment-id');
        sendArticleData(null, "disapproveComment", commentId);
    });
});

function sendArticleData(form, type, option=null) {
    let formData;

    if (form) {
        formData = new FormData(form);
    } else {
        formData = new FormData();
    }

    formData.append("action", type);

    if (option) {
        formData.append("option", option);
    }

    const url = `?action=${type}`;

    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error("Erreur:", error);
        alert('Une erreur est survenue lors de l\'ajout de l\'article.');
    });
}

function fetchArticleData(articleId) {
    fetch('?action=fetchArticle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=fetch_article&article_id=${encodeURIComponent(articleId)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {

            console.log(data.article);

            // Remplir le formulaire avec les données de l'article
            document.getElementById('modify-article-id').value = data.article.id;
            document.getElementById('modify-title').value = data.article.title;
            document.getElementById('modify-chapo').value = data.article.chapo;
            document.getElementById('modify-content').value = data.article.content;

            // Ouvrir la modal
            var modal = new bootstrap.Modal(document.getElementById('modifyArticleModal'));
            modal.show();
        } else {
            alert('Erreur lors de la récupération des données de l\'article.');
        }
    })
    .catch(error => {
        console.error("Erreur:", error);
        alert('Une erreur est survenue lors de la récupération des données de l\'article.');
    });
}

