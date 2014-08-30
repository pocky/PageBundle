Getting Started With BlackPageBundle
======================================

## Prerequisites

This bundle requires Symfony 2.5+ and PHP 5.4

### Translations

If you wish to use default texts provided in this bundle, you have to make sur you have translator enabled in your
config.

``` yaml
# app/config/config.yml

framework:
    translator: ~
```

For more information about translations, check
[Symfony documentation](http://symfony.com/doc/current/book/translation.html).


Installation
------------

The recomanded way to install CommonBundle is through [Composer][1]:

```json
{
    "require": {
        "black/page-bundle": "@stable"
    }
}
```

__Protip:__ You should browse the [`black/page-bundle`][2] page to choose a stable version to use, avoid the `@stable`
 meta constraint.

Usage
-----

Just load BlackCommonBundle in your AppKernel.

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Black\Bundle\PageBundle\BlackPageBundle(),
    );
}
```

Champagne!
----------

Now that you have completed the basic installation of the BlackPageBundle you are ready
to [use it](use.md)!

[1]: http://getcomposer.org/
[2]: https://packagist.org/packages/black/page-bundle




