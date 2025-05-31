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
```

This will create a new file in the `inits` directory with a timestamped prefix.
