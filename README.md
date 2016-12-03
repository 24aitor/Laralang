# Laralang

[![StyleCI](https://styleci.io/repos/69460815/shield?branch=master)](https://styleci.io/repos/69460815)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/24aitor/laralang.svg?style=flat-square)](https://scrutinizer-ci.com/g/24aitor/laralang/?branch=master)
[![GitHub license](https://img.shields.io/github/license/24aitor/laralang.svg?style=flat-square)](https://raw.githubusercontent.com/24aitor/laralang/master/LICENSE)

![](http://i.imgur.com/11Tvcoh.png)

## Getting Started

### Step 1. Install it with composer

Running the command below:

```
composer require aitor24/laralang
```

### Step 2. Register service provider & aliases

Include the line below to config/app.php inside array `'providers' => [` :

```
Aitor24\Laralang\LaralangServiceProvider::class,
```


*Now alias is registred automatically. On config, you can set the alias*


### Step 3. Publish vendor

It will publish assets and config file.

Running the command below:

```
php artisan vendor:publish
```

### Step 4. Migrate


Running the command below:

```
php artisan migrate
```


### Step 5. Configure defalt values

**STRONGLY IMPORTANT:** Change the password of config *(Default password: laralangAdmin )*

Apart from the password, the rest of default values can be modified also on `config/laralang.php`. Furthermore you can modify it in a specific translation with the functions below.

## Using laralang

### Functions

**setFrom()**


It sets the language of the string to translate in a specific translation.

*Default: en*

**SetTo()**

It sets the language that you'll output in a specific translation.

*Default: app_locale*

**SetTranslator()**

This option let you to change the default translator in a specific translation.

*Default: mymemory*

*Currently there are two available translators: apertium, mymemory. But we strongly recommend to use mymemory.*

**setDebug()**

Debug option let you to know the reason of an unexpected result with colorful messages in a specific translation.

*Default: false*

***************

### Examples of use


Then few examples of tranlsation:



```php
{!! Laralang::trans('Hello world!') !!}
<br>
{!! Laralang::trans('Hello world!')->setDebug(true) !!}
<br>
{!! Laralang::trans('Hello world!')->setTo('es') !!}
<br>
{!! Laralang::trans('Hello world!')->setTo('ca') !!}
<br>
{!! Laralang::trans('Hello world!')->setTo('ca')->setDebug(true) !!}
<br>
{!! Laralang::trans('Hallo welt!')->setFrom('de')->setTo('fr') !!}
<br>
{!! Laralang::trans('Hello world!')->setTo('pt') !!}
<br>
{!! Laralang::trans('Hello world!')->setTo('de') !!}
<br>
{!! Laralang::trans('Hello world!')->setTo('ml') !!}
<br>
{!! Laralang::trans('Hello world!')->setTo('zh') !!}
```

Then the result:

![Result of example](http://i.imgur.com/LKOjZdB.png)

### Admin panel

Furthermore now you can control which translations are saved on your DB and then you can manage it *(edit and delete)*.

#### First you should be logged into loaralang.

*Route prefix can be changed on your config file, but by default it's laralang*

- How to acces to panel?

You should visit next url:

http://host.domain/laralang/login

or in localhost you should visit

http://localhost/project-path/public/laralang/login

Then you should see the laralang login page (photo below)

![Laralang login page](http://i.imgur.com/3DgOs3C.png)

Now you must enter the password you set on [Step 5](#step-5) and then click login to manage your translations!

![View of translations](http://i.imgur.com/8eUzetl.png)

![Editing translation #3](http://i.imgur.com/f3pcwab.png)
