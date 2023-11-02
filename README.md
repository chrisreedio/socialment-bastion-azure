# Provides a Bridge between Socialment, Bastion, and Azure AD.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/chrisreedio/socialment-bastion-azure.svg?style=flat-square)](https://packagist.org/packages/chrisreedio/socialment-bastion-azure)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/chrisreedio/socialment-bastion-azure/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/chrisreedio/socialment-bastion-azure/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/chrisreedio/socialment-bastion-azure/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/chrisreedio/socialment-bastion-azure/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/chrisreedio/socialment-bastion-azure.svg?style=flat-square)](https://packagist.org/packages/chrisreedio/socialment-bastion-azure)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require chrisreedio/socialment-bastion-azure
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="socialment-bastion-azure-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="socialment-bastion-azure-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="socialment-bastion-azure-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$socialmentBastionAzure = new ChrisReedIO\SocialmentBastionAzure();
echo $socialmentBastionAzure->echoPhrase('Hello, ChrisReedIO!');
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
