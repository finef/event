<?php

namespace \Fine\Event;

class Event
{

    protected $_id;
    protected $_subject;
    protected $_val;
    protected $_cancel = false;

    public function __construct(array $config = array())
    {
        foreach ($config as $method => $arg) {
            $this->{$method}($arg);
        }
    }

    public function __call($method, $args)
    {
        if (substr($method, 0, 3) == 'set') {

            $property = lcfirst(substr($method, 3));
            $this->$property = $args[0];
            return $this;

        } elseif (substr($method, 0, 3) == 'get') {

            $property = lcfirst(substr($method, 3));
            return $this->$property;

        } elseif (substr($method, 0, 2) == 'is') {

            $property = lcfirst(substr($method, 2));
            return isset($this->$property);

        }
    }

    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setSubject($subject)
    {
        $this->_subject = $subject;
        return $this;
    }

    public function getSubject()
    {
        return $this->_subject;
    }

    public function setVal($val)
    {
        $this->_val = $val;
        return $this;
    }

    public function getVal()
    {
        return $this->_val;
    }

    public function cancel($cancel = true)
    {
        $this->_cancel = $cancel;
        return $this;
    }

    public function isCanceled()
    {
        return $this->_cancel;
    }

}
