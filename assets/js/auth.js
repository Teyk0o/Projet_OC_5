document.addEventListener("DOMContentLoaded", function() {

    const loginForm = document.querySelector("#loginForm");
    const registerForm = document.querySelector("#registerForm");
    const logoutBtn = document.getElementById("logout");

    loginForm.addEventListener("submit", function(event) {
        event.preventDefault();
        sendData(this, "assets/forms/auth_handler.php", "login");
    });

    registerForm.addEventListener("submit", function(event) {
        event.preventDefault();
        sendData(this, "assets/forms/auth_handler.php", "register");
    });

    logoutBtn.addEventListener("click", function(event) {
        event.preventDefault();
        sendData(null, "assets/forms/auth_handler.php", "logout");
    });

});

function sendData(form, url, type) {
    let formData;

    if (form !== null) {
        formData = new FormData(form);
    } else {
        formData = new FormData();
    }
    
    formData.append("action", type);

    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(data => data.json())
    .then(data => {
        if (data.success) {
            alert(data.message + " Vous allez être redirigé vers la page d'accueil.");
            setTimeout(function() {
                window.location.href = "index.php";
            }, 1500);
        } else {
            handleErrorResponse(data.message);
        }
    })
    .catch(error => {
        console.error("Erreur:", error);
        alert('Une erreur est survenue lors de l\'envoi du formulaire.');
    });
}

function handleErrorResponse(message) {
    switch (message) {
        case "noaccount":
            alert("Aucun compte n'est associé à cette adresse email.");
            break;
        case "wrongpassword":
            alert("Mot de passe ou adresse e-mail incorrect.");
            break;
        case "emailalreadyused":
            alert("Cette adresse email est déjà utilisée.");
            break;
        case "useralreadyexists":
            alert("Un compte existe déjà avec ce nom d'utilisateur.");
            break;
        default:
            alert("Une erreur est survenue, veuillez réessayer plus tard.");
            break;
    }
}