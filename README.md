# Laravel Trusted Forms

A service wrapper for the Laravel HTTP client designed for working with the Active Prospect API to generate "TCPA Compliant Trusted Form Certificates".

![](https://github.com/bayareawebpro/laravel-trusted-forms/workflows/ci/badge.svg)
![](https://img.shields.io/packagist/dt/bayareawebpro/laravel-trusted-forms.svg)
![](https://img.shields.io/github/v/release/bayareawebpro/laravel-trusted-forms.svg)
![](https://img.shields.io/badge/License-MIT-success.svg)


```shell script
composer require bayareawebpro/laravel-trusted-forms
```

> https://packagist.org/packages/bayareawebpro/laravel-trusted-forms

Laravel Trusted Forms...WIP

--- 

## Claim Certificate: 
```php
use BayAreaWebPro\TrustedForms\TrustedForms;

$claim = TrustedForms::claimCertificate(request()->only([...]));
$claim->getMaskedCertificateUrl();
$claim->getCertificateToken();
$claim->hasValidCertificate();
$claim->hasValidExpiration();
$claim->hasValidClaims();
$claim->isValid();

$claim->collect('nested.array');
$claim->get('nested.key', 'fallback-values');
```

## Read Certificate: 

```php
use BayAreaWebPro\TrustedForms\TrustedForms;

$certificate = TrustedForms::readCertificate($token);
$certificate->hasValidExpiration();
$certificate->hasValidClaims();
$certificate->isValid();

$certificate->collect('nested.array');
$certificate->get('nested.key', 'fallback-values');
```

--- 

## TrustedForm Documentation

> This is an Open Source Community Project and is not provided by ActiveProspect, or it's affiliates.

https://support.activeprospect.com/hc/en-us/categories/200128909-TrustedForm
