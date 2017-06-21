# Bglobal\Options

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Style CI](https://styleci.io/repos/53683729/shield)](https://styleci.io/repos/53683729)
[![Total Downloads][ico-downloads]][link-downloads]

An interface for the administrator to easily change application options. Uses Laravel Bglobal. On Laravel 5.2, 5.3, and 5.4

## Install

1) In your terminal:

``` bash
$ composer require bglobal/options
```

2) Add the service provider to your config/app.php file:
```php
Bglobal\Options\BglobalOptionsServiceProvider::class,,
```

3) Run the migration and add some example settings:
```bash
$ php artisan vendor:publish --provider="Bglobal\Options\BglobalOptionsServiceProvider"
$ php artisan migrate
```

4) [Optional] Add a menu item for it in your sidebar

```html
<li><a href="{{ url(config('option.route_prefix', 'admin') . '/options') }}"><i class="fa fa-cog"></i> <span>Options</span></a></li>
```

## Usage

### End user
Add it to the menu or access it by its route: **application/admin/options**

### Programmer
Use it like you would any config value in a virtual settings.php file. Except the values are stored in the database and fetched on boot, instead of being stored in a file.

``` php
Config::get('option.contact_email')
```

### Add new settings

Settings are stored in the database in the "settings" table. Its columns are:
- id (ex: 1)
- key (ex: contact_email)
- name (ex: Contact form email address)
- description (ex: The email address that all emails go to.)
- value (ex: admin@laravelbackpack.com)
- field (Backpack CRUD field configuration in JSON format. https://laravel-backpack.readme.io/docs/crud-fields#standard-field-types)
- active (1 or 0)
- created_at
- updated_at

There is no interface available to add new settings. They are added by the developer directly in the database, since the Backpack CRUD field configuration is a bit complicated. See the field types and their configuration code on https://laravel-backpack.readme.io/docs


## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email hello@tabacitu.ro instead of using the issue tracker.

Please **[subscribe to the Backpack Newsletter](http://eepurl.com/bUEGjf)** so you can find out about any security updates, breaking changes or major features. We send an email every 1-2 months.

## Credits

- [Cristian Tabacitu][link-author]
- [All Contributors][link-contributors]

## License

Bglobal pack is free for non-commercial use and $19/project for commercial use.
