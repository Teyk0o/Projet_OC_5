document.addEventListener("DOMContentLoaded", function() {

    const loginForm = document.querySelector("#loginForm");
    const registerForm = document.querySelector("#registerForm");
    const logoutBtn = document.getElementById("logout");

    loginForm.addEventListener("submit", function(event) {
        event.preventDefault();
        sendData(this, "login");
    });

    registerForm.addEventListener("submit", function(event) {
        event.preventDefault();
        sendData(this, "register");
    });

    logoutBtn.addEventListener("click", function(event) {
         event.preventDefault();
         sendData(null, "logout");
    });

});

function sendData(form, type) {
    let formData;

    if (form !== null) {
        formData = new FormData(form);
    } else {
        formData = new FormData();
    }
    
    formData.append("action", type);

    const url = `?action=${type}`

    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(data => data.json())
    .then(data => {
        if (data.success) {
            alert(data.message + " Vous allez être redirigé vers la page d'accueil.");
            setTimeout(function() {
                window.location.href = "/";
            }, 1500);
        } else {
            alert(data.message);
        }
    });
}