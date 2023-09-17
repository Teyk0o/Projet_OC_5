document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector(".php-email-form");

    form.addEventListener("submit", function(event) {
        event.preventDefault();
        
        const formData = new FormData(form);
        
        fetch('assets/forms/contact_form_processor.php', {
            method: 'POST',
            body: formData
        })
        .then(data => {

            if (data.status === 200) {
                alert("Votre demande de contact a bien été envoyée.");
                form.reset();
            } else if (data.status === "error") {
                alert("Une erreur est survenue lors de l'envoi du formulaire.");
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert("An error occurred while submitting the form.");
        });
    });
});
