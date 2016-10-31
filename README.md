# Laralang's documentation

[![StyleCI](https://styleci.io/repos/69460815/shield?branch=master)](https://styleci.io/repos/69460815)
![License](https://img.shields.io/github/license/24aitor/laralang.svg?style=flat-square)

## Getting Started

### Step 1. Require it with composer

```
composer require aitor24/laralang
```

### Step 2. Register service provider

Add the next line to config/app.php inside `'providers' => [` :

```
Aitor24\Laralang\LaralangServiceProvider::class,
```

### Step 3. Add Laralang Alias

Add the next line to config/app.php inside `'aliases' => [` :


```
'Laralang'   => Aitor24\Laralang\Facades\Laralang::class,
```



## Examples

### Traslations

```php
{!! Laralang::trans('hola mundo','es', 'ca') !!} <!-- it should print: hola món -->

{!! Laralang::trans('hello word','es') !!} <!-- it should print: hola mundo -->
```

### 'base' translations

```php
@lang('laralang::base.welcome')

{{trans('laralang::base.welcome')}}

{{trans('laralang::base.welcome_to', ['app_name' => 'Your app name'])}}

{{trans_choice('laralang::base.users_mp', 1)}}

{{trans_choice('laralang::base.users_mp', 5)}}
```
