# Intégration des tags à une vue
Pour intégrer la fonctionnalité des tags, veuillez suivre les insctructions suivantes.

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
