# How to include Laralang on your app?


**Step 1.** Require it with composer:
	
```
composer require aitor24/laralang
```

**Step 2.** Register service providers adding the next line to config/app.php inside `'providers' => [` :

```
Aitor24\Laralang\LaralangServiceProvider::class,
```

**Examples of use:**

```php
@lang('laralang::base.welcome')

{{trans('laralang::base.welcome')}}

{{trans('laralang::base.welcome_to', ['app_name' => 'Your app name'])}}

{{trans_choice('laralang::base.users_mp', 1)}}

{{trans_choice('laralang::base.users_mp', 5)}}
```
