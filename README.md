# How to include on your app?


1. Require it with composer:
	
```
composer require aitor24/laralang
```

2. Register service providers adding the next line to config/app.php inside `'providers' => [` :

```
Aitor24\Laralang\LaralangServiceProvider::class,

```