WScore.Html
===========

Html tag generation class for PHP.

Installation
------------

```
$ composer require wscore/html
```

Sample Codes
------------

###Basic HTML

use `WScore\Html\Html` class to create an HTML object, as;

```php
use WScore\Html\Html;

$html = Html::create('tagName')
            ->set('attribute', 'value')
            ->setContents('readme');
echo (string) $html;
```

should output HTML like, 

```html
<tagName attribute="value">readme</tagName>
```

You can `set`, `add`, `remove`, `reset`, attributes. 

Also magic method 

```php
$html = Html::create('a')
            ->href('attribute', 'value') // magic method to set href attribute
            ->target('_blank');
```


### Form HTML

use `WScore\Html\Form` class to create a HTML form object, as;


```php
echo Form::open('check.php');
echo Form::input('checkbox', 'keep', 'alive')->class('form-element');
echo Form::close(); 
```

should create something like: 

```html
<form action="check.php" method="post">
<input type="checkbox" name="keep" id="keep" value="alive" class="form-element">
</form>
```

### Some Complex Case



```php
echo Html::create('ul')
            ->class('form-list')
            ->setContents(
                Form::input('text', 'name')->placeholder('name here...'),
                Form::input('radio', 'yes', 'here')
            );
```

should result in following html code. 

```html
<ul class="form-list">\n
<input type="text" name="name" id="name" placeholder="name here...">\n
<input type="radio" name="yes" id="yes" value="here">\n
</ul>
```