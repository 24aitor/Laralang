<h1 align="center">Laralang</h1>

![](http://i.imgur.com/11Tvcoh.png)

<p align="center">
    <a href="https://styleci.io/repos/69460815"><img src="https://styleci.io/repos/69460815/shield?branch=master" alt="StyleCI"></a>
    <a href="https://scrutinizer-ci.com/g/24aitor/laralang/?branch=master"><img src="https://img.shields.io/scrutinizer/g/24aitor/laralang.svg?style=flat-square" alt="Scrutinizer"></a>
    <a href="https://packagist.org/packages/aitor24/laralang"><img src="https://poser.pugx.org/aitor24/laralang/v/stable?format=flat-square" alt="Latest Stable Version"></a>
    <a href="https://raw.githubusercontent.com/24aitor/laralang/master/LICENSE"><img src="https://img.shields.io/github/license/24aitor/laralang.svg?style=flat-square" alt="License"></a>
</p>

## What is Laralang?

Laralang is a laravel packages that allows you to translate your app or parts of your app from views using
translations services like google or mymemory, and then store it on your DB to filter and manage easily
from our admin panel.

Moreover, allows you to translate PHP files easily and then save lot of time to you.

# Why use Laralang?

Personally I think the best way to translate your website is using the Laravel methods such as ``@lang()`` but sometimes it's impossible.
Imagine you have a blog, and you need to translate it to different languages. With Laralang it's soo easy to do it, only place a little code like
following example and laralang will translate it from your favourite translation service or well loading a stored translation on your database.

```php
{{ Laralang::trans($post->content) }}
```

## Getting Started

### Step 1. Install it with composer

Running the command below:

```
composer require aitor24/laralang
```

### Step 2. Register service provider & aliases

Include the line below to config/app.php inside providers array :

```php
Aitor24\Laralang\LaralangServiceProvider::class,
```

Include the line below to config/app.php inside aliases array :

```php
'Laralang'   => Aitor24\Laralang\Facades\Laralang::class,
```


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

**STRONGLY IMPORTANT:** Change the password on config *(Default password: laralangAdmin )*

Apart from the password, the rest of default values can be modified also on `config/laralang.php`. Furthermore you can modify these in a specific translation with the functions below.

**Available Translators:** Google Translator, MyMemory, Apertium (Strongly not recomended)

*config values for translators*: 'google', 'mymemory', 'apertium'


## Using laralang

### Simple examples of use


Then few examples of use laralang:


```php
<center>
    {!! Laralang::trans('Hello world!') !!}
    <br>
    {!! Laralang::trans('Hello world!')->debug(true) !!}
    <br>
    {!! Laralang::trans('Hello world!')->to('es') !!}
    <br>
    {!! Laralang::trans('Hello world!')->to('ca') !!}
    <br>
    {!! Laralang::trans('Hello world!')->to('ca')->debug(true) !!}
    <br>
    {!! Laralang::trans('Hallo welt!')->from('de')->to('fr') !!}
    <br>
    {!! Laralang::trans('Hello world!')->to('pt') !!}
    <br>
    {!! Laralang::trans('Hello world!')->to('de') !!}
    <br>
    {!! Laralang::trans('Hello world!')->to('ml') !!}
    <br>
    {!! Laralang::trans('Hello world!')->to('zh')->translator('apertium') !!}

    <br>
    From langs:
    @foreach(Laralang::fromLanguages() as $lang)
        {{$lang}}
    @endforeach

    <br>
    To langs:
    @foreach(Laralang::toLanguages() as $lang)
        {{$lang}}
    @endforeach
</center>
```

**NOTE: Use {{ }} statements if translations comes from users to prevent XSS atacks**

Then the result:

![Result of example](http://i.imgur.com/hWsRJLa.png)

## Admin panel

### Firsts steps

**First you should be logged into loaralang**

*Route prefix can be changed on your config file, but by default it's laralang*

- How to acces to panel?

You should visit next url:

http://domain/laralang/login

or in localhost you should visit

http://localhost/project-path/public/laralang/login

Then you should see the laralang login page (photo below)

![Laralang login page](http://i.imgur.com/bjQJiHQ.png)

Now you must enter the password you set on [Step 5](#step-5.-configure-defalt-values) and then click login to manage your translations as can be seen on photos below!

![View of translations](http://i.imgur.com/NIF8yqL.png)

![Editing translation #3](http://i.imgur.com/smK8xct.png)


### Filtering translations

Laralang also lets you filter translations by *from_lang* and / or *to_lang*. Below you have an example:

First we must access to filter view in route http://domain/laralang/translations/filter or well accessing across menu.

![Menu](http://i.imgur.com/o1B4m1H.png)

Then you can select from which language provides the originals strings and then from which language are translated this string with two selectors:

![Filtering](http://i.imgur.com/ZRTONNE.png)

Then the result:

![Filtering result](http://i.imgur.com/lrk6mzR.png)


### Translations via api

There exists an api to get translated text. First of all you should enable it on config, then you should configure ajax as explained in [laravel official site](https://laravel.com/docs/5.3/csrf#csrf-x-csrf-token) and then call api (method=POST)

```javascript
$.post('{{route("laralang::apiTranslate")}}', {'string' : 'This is my string to translate', 'to' : 'de'}, function(response) {
    var translatedText = response.translatedText;
}, 'json');
```


## Translating PHP files

Laralang can generate PHP translations files quickly by translating from english to language you want and save a lot of time!

After login to admin panel, you will find something like this:

![Home](https://sc-cdn.scaleengine.net/i/4aeb5987b2f7a1f2ee13250903d3c314.png)

Here you simply click on translate PHP files and then you should see this view:

![Translations](https://sc-cdn.scaleengine.net/i/cd35be41ad5c3ea8cf09e4e0037c483b.png)

Here you can click translate and all files of resources/lang/en will be translated into languages you choose in the form input!

Then on resources/lang/ you will find a folder for each language with it's respective files translated.

## API

### trans() method

This functions is used to get a translation from a string to another language specified on default values, on app_locale or in every function.

To simplify work we've implemented another package [(Localizer)](https://github.com/24aitor/Localizer) to set app_locale via middleware and it allows to get user browser language to set it as app_locale easily.

#### Functions of trans()

**from()**


It sets the language of the string to translate in a specific translation.

*Default: en*

**to()**

It sets the language that you'll output in a specific translation.

*Default: app_locale*

**debug()**

Debug option let you to know the reason of an unexpected result with colorful messages in a specific translation.

*Default: false*

**Save()**

Save option let you to save a specific translation.

*Default: false*
***************

### fromLanguages() method

Returns an array with all languages from provides strings to translate.

### toLanguages() method

Returns an array with all languages that at least one string has been translated.

### getLanguages() method

Returns an array with ['key' => 'value'] where key is a language and value is an acronym from all languages tested in laralang.
