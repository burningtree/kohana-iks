<?php defined('SYSPATH') or die('No direct script access.');

// Route to console
Route::set('kohana/iks', 'kohana/iks(/<args>)', array(
		'args' => '.+',
	))
	->defaults(array(
		'controller' => 'iks',
		'action'     => 'boot',
	));
