<?php
use Illuminate\Support\ServiceProvider;

class HelperModuleServiceProvider extends ServiceProvider{
	public function register(){
		 $this->app->bind('Helper', function(){
			return new MistirioModules\Helper;
		});
	}
}