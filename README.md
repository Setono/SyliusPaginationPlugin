# Sylius Pagination Plugin

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]

Add prev and next links to your Sylius paginated pages.

**UPDATED: Google does not use prev/next links in ranking nor indexing. See [searchengineland.com/google-apologizes-for-relnext-prev-mixup-314494](https://searchengineland.com/google-apologizes-for-relnext-prev-mixup-314494)**

## Installation

### Step 1: Download the plugin

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

```bash
$ composer require setono/sylius-pagination-plugin
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.


### Step 2: Enable the plugin

Then, enable the plugin by adding it to the list of registered plugins/bundles
in `config/bundles.php`:

```php
<?php
# config/bundles.php

return [
    // ...
    Setono\SyliusPaginationPlugin\SetonoSyliusPaginationPlugin::class => ['all' => true],
    // ...
];
```

[ico-version]: https://img.shields.io/packagist/v/setono/sylius-pagination-plugin.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://travis-ci.com/Setono/SyliusPaginationPlugin.svg?branch=master
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Setono/SyliusPaginationPlugin.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/setono/sylius-pagination-plugin
[link-travis]: https://travis-ci.com/Setono/SyliusPaginationPlugin
[link-code-quality]: https://scrutinizer-ci.com/g/Setono/SyliusPaginationPlugin
