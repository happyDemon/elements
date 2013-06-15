# Examples

I'm going to be using the same config file and routes for both examples provided by this guide.

## Config file
This will be stored in *APPATH/config/navigation/example.php*

		<?php defined('SYSPATH' OR die('No direct access allowed.'));
			/**
			 * Example element config file
			*/
			return [
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
						'route'     => 'tracker',
						'title'   => 'nav.tracker',
						'icon'    => 'icon-th',
						'tooltip' => 'nav.tracker',
						'items'   => [
							[
								'route'     => 'tracker.issues.recent',
								'title'   => 'nav.tracker.recent',
								'tooltip' => 'nav.tracker.tooltip.recent'
							],
							[
								'route'     => 'tracker.issues.all',
								'title'   => 'nav.tracker.all',
								'tooltip' => 'nav.tracker.tooltip.all'
							]
						]
					],
				],
			];

## Routes
Place this in your *APPATH/bootstrap.php*

	<?php
		Route::set('user.login', 'login')
			->defaults(array(
				'controller' => 'User',
				'action'     => 'login',
			)
		);
		Route::set('user.register', 'register')
			->defaults(array(
				'controller' => 'User',
				'action'     => 'register',
			)
		);
		Route::set('tracker', 'tracker')
			->defaults(array(
				'controller' => 'Tracker',
				'action'     => 'index',
			)
		);
		Route::set('tracker.issues.recent', 'tracker/issues/recent')
			->defaults(array(
				'controller' => 'Tracker',
				'action'     => 'issues_recent',
			)
		);
		Route::set('tracker.issues.all', 'tracker/issues')
			->defaults(array(
				'controller' => 'Tracker',
				'action'     => 'issues',
			)
		);

**Now you can continue to the examples**