var xhr = new XMLHttpRequest();
xhr.open('POST', 'search');

/* On crée un pseudo formulaire pour remplir plus
 aisément les valeurs dans la requête */
var data = new FormData();

// TODO Changer le 2nd argument par la valeur reçue par la saisie utilisateur
data.append('prefix', 'a');

// pour une requête synchrone il n'y a qu'à vérifier le statut de la requête
xhr.addEventListener(
    'load',
    function() {
        if (xhr.readyState === xhr.DONE) {
            // response est un objet JS
            var response = JSON.parse(xhr.responseText);
            console.log(response);
        }
    },
    false
);

xhr.send(data);