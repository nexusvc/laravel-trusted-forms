# Laravel Trusted Forms

A service wrapper for the Laravel HTTP client designed for working with the Active Prospect API to generate "TCPA Compliant Trusted Form Certificates".

> This is an Open Source Community Project and is not affiliated with ActiveProspect or affiliates.

![](https://github.com/bayareawebpro/laravel-trusted-forms/workflows/ci/badge.svg)
![](https://img.shields.io/packagist/dt/bayareawebpro/laravel-trusted-forms.svg)
![](https://img.shields.io/github/v/release/bayareawebpro/laravel-trusted-forms.svg)
![](https://img.shields.io/badge/License-MIT-success.svg)


```shell script
composer require bayareawebpro/laravel-trusted-forms
```

> https://packagist.org/packages/bayareawebpro/laravel-trusted-forms

Laravel Trusted Forms...WIP


## Usage: 
```php
use BayAreaWebPro\TrustedForms\TrustedForms;

$certificate = TrustedForms::make(session('lead', []), [
    ...
]);
```
