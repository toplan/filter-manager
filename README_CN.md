# 筛选条件(参数)管理器
筛选参数管理器包主要用于页面资料列表，可以让我们优雅灵活的生成筛选链接。
这个页面就使用了该包：[kiteme.cn/list](http://kiteme.cn/list)

![demo image](fm-demo.png)

![demo image](fm-demo2.png)

# 安装

```php
{
  "require": {
    // ...
    "toplan/filter-manager": "dev-master",
   }
}
```

# 打开姿势

请先通过第一步(准备工作)完成服务提供器的注册。

### 1. 准备工作

**在laravel使用**
通过laravel的IOC容器和Provider提供器自动提供FilterManager实例：

*请在 config/app.php 文件中找到名为 providers 的key ，然后为FilterManager的服务提供器。*
```php
    'providers' => array(
        //5.0.*
        'Toplan\FilterManager\FilterManagerServiceProvider',
        //5.1.*
        Toplan\FilterManager\FilterManagerServiceProvider::class,
    )
```    
*然后请在 config/app.php 文件中找到名为 aliases 的key ， 然后为FilterManger添加别名。*
```php
    'aliases' => array(
        //5.0.*
        'FilterManager' => 'Toplan\FilterManager\Facades\FilterManager',
        //5.1.*
        'FilterManager' => Toplan\FilterManager\Facades\FilterManager::class,
    )
```

**自助创建实例(非laravel框架)**
自己手动创建FilterManager实例$fm：
```php
    use Toplan\FilterManager\FilterManager as FilterManager;
    $paramsArray = [
        'paramName' => 'value',
        ...
    ]
    $fm = FilterManager::create($paramsArray)->setBlackList(['page']);
```

### 2. Then, just enjoy it!
**通过Blade模板使用**
```html
<!-- example -->
<li class="item @if(FilterManager::isActive('gender','male')) active @endif">
  <a href="{{FilterManager::url('gender','male')}}"> 男 </a>
</li>
<li class="item @if(FilterManager::isActive('gender','female')) active @endif">
  <a href="{{FilterManager::url('gender','female')}}"> 女 </a>
</li>
```

**通过php标签使用**
```html
<li class="item <?php echo $fm->isActive('gender', 'female', 'active', '') ?>">
  <a href="<?php echo $fm->url('gender','female') ?>">Female</a>
</li>
```

更多的详细用法参见: demo_temp_for_laravel.blade.php

## 常用方法
 基本上所有常用用法都在该文件中: demo_temp_for_laravel.blade.php

### 1. 获得FilterManager对象

```
create($filters,$baseUrl,$blackList);
```

- `$filters`: 参数数组,例:['gender'=>'male','city'=>'beijing']
- `$baseUrl`: 可以根据自己情况进行设置, 如果设置了完整的服务器名和路径，则返回的是url
- `$blackList`: 筛选条件/参数黑名单, 例:['pageindex'].

### 2. 设置筛选条件黑名单
 可以在每次生成uri/url的时候过滤掉你不想要的筛选条件/参数(比如分页参数等)
```php
setBlackList($blackList);
```

示例：
```php
//laravel中
FilterManager::setBlackList(['page','pageindex']);
//手动创建的实例$fm
$fm->setBlackList(['page','pageindex']);
```

### 3. 是否有指定筛选条件
 如果有指定条件，会返回该过滤添加的值，否则返回false
```php
has($filter_name);
```
示例：
```php
//laravel中
FilterManager::has('gender');
//手动创建的实例$fm
$fm->has('gender');
```

### 4. 指定的筛选条件是否包含指点值
```php
isActive($filter_name, $filter_value, $trueReturn, $falseReturn)
```

示例：
```php
//laravel中
FilterManager::isActive('gender','male');#将会返回true 或 false;
FilterManager::isActive('gender','male','active','not active');#将会返回 'active' 或 'not active';
//手动创建的实例$fm
$fm->isActive('gender','male');
```

### 5. 生成 uri/url

```php
url($filter_name,$filter_value,$multi,$LinkageRemoveFilters,$blackList)
```

参数介绍：

- `$filter_name`: 筛选条件/参数
- `$filter_value`: 筛选条件/参数的值, 默认值为：`\Toplan\FilterManager\FilterManager::ALL` , 表示为所有
- `$multi`: 是否支持多个参数值？ true 为支持, 默认为false
- `$LinkageRemoveFilters`: 需要联动删除的筛选条件/参数
- `$blackList`: 临时黑名单，可以临时覆盖默认的黑名单。

示例：
```php
FilterManager::url('gender',\Toplan\FilterManager\FilterManager::ALL);//将会删除gender参数

FilterManager::url('gender','male',false);//gender只能有一个值

FilterManager::url('cities','成都',true);#
FilterManager::url('cities','绵阳',true);#支持cities有多个值

//一个省有多个城市，如果要取消选中‘省’这个条件，那么我们还可以通过第四个参数设置联动取消‘市’以及更多你想取消的筛选条件。
FilterManager::url('province','四川',false,['cities']);//联动删除cities条件
```

