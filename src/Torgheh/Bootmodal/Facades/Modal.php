<?php namespace Torgheh\Bootmodal\Facades;

use Illuminate\Support\Facades\Facade;

class Modal extends Facade {
	
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'torgheh.bootmodal';
	}

}
