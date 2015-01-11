Nette Playground based on Nette Sandbox
=======================================
[![Build Status](https://secure.travis-ci.org/LeonardoCA/nplayground.png)](https://travis-ci.org/LeonardoCA/nplayground.svg)
[![Built with Grunt](https://cdn.gruntjs.com/builtwith.png)](http://gruntjs.com/)
[![Latest stable](https://img.shields.io/packagist/v/LeonardoCA/nplayground.svg)](https://packagist.org/packages/LeonardoCA/nplayground)
[![Latest stable](https://img.shields.io/packagist/l/LeonardoCA/nplayground.svg)](https://packagist.org/packages/LeonardoCA/nplayground)

> Sandbox for experiments in Nette Framework, including bootstrap from twitter and bower/grunt support

Nette Playground is a pre-packaged and pre-configured Nette Framework application
that you can use as the skeleton for your new applications.

[Nette](http://nette.org) is a popular tool for PHP web development.
It is designed to be the most usable and friendliest as possible. It focuses
on security and performance and is definitely one of the safest PHP frameworks.


Installing
----------

The best way to install Sandbox is using Composer. If you don't have Composer yet, download
it following [the instructions](http://doc.nette.org/composer). Then use command:

```sh
$ composer create-project leonardoca/nplayground my-app
$ cd my-app
```

If you did not use [Bower](http://bower.io/) and [Grunt](http://gruntjs.com/) you need
to install them globally first. Both depend on [Node.js](http://nodejs.org/) and [npm](http://npmjs.org/).

```sh
$ npm install -g bower
$ npm install -g grunt
```

To install bower dependencies and run grunt build scripts than run.

```sh
$ npm install
$ grunt
```

Make directories `temp` and `log` writable. Navigate your browser
to the `www` directory and you will see a welcome page. PHP 5.4 allows
you run `php -S localhost:8888 -t www` to start the web server and
then visit `http://localhost:8888` in your browser.

It is CRITICAL that whole `app`, `log` and `temp` directories are NOT accessible
directly via a web browser! See [security warning](http://nette.org/security-warning).


License
-------
- Nette: New BSD License or GPL 2.0 or 3.0 (http://nette.org/license)
- jQuery: MIT License (https://jquery.org/license)
- Adminer: Apache License 2.0 or GPL 2 (http://www.adminer.org)
- Nette Playground: The Unlicense (http://unlicense.org)

### Release History
See the [CHANGELOG](CHANGELOG.md).
