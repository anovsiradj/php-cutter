# Cutter

Simple Fast Lightweight PHP Templating.

(another) PHP template library. Inspired by Blade (Laravel) and Twig (Symfony).

## Requirements

Tested on both `5.6+` and `7.0+`.

Should work on any `5+`.

## Installation

[Download this source](/anovsiradj/php-cutter/releases) or via [Composer](https://packagist.org/packages/anovsiradj/cutter):

```cmd
composer require anovsiradj/cutter
```

## Example

`/index.php`

```php
require 'vendor/autoload.php';

$blade =& anovsiradj\Cutter::init(); // (singleton)
$blade->facade(); // enable facade
$blade->set('layout','tpl/layout');

$blade->data('page_title', 'My Posts'); // set variable

$blade->view(
	'tpl/post/list',
	['date_today' => date('Y-m-d')], // set variable(s)
);
```

`/tpl/layout.cutter.php`

use `cutter_field()` to define section.

```php
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $page_title ?></title>
	</head>
	<body>
		<div>
			<?php cutter_field('content_section') ?>
		<div>
		<?php cutter_field('js_section') ?>
	</body>
</html>

```

`/tpl/post/list.cutter.php`

use `cutter_start()` to start buffer, and use `cutter_end()` to end buffer.

```php
<?php cutter_start('content_section') ?>
<ul>
	<li>Post title 1</li>
	<li>Post title 2</li>
	<li>Post title 3</li>
</ul>
<?php cutter_end() ?>

<?php cutter_start('js_section') ?>
<script>alert('date today is <?php echo $date_today ?>')</script>
<?php cutter_end() ?>
```

For more, see `/example/`.

## Reference

**Class Methods**

```php
public static init( void ) : $this;

public get( string $key ) : void;
public set( string|array $key [, string $value] ) : void;

public view( string $view [, array $data = [] [, boolean $render = true ] ] ) : void;

public render( [array $data = [] ] ) : void;

public static facade( void ) : void;
```

**Facade (Function)**

```php
cutter_field( string $field ) : boolean;

cutter_start( string $field [, string $stack = 'after|next/pevious|before'] ) : void;
cutter_end( void ) : void;
```

## Development

TODO:
- ?

All suggestions are welcome. Thanks.


## License
MIT. (see [/LICENSE](LICENSE)).
