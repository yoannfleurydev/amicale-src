# Intégration des tags à une vue
Pour intégrer la fonctionnalité des tags, veuillez suivre les insctructions suivantes.

## Installation

### Généralités
Pour se servir des fonctionnalité d'ajout de tags.
1. Importer le fichier ci-dessous pour les fonctionnalités des tags hors suppression.

```html
<script src="tags.js"></script>
```

2. L'input dans lequel on tape les tags doit avoir l'id unique :

```html
<input id="tags_input" name="name" />
```

3. La page doit contenir une div initialement vide ayant pour ii unique :

```html
<div id="tags_container"></div>
```

Cette div permettra d'afficher au fur et à mesure les tags disponibles sous forme de bouton.

### Suppression
Pour se servir de la suppression des tags.

1. Importer le fichier

```html
<script src="admin_tag.js"></script>
```

2. Les tags doivent être sous forme de bouton dont la value est le nom du tag et possédant la classe :

```html
<button class="deleteTag">PHP</button>
```

## Utilisation
Pour profiter pleinement des fonctionnalités offertes par les tags, les instructions suivantes sont importantes.

Bien vérifier le type enregistré dans l'entité hydratée par le formulaire. Un fait courant est que le type soit une chaine de caractères au lieu d'un tableau (lié au fait que le champ utilisé est un input text).
Dans ce cas il est donc obligatoire de transformer la valeur contenue dans l'entité par un tableau d'entité Tag.

Pour vous assurez d'insérer tous les tags saisis, veillez à utiliser le service
> agil_default.tags

Vous y trouverez une méthode d'insertion
```PHP
function insertTag($tagName, $color = 'tag-default', AgilSkill $skillCat = null);
```
Qui permet d'assurer la présence des tags entrés par l'utilisateur dans la base de données avant l'enregistrement.
Une fois que vous aurez terminé cette action, utilisez la méthode :
```PHP
function insertDone();
```
Pour signifier la fin de l'ajout de tags et enregistrer vos modifications.

Assurez vous de bien enregistrer votre tableau de tags dans l'entité.
Vous pouvez utiliser les deux méthodes suivantes par exemple :

1. Méthode classique

**`findBy` renvoie un tableau d'entités**

```PHP
$entity->setTags($tagRepository->findBy(array('tagName' => $tagsArrayString)));
```
  Dans laquelle
  * `$entity` est l'entité dans laquelle il faut enregistrer la liste de tags
  * `$tagRepository` est le repository associé aux tags
  * `$tagsArrayString` est le tableau de chaines de caractères de chaque tag entré par l'utilisateur

2. En utilisant une fonction magique
En utilisant la même fonction `findBy` mais y ajoutant directement le nom de l'attribut à la fin.
```PHP
$entity->setTags($tagRepository->findByTagName($tagsArrayString));
```
