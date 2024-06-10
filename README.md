# Cutter

Flexible Template Library. Inspired by Blade (Laravel) and Twig (Symfony).

Tested on PHP `5.6`, `~7` and `~8`.

## Installation

[Download this source](/anovsiradj/php-cutter/releases) or via [Composer](https://packagist.org/packages/anovsiradj/cutter):

```cmd
composer require anovsiradj/cutter
```

## Example

`/index.php`

```php
require 'Cutter.php'; // directly or composer

$cutter = new anovsiradj\Cutter;
$cutter->set('layout','/layouts/main');

$cutter->data('page_title', 'My Posts'); // set variable

$cutter->view(
	'/pages/home',
	['date_today' => date('Y-m-d')], // set variable(s)
);
```

`/layouts/main.php`

use `section()` to define section

```php
<!DOCTYPE html>
<html>
	<head>
		<title><?= $page_title ?></title>
	</head>

	<body>
		<div>
			<?php $cutter->section('content') ?>
		<div>

		<?php $cutter->section('script') ?>
	</body>
</html>
```

`/pages/home.php`

use `begin()` and `end()` to output-buffer section

```php
<?php $this->begin('content') ?>
<ul>
	<li>Post title 1</li>
	<li>Post title 2</li>
	<li>Post title 3</li>
</ul>
<?php $this->end() ?>

<?php $this->begin('script') ?>
<script>alert('date today is <?php echo $date_today ?>')</script>
<?php $this->end() ?>
```

for more, see `/example/`.

## Reference

**Class Methods**

```php
get( $key ) : void;
set( $key, mixed $val ) : void;

data( mixed $any [, mixed $val] ): mixed;

load( $file [, bool $isob = false] ): void;

view( mixed $name [, array $data = [] [, bool $render = true ] ] ) : void;

render( [array $data = [] ] ) : void;

section( $name ) : bool;

begin( $name ) : void;
end(): void
```

## Development

TODO:
- single file library / phar?
- inheritance
- ~~dynamic path~~
- ~~dynamic view~~

All suggestions are welcome. Thanks.

## Reference

- https://laravel.com/docs/5.8/blade
- https://twig.symfony.com/doc/2.x/
