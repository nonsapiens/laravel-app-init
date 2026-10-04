# laravel-app-init
An application initialiser that - like migrations - keeps track of on-deploy application commits.

## Usage

Run pending initialisation commands:

```bash
php artisan app:init
```

Create a new init class:

```bash
php artisan init:create MyInitName
# or, using the alias
php artisan make:init MyInitName
```

This will create a new file in the `inits` directory with a timestamped prefix.

## Loading inits from packages

Packages can register their own init directories from a service provider:

```php
use Nonsapiens\LaravelAppInit\AppInit;

public function boot(): void
{
    AppInit::loadInitsFrom(__DIR__.'/../../inits');
}
```

Inits are tracked by file name. When an init of the same name exists in both the application's `inits`
directory and a registered path, the registered (package) copy is run, making the package the source of truth.
