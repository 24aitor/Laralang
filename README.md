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

Include the line below to config/app.php inside array `'aliases' => [` :

```
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

**STRONGLY IMPORTANT:** Change the password of config *(Default password: laralangAdmin )*

Apart from the password, the rest of default values can be modified also on `config/laralang.php`. Furthermore you can modify these in a specific translation with the functions below.

**Available Translators:** Google Translator, MyMemory, Apertium (Strongly not recomended)

*config values for translators*: 'google', 'mymemory', 'apertium'



## Using laralang

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

### Examples of use


Then few examples of tranlsation:


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

### Admin panel

Laralang allows you to control which translations are saved on your DB and then you can manage it *(edit and delete)*.

#### Firsts steps

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

#### Filtering translations

Laralang also lets you filter translations by *from_lang* and / or *to_lang*. Below you have an example:

First we must access to filter view in route http://domain/laralang/translations/filter or well accessing across menu.

![Menu](http://i.imgur.com/o1B4m1H.png)

Then you can select from which language provides the originals strings and then from which language are translated this string with two selectors:

![Filtering](http://i.imgur.com/ZRTONNE.png)

Then the result:

![Filtering result](http://i.imgur.com/lrk6mzR.png)

### Api translations

There exists an api to get translated text. First of all you should enable it on config, then you should configure ajax as explained in [laravel official site](https://laravel.com/docs/5.3/csrf#csrf-x-csrf-token) and then call api (method=POST)

```javascript
$.post('{{route("laralang::apiTranslate")}}', {'string' : 'This is my string to translate', 'to' : 'de'}, function(response) {
    var translatedText = response.translatedText;
}, 'json');
```
