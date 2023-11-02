# Provides a Bridge between Socialment, Bastion, and Azure AD.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/chrisreedio/socialment-bastion-azure.svg?style=flat-square)](https://packagist.org/packages/chrisreedio/socialment-bastion-azure)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/chrisreedio/socialment-bastion-azure/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/chrisreedio/socialment-bastion-azure/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/chrisreedio/socialment-bastion-azure/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/chrisreedio/socialment-bastion-azure/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/chrisreedio/socialment-bastion-azure.svg?style=flat-square)](https://packagist.org/packages/chrisreedio/socialment-bastion-azure)



This is a **_highly_** opinionated package that provides a bridge between [Socialment](https://github.com/chrisreedio/socialment), [Bastion](https://github.com/chrisreedio/bastion), and [Azure AD](https://github.com/chrisreedio/laravel-azure-graph).

## Installation

You can install the package via composer:

```bash
composer require chrisreedio/socialment-bastion-azure
```
Then execute and follow the prompts:

```bash
php artisan socialment-bastion-azure:install
```

Include this plugin in your panel configuration:

```php
$panel
	->plugins([
		// ... Other Plugins
		\ChrisReedIO\Bastion\BastionPlugin::make(),
		\ChrisReedIO\Socialment\SocialmentPlugin::make()
            ->registerProvider('azure', 'fab-microsoft', 'Azure Active Directory'),
	])
```

This additional _glue_ package will automagically hook the pre-login callbacks from Socialment into Bastion's Roles via the SSO Group field.

Also if you're choosing to use the seeder(s) make sure you add the `RoleSeeder` to your `DatabaseSeeder.php` like this:

```php
$this->call([
    // ... Other Seeders
    RoleSeeder::class,
]);
```

### Individual Steps (Shouldn't be necessary)

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="socialment-bastion-azure-migrations"
php artisan migrate
```
Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="socialment-bastion-azure-views"
```

### Config

By default, the config does not get published upon install.

This is the contents of the published config `services.php` file:

_It is just the stock services file with the `azure` block added_

```php
return [
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'azure' => [
        'client_id' => env('AZURE_CLIENT_ID'),
        'client_secret' => env('AZURE_CLIENT_SECRET'),
        'redirect' => env('AZURE_REDIRECT_URI'),
        'tenant' => env('AZURE_TENANT_ID'),
        'proxy' => env('PROXY')  // Optional
    ],

];
```

You may publish the config after installation with:

```bash
php artisan vendor:publish --tag="socialment-bastion-azure-config"
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Chris Reed](https://github.com/chrisreedio)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
