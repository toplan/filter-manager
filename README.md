# FilterManager

filter manager package for product list filter,let`s elegant generate filter url.

This page used FilterManager: [kiteme.cn/list](http://kiteme.cn/list)

**[中文文档](https://github.com/toplan/FilterManager/blob/master/README_CN.md)**

![demo image](fm-demo2.png)

# Installation

```php
{
  "require": {
    // ...
    "toplan/filter-manager": "dev-master",
   }
}
```

# Usage

###1. The preparatory work

```php
require 'path/to/vendor/autoload.php';
use Toplan\FilterManager\FilterManager as FilterManager;

// params
$paramsArray = [
    'paramName' => 'value',
    ...
]
// create instance by yourself.
$fm = FilterManager::create($paramsArray)->setBlackList(['page']);
```

then, render `$fm` value to your template!

**Used in laravel:**

Find the providers key in config/app.php and register the FilterManger Service Provider.
```php
    'providers' => array(
        Toplan\FilterManager\FilterManagerServiceProvider::class,
    )
```    
Find the aliases key in config/app.php.
```php
    'aliases' => array(
        'FilterManager' => Toplan\FilterManager\Facades\FilterManager::class,
    )
```


###2. Just enjoy it

used in template
```html
<!-- example -->
<li class="item all {{FilterManager::isActive('gender',\Toplan\FilterManager\FilterManager::ALL,'active','')}}">
  <a href="{{FilterManager::url('gender',\Toplan\FilterManager\FilterManager::ALL)}}">All</a>
</li>
<li class="item @if(FilterManager::isActive('gender','male')) active @endif">
  <a href="{{FilterManager::url('gender','male')}}">Male</a>
</li>
<li class="item @if(FilterManager::isActive('gender','female')) active @endif">
  <a href="{{FilterManager::url('gender','female')}}">Female</a>
</li>
```

# Commonly used method

### 1. create a instance
 ```php
 create($filters,$baseUrl,$blackList);
 ```
 
 - `$filters`: this is filters data ,required,exp:['gender'=>'male','city'=>'beijing']
 
 - `$baseUrl`: default=array().
 
 - `$blackList`: this is blacklist for filtrs,default=array(),exp:['pageindex'].
 
### 2. set black list for filter
 ```php
 setBlackList($filter_name_array)
 ```
 example:
 ```php
    $fm->setBlackList(['page','pageindex']);
    //or in laravel
    FilterManager::setBlackList(['page','pageindex']);
 ```

### 3. has filter,return value or false
 ```php
 has($filter_name)
 ```
 example:
 ```php
    $fm->has('gender');
    //or in laravel
    FilterManager::has('gender');
 ```
 
### 4. is active
 ```php
 isActive($filter_name, $filter_value, $trueReturn, $falseReturn)
 ```
 example:
 ```php
    //in laravel
    FilterManager::isActive('gender','male');#this will return true or false;
    FilterManager::isActive('gender','male','active','not active');#this will return 'active' or 'not active';
 ```
 
### 5. get url

 ```php
 url($filter_name,$filter_value,$multi,$LinkageRemoveFilters,$blackList)
 ```

 One filter has some values,and every value has a url,this mothod return a full url string.

 - `$filter_name`: param name, required.
 
 - `$filter_value`: param value, default value:\Toplan\FilterManager\FilterManager::ALL.
 
 - `$multi`: whether to support multiple? false or true, default=false.
 
 - `$LinkageRemoveFilters`：linkage remove the other filter, default=array().
 
 - `$blackList`: temporary blacklist, default=array().

 example:
 ```php
    //in laravel
    FilterManager::url('gender',\Toplan\FilterManager\FilterManager::ALL);//without gender param
    
    FilterManager::url('gender','male',false);#single value

    FilterManager::url('cities','beijing',true);#multiple values
    
    //One province has many cities,If you remove the 'province tag',you should linkage remove the selected cities
    FilterManager::url('province','chengdu',false,['cities']);//linkage remove selected cities
``` 
