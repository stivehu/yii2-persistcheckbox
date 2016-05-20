Persist checkbox
================
Selected checkbox is remain after paging

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist stivehu/yii2-persistcheckbox "*"
```

or add

```
"stivehu/yii2-persistcheckbox": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
                                            [
                                                'class' => stivehu\grid\PersistCheckBoxColumn::className(),
                                                 'cookieName'=>'selected'

                                            ],
```
=======

