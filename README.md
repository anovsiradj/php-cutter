# Cutter

KISS PHP Template Library.

Tested on PHP `7.4`, `8.0`, `8.1`, `8.2`, `8.3`, `8.4`, `8.5`.

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
$cutter->set('layout', '/layouts/main');

$cutter->data('page_title', 'My Posts'); // set variable

$cutter->view(
	'/pages/home',
	['date_today' => date('Y-m-d')], // set variable(s)
);
```

`/layouts/main.php`

use `section()` / `field()` to output sections

```php
<!DOCTYPE html>
<html>
	<head>
		<title><?= $page_title ?></title>
	</head>

	<body>
		<div>
			<?php $cutter->field('content') ?>
		</div>

		<?php $cutter->field('script') ?>
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
// Config
get( $key ) : mixed;
set( $key, mixed $val ) : void;

// Data
data( mixed $any [, mixed $val] ): mixed;        // get/set/array
dataByRef( array &$data ) : void;                // bind by reference

// View resolution
path( mixed $names ) : string|false;             // find view file (cached)
view( mixed $name [, array $data = [] [, bool $render = true ] ] ) : mixed;
render( [array $data = [] ] ) : mixed;           // render layout (cached)

// Sections
section( $name ) : bool;                         // echo section content
field( $name ) : bool;                           // alias for section()
begin( $name [, $position = 'after'] ) : void;   // start capture
end() : void;                                    // end capture
start( $name [, $position] ) : void;             // alias for begin()
open( $name [, $position] ) : void;              // alias for begin()
stop() : void;                                   // alias for end()
close() : void;                                  // alias for end()

// Introspection (v2026)
getCurrentSection() : ?string;                   // current capturing section
getCurrentPosition() : ?string;                  // current position

// Static factory
static init() : static;                          // singleton instance

// Callable helper
__invoke( $section, $callback, $position = null ) : void;

// Internal
load( $file [, bool $isob = false ] ) : mixed;
```

**Position Values**
- `after` / `next` / `1` / `n` / `a` — append (default)
- `before` / `prev` / `previous` / `0` / `p` / `b` — prepend

## Performance (v2026)

- **Path resolution cached** — repeated `path()` calls use in-memory cache
- **Layout path cached** — `render()` resolves layout once
- **Auto-invalidation** — cache cleared on relevant config changes
- **Optimized loop order** — `names × paths × suffixes`

## Development

TODO:
- single file library / phar?
- inheritance

All suggestions are welcome. Thanks.

## Reference

- https://laravel.com/docs/5.8/blade
- https://twig.symfony.com/doc/2.x/
