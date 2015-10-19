<?php

namespace SF;


class InputData
{
    private static $instance = null;
    private $_get = array();
    private $_post = array();
    private $_cookies = array();

    private function __construct()
    {
        $this->_cookies = $_COOKIE;
    }

    /**
     * @return InputData
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new InputData();
        }
        return self::$instance;
    }

                  //get(0, 'trim|string|xss', 'new')
    public function get($id, $normalize = null, $default = null)
    {
        if ($this->hasGet($id)) {
            if ($normalize != null) {
                return DataNormalizer::normalize($this->_get[$id], $normalize);
            }
            return $this->_get[$id];
        }
        return $default;
    }

    public function post($name, $normalize = null, $default = null)
    {
        if ($this->hasPost($name)) {
            if ($normalize != null) {
                return DataNormalizer::normalize($this->_post[$name], $normalize);
            }
            return $this->_post[$name];
        }
        return $default;
    }

    public function cookies($name, $normalize = null, $default = null)
    {
        if ($this->hasCookies($name)) {
            if ($normalize != null) {
                return DataNormalizer::normalize($this->_cookies[$name], $normalize);
            }
            return $this->_cookies[$name];
        }
        return $default;
    }

    public function hasGet($id)
    {
        return array_key_exists($id, $this->_get);
    }

    public function hasPost($name)
    {
        return array_key_exists($name, $this->_post);
    }

    public function hasCookies($name)
    {
        return array_key_exists($name, $this->_cookies);
    }

    public function setGet($get)
    {
        if (is_array($get)) {
            $this->_get = $get;
        }
    }

    public function setPost($post)
    {
        if (is_array($post)) {
            $this->_post = $post;
        }
    }
}