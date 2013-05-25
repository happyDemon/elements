<?php defined('SYSPATH' OR die('No direct access allowed.'));
/**
 * Example config for Twitter Bootstrap main navbar menu
 *
 * @see https://github.com/anroots/kohana-menu/wiki/Configuration-files
 * @author Ando Roots <ando@sqroot.eu>
 */
return [
	'view' => 'bootstrap/navbar',
	'items'             => [
		[
			'url'     => 'issues',
			'title'   => 'nav.issues',
			'icon'    => 'icon-tasks',
			'tooltip' => 'nav.tooltip.issues'
		],
		[
			'url'     => 'users',
			'title'   => 'nav.persons',
			'icon'    => 'icon-user',
			'tooltip' => 'nav.tooltip.persons'
		],
		[
			'url'     => 'projects',
			'icon'    => 'icon-folder-close',
			'title'   => 'nav.projects',
			'tooltip' => 'nav.tooltip.projects',
			'visible' => date('d') == 1 // Only show the link on the first day of each month
		],
		[
			'url'     => 'reports',
			'title'   => 'nav.reports',
			'icon'    => 'icon-list-ol',
			'tooltip' => 'nav.reports.tooltip',
			'items'   => [
				[
					'url'     => 'logs',
					'icon'    => 'icon-align-justify',
					'title'   => 'nav.reports.logs',
					'tooltip' => 'nav.reports.tooltip.logs'
				],
				[
					'route'     => 'element',
					'icon'    => 'icon-th',
					'title'   => 'nav.element',
					'tooltip' => 'nav.element.tooltip'
				]
			]
		],
	],
];