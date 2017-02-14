# CodeIgniter Seed

This package installs the offical [CodeIgniter](https://github.com/bcit-ci/CodeIgniter) (version `3.0.*`) with secure folder structure via Composer.

You can update CodeIgniter system folder to latest version with one command.

## Folder Structure

```
codeigniter/
├── application/
├── bin/
│   ├── install-deps.sh
├── composer.json
├── composer.lock
├── public/
│   ├── assets
│   │   ├── css
│   │   ├── images
│   │   ├── js
│   │   ├── images
│   │   ├── plugins-bower
│   ├── .htaccess
│   └── index.php
└── vendor/
    └── codeigniter/
        └── framework/
            └── system/
```

## Requirements

* PHP 5.3.2 or later
* `composer` command (See [Composer Installation](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx))
* `bower`
* Git

## How to Use

### Install
1. **Install dependences:**

    ```
    $ cd bin/               #go to bin folder
    $ sh install-deps.sh    #run install dependences script
    $ cd ../                #back to project root folder
    ```
2. **Copy database config file**

    ```
    $ cp application/config/database-template.php application/config/database.php
    ```
    Edit file *application/config/database.php* with your database.

**Now you can run project**

### Run PHP built-in server (PHP 5.4 or later)

```
$ bin/server.sh
```

### Update

```
$ composer update       #update php dependences
$ bower update          #update js/css dependences
```

You must update files manually if files in `application` folder or `index.php` change. Check [CodeIgniter User Guide](http://www.codeigniter.com/user_guide/installation/upgrading.html).

## Other plugin, document using in Seed

* [Composer Installation](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
* [CodeIgniter](https://github.com/bcit-ci/CodeIgniter)
* [Codeigniter base model document](CURD_BASE.md)
* [CodeIgniter phpunit test](https://github.com/kenjis/ci-phpunit-test)
* [Ion Auth](https://github.com/benedmunds/CodeIgniter-Ion-Auth)
* [CodeIgniter Rest Server](https://github.com/chriskacerguis/codeigniter-restserver)


## Other Related Projects for CodeIgniter 3.0

* [Translations for CodeIgniter System](https://github.com/bcit-ci/codeigniter3-translations)
* [Modular Extensions - HMVC](https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc)
* [CodeIgniter HMVC Modules](https://github.com/jenssegers/codeigniter-hmvc-modules)
* [Codeigniter Matches CLI](https://github.com/avenirer/codeigniter-matches-cli)
* [Cli for CodeIgniter 3.0](https://github.com/kenjis/codeigniter-cli)
* [CodeIgniter Simple and Secure Twig](https://github.com/kenjis/codeigniter-ss-twig)
* [CodeIgniter Doctrine](https://github.com/kenjis/codeigniter-doctrine)
* [CodeIgniter Deployer](https://github.com/kenjis/codeigniter-deployer)
* [CodeIgniter3 Filename Checker](https://github.com/kenjis/codeigniter3-filename-checker)
* [CodeIgniter Widget (View Partial) Sample](https://github.com/kenjis/codeigniter-widgets)
