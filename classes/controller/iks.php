<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Iks extends Controller {

	public function action_boot()
	{
		// not allow remote
		if(!isset($_SERVER['SHELL']))
		{
			throw new HTTP_Exception_403;
		}

		// boot console
		return Iks::boot($this);
	}
}
