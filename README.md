# Magento 2 Rebuild URL Rewrites


The module adds a CLI which allows to rebuild the following URL Rewrites: `categories`, `products` and `cms-pages`.  
 
## Installation  
  
Install the module with composer:  
  
```sh  
composer require staempfli/magento2-module-rebuild-url-rewrite  
```  

## Usage

Rebuild everything.

```php  
bin/magento urlrewrite:rebuild categories,products,cms-pages  
```

Rebuild only categories

```php  
bin/magento urlrewrite:rebuild categories  
```

Rebuild only products

```php  
bin/magento urlrewrite:rebuild products  
```  

Rebuild only cms-pages

```php  
bin/magento urlrewrite:rebuild cms-pages  
``` 

Rebuild only specific categories

```php  
bin/magento urlrewrite:rebuild categories -c=25,26,27  
```

 or products

```php  
bin/magento urlrewrite:rebuild products -p=1,2,3  
```  

Rebuild only specific stores

```php  
bin/magento urlrewrite:rebuild categories -s=1,2  
```

Any combination is possible.

See `--help` for more information

```php  
bin/magento urlrewrite:rebuild --help  
```
  
## Requirements  
  
- PHP: 7.0.x | 7.1.x  
- Magento 2.1.x | 2.2.x  
  
Support  
-------  
If you have any issues with this extension, open an issue on [GitHub](https://github.com/staempfli/magento2-module-rebuild-url-rewrite/issues).  
  
Contribution  
------------  
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).  
  
Developer  
---------  
[Marcel Hauri](https://github.com/mhauri), and all other [contributors](https://github.com/staempfli/magento2-module-rebuild-url-rewrite/contributors)  
  
License  
-------  
[Open Software License ("OSL") v. 3.0](https://opensource.org/licenses/OSL-3.0)  
  
Copyright  
---------  
(c) 2018, Stämpfli AG