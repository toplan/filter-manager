# FilterManage for Laravel
Filter manager package for product list,elegant generate url.
(产品列表筛选管理器，让你优雅的获得筛选器链)

# Installation

```php
{
  "require": {
		"laravel/framework": "4.2.*",
    "toplan/filter-manager": "dev-master"
	}
}
```

# Usage

To use the FilterManager Service Provider, you must register the provider when bootstrapping your Laravel application. There are essentially two ways to do this.

Find the providers key in app/config/app.php and register the HTMLPurifier Service Provider.
```php
    'providers' => array(
        // ... 
        'Toplan\FilterManager\FilterManagerServiceProvider',
    )
```    
Find the aliases key in app/config/app.php.
```php
    'aliases' => array(
        // ...
        'FilterManager' => 'Toplan\FilterManager\Facades\FilterManager',
    )
``

# Examper
 You can find Most of the usage in the demo_temp_for_laravel.balde.php
