<?php

class SOAP_Service_Secure
{
    protected $class_name    = '';
    protected $authenticated = false;

    // -----

    public function __construct($class_name)
    {
        $this->class_name = $class_name;

    }

    public function AuthHeader($Header)
    {
    	$query="SELECT cli_usuario,cli_password FROM clientes WHERE cli_usuario = $Header->username AND cli_password = $Header->password";
    	$auth=Db::listar($query);
        if(!empty($auth))
            $this->authenticated = true;

    }

    public function __call($method_name, $arguments)
    {
        if(!method_exists($this->class_name, $method_name))
            throw new Exception('method not found');

        $this->checkAuth();

        return call_user_func_array(array($this->class_name, $method_name), $arguments);

    }

    // -----

    protected function checkAuth()
    {
        if(!$this->authenticated)
            HTML_Output::error(403);

    }

}

?>