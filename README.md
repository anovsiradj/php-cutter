# Cutter

## Introduction

(another) PHP Template Library. Inspired by Blade (Laravel).

## Installation
[Download this source](/anovsiradj/php-cutter/releases). Also available via [Composer](https://packagist.org/packages/anovsiradj/cutter):
```cmd
composer require anovsiradj/cutter
```

## Basic Usage

`index.php`

```php
require 'vendor/autoload.php';

// instance (singleton)
$blade = anovsiradj\Cutter::init();

$blade->set_path('tpl');		// path/to/my-project/tpl/ (relative or absolute)
$blade->set_layout('layout');	// path/to/my-project/tpl/layout.cutter.php

$blade->data('page_title', 'Web Posts'); // set variable

$blade->view(
	'post/list',							// path/to/my-project/tpl/post/list.cutter.php
	array('date_today' => date('d F Y')),	// set variable
	false									// dont render.
);

$blade->render(); // render template
```

`tpl/layout.cutter.php`

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

`tpl/post/list.cutter.php`

Use `cutter_start()` to start buffer section, and use `cutter_end()` to end.

```php
<?php cutter_start('content_section') ?>
<ul>
	<li>Post title 1</li>
	<li>Post title 2</li>
	<li>Post title 3</li>
</ul>
<?php cutter_end() ?>

<?php cutter_start('js_section') ?>
<script>console.log('<?php echo $date_today ?>')</script>
<?php cutter_end() ?>
```

For better example, see directory `/example/`.

## License
MIT License. (`/LICENSE`)

### All suggestions are welcome

---

Thanks.
