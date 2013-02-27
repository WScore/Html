WScore.Html
===========

Html tag generation class for PHP.

Examples
--------

###Constructing

```php
$tags = include( __DIR__ . '/../../../scripts/tags.php' );
```

###Simple cases

simple anchor link.

```php
echo $tags->a( 'a link' )->href( 'do.php' )->target( '_blank' );
// <a href="do.php" target="_blank">a link</a>
```

html tag without body.

```php
echo $tags->img->important->src( 'image.img' );
// <img important="important" src="image.img" />
```

quoting is done automatically.

```php
echo $tags->input->value( 'unsafe" string' );
// <input value="unsafe&quot; string" />;

echo $tags->input()->value( Tags::_wrap( $unsafe ) );
// <input value="unsafe" string" />;
```

###Nested tags

```php
$tags->nl(
    $tags->li( 'list item' ),
    'some text',
    $tags->li( $tags->a( 'link' )->href( 'link.html' ) )
);
// will generate...
```
