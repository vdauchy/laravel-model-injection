**Laravel Model Injector**

This package is a simple trait to help on Model Injection. 

The main goal is to replace class set in config as in [laravel-permission](https://github.com/spatie/laravel-permission/blob/master/config/permission.php):

```php
// In: config/permission.php
return [
    'models' => [
        'permission' => Permission::class,
        'role' => Role::class,
    ],
    ...
];

// In: src/PermissionRegistrar.php
public function __construct(CacheManager $cacheManager)
{
    $this->permissionClass = config('permission.models.permission');
    $this->roleClass = config('permission.models.role');
    ...
}
```

And instead do:

```php
// In: src/PermissionRegistrar.php

use HasModelInjection;

public function __construct(CacheManager $cacheManager)
{
    $this->permissionClass = $this->mClass(Permission::class);
    $this->roleClass = $this->mClass(Role::class);
    ...
}
```

To use their own class, any developer can do:

```php
$this->app->bind(Permission::class, MyCustomPermission::class);
```

**Current API:**


`mQuery(string $model): Builder`: Let you build a query against this Model.

`mNew(string $model, array $attributes = []): Model`: Let you create a new instance of this Model.

`mClass(string $model): string`: Return the class associated to the Model.

`mTable(string $model): string`: Return the table's name of the Model".

`mColumns(string $model): Collection`: Return a Collection of columns.