# Laralang's documentation

[![Latest Stable Version](https://poser.pugx.org/aitor24/laralang/v/stable?format=flat-square)](https://packagist.org/packages/aitor24/laralang)
[![StyleCI](https://styleci.io/repos/69460815/shield?branch=master)](https://styleci.io/repos/69460815)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/24aitor/laralang.svg?style=flat-square)](https://scrutinizer-ci.com/g/24aitor/laralang/?branch=master)
[![GitHub license](https://img.shields.io/github/license/24aitor/laralang.svg?style=flat-square)](https://raw.githubusercontent.com/24aitor/laralang/master/LICENSE)

## Getting Started

### Step 1. Require it with composer

You should run next command:

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

### Step 4. Publish config file

You should run next command:

```
php artisan vendor:publish --tag=laralang_config
```

## Examples

### Traslations

You shold call it like:

```php

{!! Laralang::trans('Hello world') !!}

```

*Currently there are two available translators: apertium, mymemory. But we strongly recommend to use mymemory.*

#### Functions

Moreover you can use different functions in each translation.

**setFromLang()**


It sets the language of the string to translate in a specific translation.

*Default: en*

**SetToLang()**

It sets the language that you'll output in a specific translation.

*Default: app_locale*

**SetTranslator()**

This option let you to change the default translator in a specific translation.

*Default: mymemory*

**setDebug()**

Debug option let you to know the reason of an unexpected result with colorful messages in a specific translation.

*Default: false*

***************

Default values can be modified on `config/laralang.php`. Furthermore you can modify it in a specific translation with the functions above.

Then few examples:


![Result of example](https://goo.gl/XiqJ23)

```php
{!! Laralang::trans('Hello world!') !!}

<br>

{!! Laralang::trans('Hello world!')->setDebug(true) !!}

<br>

{!! Laralang::trans('Hello world!')->setDebug(true)->setToLang('de') !!}

<br>

{!! Laralang::trans('Hallo welt!')->setFromLang('de')->setToLang('fr') !!}

<br>

{!! Laralang::trans('Hallo welt!')->setDebug(true)->setFromLang('de')->setToLang('fr')->setTranslator('apertium') !!}
<!-- it fails because apertium doesn't support this lang pair -->
```


### 'base' translations

```php

@lang('laralang::base.welcome')

{{trans('laralang::base.welcome')}}

{{trans('laralang::base.welcome_to', ['app_name' => 'Your app name'])}}

{{trans_choice('laralang::base.users_mp', 1)}}

{{trans_choice('laralang::base.users_mp', 5)}}

```
