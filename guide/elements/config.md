# Config

All Element config files are stored in config/navigation, so there's no confusion with any other config files you might have present.

## View

If you don't want to use the default view that's bundled with this module you'd have to add a key to your config file with the name of the view you'd want to use.

**Note** These views are stored in views/elements/```$type``` (menu|breadcrumb)

As an example I've bundled a bootstrap version of the views next to the default ones.

## Items

Here's where you build your navigation list, there are several options you can define for your links.

*Required*

 - title: the textual name of your link (I18n is applied)
- url|route: Either the url to this link or the name of the route (I advise on using route names)

*Optional*

 - icon: a css class that will be added to act as an icon (bootstrap style, an I element will get this css class)
 - tooltip: To give the user a bit more info about the link (I18n is applied)
 - visible: a boolean that verifies if the link should be visible (use a lambda or simple if statement)
 - classes: an array containing css class names you'd like the item to have
 - items: create a subtree with more items defined like mentioned above.

#Example

		<?php defined('SYSPATH' OR die('No direct access allowed.'));
			/**
			 * Example config for Twitter Bootstrap main navbar menu
			*/
			return [
				'view' => 'bootstrap/navbar',
				'items'             => [
					[
						'url'     => 'http://github.com',
						'title'   => 'nav.github',
						'icon'    => 'icon-github',
						'tooltip' => 'nav.tooltip.github'
					],
					[
						'route'     => 'user.login',
						'title'   => 'nav.login',
						'icon'    => 'icon-user',
						'tooltip' => 'nav.tooltip.login',
						'visible' => !Auth::logged_in() // Only show the link when the user isn't logged in
					],
					[
						'route'     => 'user.register',
						'icon'    => 'icon-pencil',
						'title'   => 'nav.register',
						'tooltip' => 'nav.tooltip.register',
						'visible' => !Auth::logged_in() // Only show the link when the user isn't logged in
					],
					[
						'route'     => 'tracker.issues',
						'title'   => 'nav.issues',
						'icon'    => 'icon-th',
						'tooltip' => 'nav.reports.issues',
						'items'   => [
							[
								'route'     => 'tracker.issues.recent',
								'title'   => 'nav.issues.recent',
								'tooltip' => 'nav.issues.tooltip.recent'
							],
							[
								'route'     => 'tracker.issues.all',
								'title'   => 'nav.issues.all',
								'tooltip' => 'nav.issues.tooltip.all'
							]
						]
					],
				],
			];
