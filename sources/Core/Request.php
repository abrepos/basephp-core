<?php
/**
 * @project BasePHP Core
 * @file Request.php created by Ariel Bogdziewicz on 29/07/2018
 * @author Ariel Bogdziewicz
 * @copyright Copyright © 2018 Ariel Bogdziewicz. All rights reserved.
 * @license MIT
 */
namespace Base\Core;

class Request
{
    protected $ports = null;
    
    public function __construct(Ports $ports = null)
    {
        $this->ports = $ports ?? new Ports();
    }
    
    public function method()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }
    
    public function isHttps()
    {
        if (!empty($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https')
        {
            return true;
        }
        
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
        {
            return true;
        }
        
        if (!empty($_SERVER['SERVER_PORT']) && in_array((int)$_SERVER['SERVER_PORT'], $this->ports->httpsPorts()))
        {
            return true;
        }
        
        return false;
    }
    
    function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    
    public function protocol()
    {
        return $this->isHttps() ? "https://" : "http://";
    }
    
    public function host()
    {
        return strtolower($_SERVER['SERVER_NAME']);
    }
    
    public function port()
    {
        if (isset($_SERVER['SERVER_PORT']))
        {
            $port = (int)$_SERVER['SERVER_PORT'];
        }
        else
        {
            $port = $this->isHttps() ? $this->ports->defaultHttpsPort() : $this->ports->defaultHttpPort();
        }
        return $port;
    }
    
    public function uri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function path()
    {
        $requestUri = explode("?", $this->uri());
        return is_array($requestUri) && count($requestUri) > 0 ? $requestUri[0] : "/";
    }
    
    public function get($name)
    {
        return $this->getVariable($_GET, $name);
    }

    public function post($name)
    {
        return $this->getVariable($_POST, $name);
    }
    
    private function getVariable($array, $name)
    {
        if (isset($array[$name]))
        {
            if (is_array($array[$name]))
            {
                $tmp = array();
                foreach($array[$name] as $key => $val)
                {
                    if (((double)$val) === $val)
                    {
                        $tmp[$key] = (double)$val;
                    }
                    else
                    {
                        $tmp[$key] = $this->escape(trim($val));
                    }
                }
                return $tmp;
            }
            if (((double)$array[$name]) === $array[$name])
            {
                return (double)$array[$name];
            }
            return $this->escape(trim($array[$name]));
        }
        return null;
    }
    
    public function escape($string)
    {
        return get_magic_quotes_gpc() ? stripslashes($string) : $string;
    }
    
    public function cookie($name)
    {
        if (isset($_COOKIE[$name]))
        {
            return $_COOKIE[$name];
        }
        return null;
    }
}
