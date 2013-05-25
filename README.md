# HTML Navigation Module for Kohana 3.3

Simplify rendering, building and maintenance of simple, dynamic standardised navigation menus and breadcrumbs. Instead of ...

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
As you can see the first item uses an url property, as the original Kohana-menu module required, while the second item uses a route property.

The route property was added to make use of Kohana's own routing system and use reverse routing, making it easier to check if the link is currently active.

**I do recomend defining routes for every controller's action you have in your project.**

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

### Example use case

A WordPress type blog might have...

* Public main navigation menu
* Public footer menu
* Admin-only menu on the public pages, when admin is logged in
* Admin-only menu on the administrator interface

Normally, you'd build HTML views with `ul` and `li` elements and then write some PHP to highlight the active link. This is
difficult to maintain (DRY) and too much hassle (not to mention ugly).

Instead, describe your (standardised) menus in configuration files and have Kohana do the heavy lifting.

The same goes for breadcrumbs, you might need them for:

* Administration panel
* Forum
* Catalogs

and could have the same structure you'd use for your menu's

### What this fork offers over Kohana-menu

Kohana-menu has a specific job and does it well, I personally also needed a way to manage my breadcrumbs for certain areas of the site.

Since my breadcrumbs contain the same data structure as my menu's (and many could share 1 config file), I decided to expand on this module so I could use it for both ends.

## Basics

You define your menus in Kohana configuration files
(see [config/navigation/navbar.php](https://github.com/happyDemon/elements/blob/master/config/navigation/navbar.php)).
Then, in your (main) controller (or template), you construct a new Element object, set the active link and render it in your template. Done.

### Echo menu output in your template (using the included twitter bootstrap template)

```html
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<?=Element::factory('navbar')->render('Menu', 'bootstrap/navbar')?>
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

However, if you've defined a 'route' property in the item it can be auto-detected if you define all your routes using Route::set in your bootstrap.php or init.php's

## Hard-set the active breadcrumb item

On certain pages you'd like to show a dynamic active breadcrumb item (the last one down the tree) to clearify which action if being done.

You can do this by calling `last_item` on your `Element` object and defining what you'd want to be rendered instead of the default text that was defined in your config file:

```php
	$element->last_item('editing user "happyDemon"');
```
# Documentation

The code is mostly commented, a user guide is on it's way with more examples.

# Licence

The Kohana module started out as a fork of [Anroot](https://github.com/anroots/kohana-menu)'s Kohana-menu, which in turn is a fork of the original Kohana Menu module by
[Bastian Bräu](http://github.com/b263/kohana-menu), but is now independently developed under the MIT licence.
