# Cutter

Simple Fast Lightweight.

## Introduction

(another) PHP Template Library. Inspired by Blade (Laravel).

## Requirement

**PHP 5.6**

## Installation

[Download this source](/anovsiradj/php-cutter/releases) or via [Composer](https://packagist.org/packages/anovsiradj/cutter):

```cmd
composer require anovsiradj/cutter
```

## Example

`/index.php`

```php
require 'vendor/autoload.php';

$blade = anovsiradj\Cutter::init(); // (singleton)
$blade->facade(); // enable facade
$blade->set('layout','tpl/layout');

$blade->data('page_title', 'My Posts'); // set variable

$blade->view(
	'tpl/post/list',
	['date_today' => date('Y-m-d')], // set variable(s)
);
```

`/tpl/layout.cutter.php`

Use `cutter_field()` to define section.

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

Use `cutter_start()` to start buffer, and use `cutter_end()` to end buffer.

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

## Documentation

**Class Methods**

```php
public init( void );

public get( string $key ); // getter alias
public set( array $data | string $key [, mixed $value] ); // setter alias

public view( string $field [, array $data[, boolean $render ] ]);
public render( array $data | string $key [, mixed $value ]);
```

**Class Properties**

*(getter/setter)*

```php
$this->layout;
$this->path;
```

**Facade (Function)**

```php
cutter_field( string $field_name );

cutter_start( string $field_name );
cutter_end( void );
```

## License
MIT License. (see `/LICENSE`).

---

TODO:
- ?

All suggestions are welcome. Thanks.
