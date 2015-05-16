<?php

class App 
{
	protected $app = "main";
	
	protected $controller = 'main';
	
	protected $method = 'index';
	
	protected $params = []; 
	
	public function __Construct()
	{
		$url = $this->parseUrl();
		
		if(is_dir('app/controllers/' . $url[0] . '/') && strlen($url[0]) >= 1)
		{
			$this->app = $url[0];
			unset($url[0]);
			$url = array_values($url);
		}else{
			//echo "No controller found going default";
		}
				
		if(file_exists('app/controllers/'. $this->app . "/" . $url[0] . '.php'))
		{
			$this->controller = $url[0];
			unset($url[0]);
			$url = array_values($url);
		}else{
			//echo "No controller found going default";
		}
		
		require_once 'app/controllers/' . $this->app . "/" . $this->controller . '.php';

		/** **************** ***************** **/
		
		$this->controller = new $this->controller;		

		if(isset($url[0]))
		{
			if(method_exists($this->controller, $url[0]))
			{
				$this->method = $url[0];
				unset($url[0]);
			}else{
				//echo "No method found going default";
			}
		}
		
		$this->params = $url ? array_values($url) : [];
		
		call_user_func_array([$this->controller, $this->method], $this->params);
		
	}
	
	protected function parseUrl()
	{
		if(isset($_GET['url'])) {
			
			return $url = explode('/',filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));			
		}
	}

	
}