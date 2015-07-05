# FilterManager for Laravel 5
Filter manager package for product list,let`s elegant generate filter url.
This page used FilterManager: [kiteme.cn/list](http://kiteme.cn/list)

[中文文档](https://github.com/toplan/FilterManager/blob/master/README_CN.md)

![demo image](fm-demo.png)

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

To use the FilterManager Service Provider, you must register the provider when bootstrapping your Laravel application. There are essentially two ways to do this.

### 1. The preparatory work

Find the providers key in config/app.php and register the FilterManger Service Provider.
```php
    'providers' => array(
        //5.0.*
        'Toplan\FilterManager\FilterManagerServiceProvider',
        //5.1.*
        Toplan\FilterManager\FilterManagerServiceProvider::class,
    )
```    
Find the aliases key in config/app.php.
```php
    'aliases' => array(
        //5.0.*
        'FilterManager' => 'Toplan\FilterManager\Facades\FilterManager',
        //5.1.*
        'FilterManager' => Toplan\FilterManager\Facades\FilterManager::class,
    )
```

### 2. then, Just enjoy it

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
 You can find most of the usage in the this file: demo_temp_for_laravel.balde.php
 
 * create a instance of FilterManager.
 ### create($filters,$baseUrl,$blackList);
 
 $filters: this is filters data ,required,exp:['gender'=>'male','city'=>'beijing']
 
 $baseUrl: default=array().
 
 $blackList: this is blacklist for filtrs,default=array(),exp:['pageindex'].
 
 * set black list for filter
 ### setBlackList($filter_name_array)
 ```php
    FilterManager::setBlackList(['page','pageindex']);
 ```

 * has filter,return value or false
  ### has($filter_name)
 ```php
    FilterManager::has('gender');
 ```
 
 * is active
 ### isActive($filter_name, $filter_value, $trueReturn, $falseReturn)
 ```php
    FilterManager::isActive('gender','male');#this will return true or false;
    FilterManager::isActive('gender','male','active','not active');#this will return 'active' or 'not active';
 ```
 
 * get url
 
 ### url($filter_name,$filter_value,$multi,$LinkageRemoveFilters,$blackList)

 One filter has some values,and every value has a url,this mothod return a full url string.

 $filter_name: param name, required.
 
 $filter_value: param value, default value:\Toplan\FilterManager\FilterManager::ALL.
 
 $multi: whether to support multiple? false or true, default=false.
 
 $LinkageRemoveFilters：linkage remove the other filter, default=array().
 
 $blackList: temporary blacklist, default=array().
 
 ```php
    FilterManager::url('gender',\Toplan\FilterManager\FilterManager::ALL);//without gender param
    
    FilterManager::url('gender','male',false);#single value

    FilterManager::url('cities','beijing',true);#multiple values
    
    //One province has many cities,If you remove the 'province tag',you should linkage remove the selected cities
    FilterManager::url('province','chengdu',false,['cities']);//linkage remove selected cities
``` 
 
