amicale-src
===========

Amicale GIL (Génie de l'Informatique Logicielle) is a University Project.

###Installation GULP

Pour compiler le css (et le minifier) on utilise gulp.

Tout d'abord il faut installer node.js.
Ensuite dans un terminal entrez : 

<code>npm install -g gulp</code>

Une fois gulp installé, avec un terminal, allez dans le repertoire du projet. Puis entrez :

<code>npm install</code>

Cela va télécharger puis installer les dépendances nécessaires pour compiler le sass et minifier le css.

Tout est prêt gulp est utilisable.

###Les commande GULP

Toutes les commandes ci-dessous sont à executer à la racine du projet (la où il y a le fichier gulp.js)

Pour compiler le sass et minifier le css :

<code>gulp css</code>

Attention le nouveau fichier css est automatique copier dans web/css à la place de l'ancien.

Pour mettre gulp en mode watch, c'est à dire que gulp surveille les fichiers sass et effectue l'opération ci-dessus à chaque 
modification d'un fichier. Il faut utiliser :

<code>gulp css:watch</code>
