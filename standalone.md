

## Standalone Usage (PHP 7.4+)

**config.php**
```php
<?php
return [
    /*
    |--------------------------------------------------------------------------
    | TrustedForm Endpoint
    |--------------------------------------------------------------------------
    | https://support.activeprospect.com/hc/en-us/articles/201325449
    | https://support.activeprospect.com/hc/en-us/articles/201325439
    |
    | TrustedForm will calculate the fingerprints on your behalf when you pass
    | some basic lead data in the capture method. TrustedForm will evaluate the
    | included data and calculate SHA1 hashes of any phone numbers and
    | email addresses, discarding the lead data once the hash is calculated.
    |
    */
    'api_url' => '',
    'api_user' => 'API',
    'api_key' => 'XXX',
    'api_retry' => [
        'times' => 1,
        'delay' => 2,
    ],
];
```

**Application.php**
```php
<?php
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Facade;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
class Application extends Container implements ApplicationContract{

    public static function create(){
        $app = new static;
        Facade::setFacadeApplication($app);
        return $app;
    }
    public function version()
    {
        return 1.0;
    }

    public function basePath($path = '')
    {
        return __DIR__."/$path";
    }

    public function bootstrapPath($path = '')
    {
        return __DIR__."/$path";
    }

    public function configPath($path = '')
    {
        return __DIR__."/config/$path";
    }

    public function databasePath($path = '')
    {
        return __DIR__."/database/$path";
    }

    public function resourcePath($path = '')
    {
        return __DIR__."/resources/$path";
    }

    public function storagePath()
    {
        return __DIR__."/storage";
    }

    public function environment(...$environments)
    {
        return in_array('production', $environments);
    }

    public function runningInConsole()
    {
        return false;
    }

    public function runningUnitTests()
    {
        return false;
    }

    public function isDownForMaintenance()
    {
        return false;
    }

    public function getLocale(){
        return 'en-US';
    }

    public function getNamespace()
    {
        return 'App';
    }
    public function shouldSkipMiddleware(){
        return true;
    }
    public function hasBeenBootstrapped(){
        return true;
    }

    public function registerConfiguredProviders(){}
    public function register($provider, $force = false){}
    public function registerDeferredProvider($provider, $service = null){}
    public function resolveProvider($provider){}
    public function boot(){}
    public function booting($callback){}
    public function booted($callback){}
    public function bootstrapWith(array $bootstrappers){}
    public function getProviders($provider){}
    public function loadDeferredProviders(){}
    public function setLocale($locale){}
    public function terminate(){}

}
```

**bootstrap.php**

```php
<?php
include_once __DIR__.'/vendor/autoload.php';

/**
 * Import Libraries
 */
use Application;
use Illuminate\Config\Repository as Config;
use BayAreaWebPro\TrustedForms\TrustedFormsService;
use Illuminate\Contracts\Config\Repository;

/**
 * Create Container Application
 */
$app = Application::create();

/**
 * Bind Services
 */
$app->bind(Repository::class, fn()=>new Config([
    'trusted-forms' => require $app->basePath('config.php')
]));
$app->bind('config', Repository::class);
$app->bind('trusted-forms', TrustedFormsService::class);

return $app;
```

**main.php**
```php
<?php
/** Make Trusted Forms  */
function trustedForm(){
    $app = (require __DIR__.'/bootstrap.php');
    return $app->make('trusted-forms');
}

try{
    /** Claim Certificate */
    $claim = trustedForm()->claimCertificate([
        'email' => 'john@example.com',
        'address' => '123 Example St.',
        'phone' => '123-456-7890',
    ]);

    /** Verify Validity of Certificate */
    if($claim->isValid()){
        $maskedUrl = $claim->getMaskedCertificateUrl();
    }
    dump($claim);

    /** Read Certificate and Verify Validity */
    $certificate = trustedForm()->readCertificate($claim->getCertificateToken());
    if($certificate->isValid()){
        $maskedUrls = $certificate->getCertificateUrls();
    }
    dump($certificate);

}catch (\Throwable $error){
    dump($error->getMessage());
}
```
