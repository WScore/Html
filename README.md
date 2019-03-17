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

### Basic HTML

use `WScore\Html\Html` class to create an HTML object, as;

```php
use WScore\Html\Html;

$html = Html::create('tagName')
            ->set('attribute', 'value')
            ->setContents('content');
echo (string) $html;
```

should output HTML like, 

```html
<tagName attribute="value">content</tagName>
```

You can `set`, `add`, `remove`, `reset`, attributes. 

There are some magic methods as well. 

```php
$html = Html::a('sample link')       // magic method to create a new tag and contents
            ->href('check.php')    // magic method to set href attribute
            ->target('_blank');
```


### HTML Form

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

To create a nested html code, 

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
<ul class="form-list">
<input type="text" name="name" id="name" placeholder="name here...">
<input type="radio" name="yes" id="yes" value="here">
</ul>
```

### Choices (radio, checkbox, and select)

User `Form::choices` method to generate choices, such as radio buttons, checkboxes, and drop down selects.

For radio buttons; 

```php
echo Form::choices('test', [
    'val1' => 'label1', 
    'val2' => 'label2'], 
    'val2);
```

for checkboxes; 

```php
echo Form::choices('test', [
    'val1' => 'label1', 
    'val2' => 'label2'], 
    'val2)
    ->multiple();
```

and for drop-down selects; 

```php
echo Form::choices('test', [
    'val1' => 'label1', 
    'val2' => 'label2'], 
    'val2)
    ->expand(false);
```

Demo
----

To see `WScore.Html` working in the demo, 

```
$ git clone https://github.com/asaokamei/WScore.Html
$ cd WScore.Html
$ composer install
$ cd demo
$ php -S 127.0.0.1:8000
```

and browse the last URL. 