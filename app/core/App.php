<?php

class App
{

    protected $controller = 'countryController';

    protected $method = 'index';

    protected $params = [];

    public function __construct()
    {

        if(isset($_GET['module'])) {
            if(file_exists('../app/controllers/' . $_GET['module'] . '.php'))
            {
                $this->controller = mysql::escape($_GET['module']);
            }
            
        }
        // else {
        //     echo "If you got here from Angola, you took a wrong turn at Catumbela.
        //     And if you got here by typing randomly in the address bar, stop doing that. You're filling my error logs with unnecessary junk.";
        // }

        require_once '../app/controllers/' . $this->controller . '.php';

        $this->controller = new $this->controller;
        
	    if(isset($_GET['action'])) {
            if(method_exists($this->controller, $_GET['action']))
            {
                $this->method = mysql::escape($_GET['action']);
            }  
        }
        
        if(isset($_GET['id'])) {
            $this->params['id'] = mysql::escape($_GET['id']);
        }

        $this->params['pageId'] = 1;
	    if(!empty($_GET['page'])) {
		    $this->params['pageId'] = mysql::escape($_GET['page']);
        }
        
        if(!empty($_GET['country'])) {
		    $this->params['country'] = mysql::escape($_GET['country']);
        }

        if(!empty($_POST['submit'])) {
            $this->params['data'] = $_POST;
        }
        
        $this->params['search'] = '';
        if(!empty($_GET['search'])) {
            $this->params['search'] = mysql::escape($_GET['search']);
        }

        $this->params['sort'] = 'ASC';
        if(!empty($_GET['sort'])) {
            $this->params['sort'] = mysql::escape($_GET['sort']);
        }

        $this->params['from'] = '';
        if(!empty($_GET['from'])) {
            $this->params['from'] = mysql::escape($_GET['from']);
        }

        $this->params['to'] = '';
        if(!empty($_GET['to'])) {
            $this->params['to'] = mysql::escape($_GET['to']);
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }
}
?>