<?php defined('SYSPATH' OR die('No direct access allowed.'));
/**
 * Minimalistic menu config example.
 * Renders a simple list (<li>) of links.
 *
 * @see https://github.com/anroots/kohana-menu/wiki/Configuration-files
 * @author Ando Roots <ando@sqroot.eu>
 */
return [
	'items'             => [
		[
			'url'     => 'http://happydemon.org',
			'title'   => 'HappyDemon',
			'icon'    => 'icon-home',
		],
		[
			'url'     => 'https://github.com/happyDemon/elements',
			'title'   => 'Github',
			'icon'    => 'icon-info-sign',
			'tooltip' => 'Project source'
		],
		[
			'route'     => 'element',
			'icon'    => 'icon-th',
			'title'   => 'Demo page',
		],
	],
];