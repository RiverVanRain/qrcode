<?php
/**
 * QR Code Generator
 * @author Nikolai Shcherbin
 * @package Plugin
 * @license GNU Affero General Public License version 3
 * @copyright (c) Nikolai Shcherbin 2023
 * @link https://wzm.me
**/
return [
	'plugin' => [
		'name' => 'QR Code Generator',
		'version' => '1.0.0',
		'activate_on_install' => true,
	],
	
	'actions' => [
		'qrcode/generate' => [
			'controller' => \wZm\QRcode\Actions\GenerateAction::class,
		],
	],
	
	'events' => [
		'register' => [
			'menu:entity' => [
				\wZm\QRcode\Menus\EntityMenu::class => [],
			],
		],
	],
	
	'view_extensions' => [
		'elgg.css' => [	
			'qrcode/style.css' => [],
		],
	],
	
	'view_options' => [
		'qrcode/generate' => ['ajax' => true],
	],
	
	'views' => [
		'default' => [
			'qrcodes/' => elgg_get_data_path() . '1/1/qrcodes/',
		],
		'json' => [
			'qrcodes/' => elgg_get_data_path() . '1/1/qrcodes/',
		],
	],
];