AmicaleGIL
===========

Amicale GIL (Génie de l'Informatique Logicielle) is a University Project.

## Customization

To theme the application, you need to work with the `bootstrap-src/sass` files.
To compile the files, you need `gulp`. Let's install it with npm :

```bash
npm install -g gulp
```

To install all the dependencies, you need to run `npm install` in the root folder where the `package.json` file is.
Gulp is now ready. Just run `gulp css` to compile from SASS files to a CSS one. You can also run `gulp css:watch` to
compile the SASS on the fly when you save any of the files.

## Installation

You'll need [Composer](https://getcomposer.org/) to install all the PHP dependencies. When composer is installed on
your server, run `composer install` to install all the dependencies such as the Symfony framework, captcha component
etc.

### Development

1. You just need to launch the file named `launch.sh` to install everything.

### Production

1. Manually run `app/check.php` to see if you server is ready to host this application.

2. Symfony requires some PHP extensions to run perfectly : `json`, `ctype`. Also, this application need `gd`. You can
take a look at [this Symfony 2.8 wiki page](http://symfony.com/doc/2.8/reference/requirements.html) to see all the
requirements needed by Symfony.

## Contributors

* [Vincent Bernière](mailto:vincent.berniere@etu.univ-rouen.fr)
* [Quentin Brodier](mailto:quentin.brodier@etu.univ-rouen.fr)
* [Matthieu Coulon](mailto:matthieu.coulon@etu.univ-rouen.fr)
* [Valentin Crochemore](mailto:valentin.crochemore1@etu.univ-rouen.fr)
* [Yoann Fleury](mailto:yoann.fleury@etu.univ-rouen.fr)
* [Mohamed Ibrihen](mailto:mohamed.ibrihen@etu.univ-rouen.fr)
