var xhr = new XMLHttpRequest();

xhr.open('POST', 'localhost/app_dev.php/tags/search');

var data = new FormData();
form.append('attr1', 'valeur1');
form.append('attr2', 'valeur2');

// pour une requête synchrone il n'y a qu'à vérifier le statut de la requête
xhr.addEventListener('load', function() {
    if (xhr.readyState === xhr.DONE) {
        var response = JSON.parse(xhr.responseText);
    }
}, false);

// encodeURIComponent(), afin d'éviter d'écrire d'éventuels caractères interdits dans une URL.

xhr.send(data);

// Traiter les données comme une variable post dans le PHP
