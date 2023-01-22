# laravel-json-structure

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hyperlink/laravel-json-structure.svg?style=flat-square)](https://packagist.org/packages/hyperlink/laravel-json-structure)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/hyperlinkgroup/laravel-json-structure/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/hyperlinkgroup/laravel-json-structure/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/hyperlink/laravel-json-structure.svg?style=flat-square)](https://packagist.org/packages/hyperlink/laravel-json-structure)

A helper package for the assert json structure test method. It will create a json structure as needed from an api endpoint of your application.

## Installation

You can install the package via composer:

```bash
composer require hyperlink/laravel-json-structure
```

## Usage

```php
$jsonStructure = new Hyperlink\JsonStructure();
echo $jsonStructure->echoPhrase('Hello, Hyperlink!');
```

## Credits

- [Katalam](https://github.com/Katalam)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
