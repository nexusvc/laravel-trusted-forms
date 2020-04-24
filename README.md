# Laravel Trusted Forms


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
