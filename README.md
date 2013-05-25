# HTML Navigation Module for Kohana 3.3

Simplify rendering, building and maintenance of simple, dynamic standardised navigation menus and breadcrumbs. Instead of...

```php
<? if ($user->get_role() === Role::ANONYMOUS):?>
<ul>
	<li><a href="/" <?= $page === 'home' ? 'class="active"' : NULL?>>Home</a></li>
	<li><a href="/about" <?= $page === 'about' ? 'class="active"' : NULL?>>About</a></li>
</ul>
<? // elseif (...)?>
```
... we do this:
```php
<?
return [
'items' => [
            'url'     => 'home',
            'title'   => 'Home',
        ],
        [
            'route'     => 'about',
            'title'   => 'About',
        ],
];
```

## Basics

You define your menus in Kohana configuration files
(see [config/menu/navbar.php](https://github.com/happyDemon/elements/blob/master/config/navigation/navbar.php)).
Then, in your (main) controller (or template), you construct a new Element object, set the active link and render it in your template. Done.

### Example use case

A WordPress type blog might have...

* Public main navigation menu
* Public footer menu
* Admin-only menu on the public pages, when admin is logged in
* Admin-only menu on the administrator interface

Normally, you'd build HTML views with `ul` and `li` elements and then write some PHP to highlight the active link. This is
difficult to maintain (DRY) and too much hassle (not to mention ugly).

Instead, describe your (standardised) menus in configuration files and have Kohana do the heavy lifting.

## Installation

### Place the files in your modules directory.

#### As a Git submodule:

```bash
git clone git://github.com/happyDemon/elements.git modules/elements
```
#### As a [Composer dependency](http://getcomposer.org)

```javascript
{
	"require": {
		"php": ">=5.4.0",
		"composer/installers": "*",
		"happyDemon/elements":"*"
	}
}
```

### Copy `MODPATH.elements/config/navigation/navbar.php` into `APPPATH/config/navigation/navbar.php` and customize

### Activate the module in `bootstrap.php`.

```php
<?php
Kohana::modules(array(
	...
	'elements' => MODPATH.'elements',
));
```

### Echo menu output in your template

```html
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<?=Element::factory('navbar')->render('Menu')?>
		</div>
	</div>
</div>
```

and output the breadcrumb wherever you want (we'll use the bootstrap styling)
```html
<?=Element::factory('navbar')->render('Breadcrumb', 'bootstrap')?>
```

You might wish to instantiate the menu in your main controller, since this gives you a way to interact with the Element object
before it's rendered.

## Config files

You can use different config files by setting the factory's `$config` parameter.

### Example: Load menu configuration based on user role

```php
	$element = Element::factory($role); // this could use `config/navigation/(user|admin).php`
```

## Marking the current menu item

Use `set_current()` to mark the current menu item in your controller if you're not making use of routes
```php
	$element->set_current('article/show');
```
The parameter of `set_current()` is the URL value of the respective item or its (numeric) array key.

# Documentation

The code is mostly commented.

# Licence

The Kohana module started out as a fork of [Anroot](https://github.com/anroots/kohana-menu)'s Kohana-menu, which in turn is a fork of the original Kohana Menu module by
[Bastian Bräu](http://github.com/b263/kohana-menu), but is now independently developed under the MIT licence.