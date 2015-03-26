<?php
use Illuminate\Support\Facades\Facade;

class HelperModuleClass extends Facade{
	protected static function getFacadeAccessor(){	return 'Helper'; }
}