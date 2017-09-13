# Laradeck Commands

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A set of useful Laravel artisan commands

- `php artisan laradeck:view admin.users.show` Create a new view `views/admin/users/show.blade.php`

## Install

### Downloading
Via Composer

``` bash
$ composer require ngtfkx/laradeck-commands --dev
```

### Registering the service provider
If you're using Laravel 5.5+, you can skip this step. The service provider will have already been registered
thanks to auto-discovery. 

Otherwise, register `Ngtfkx\Laradeck\Commands\LaradeckCommandsServiceProvider::class` manually in your `AppServiceProvider`'s
`register` method:

```php
public function register()
{
    if ($this->app->environment() !== 'production') {
        $this->app->register(\Ngtfkx\Laradeck\Commands\LaradeckCommandsServiceProvider::class);
    }    
}
```

## Usage

### laradeck:view

``` bash
# Create a new view
php artisan laradeck:view admin.users.show
```

``` bash
# Create a new view and rewrite old with same name
php artisan laradeck:view admin.users.show --force
```

``` bash
# Create a new view with @extends directive
php artisan laradeck:view admin.users.show --extends=layouts.app
```

``` bash
# Create a new view with @section directive
php artisan laradeck:view admin.users.show --section=content --section=sidebar
```

``` bash
# Create a new view with @section directive (other syntax)
php artisan laradeck:view admin.users.show --section=content,sidebar
```

Similarly for `@push` (`--stack`) and `@component` (`--component`) directives.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Denis Sandal][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/ngtfkx/laradeck-commands.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-build]: https://scrutinizer-ci.com/g/ngtfkx/laradeck-commands/badges/build.png?b=master
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/ngtfkx/laradeck-commands.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/ngtfkx/laradeck-commands.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/ngtfkx/laradeck-commands.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/ngtfkx/laradeck-commands
[link-build]: https://scrutinizer-ci.com/g/ngtfkx/laradeck-commands
[link-scrutinizer]: https://scrutinizer-ci.com/g/ngtfkx/laradeck-commands/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/ngtfkx/laradeck-commands
[link-downloads]: https://packagist.org/packages/ngtfkx/laradeck-commands
[link-author]: https://github.com/:author_username
[link-contributors]: ../../contributors
