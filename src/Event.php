<?php

namespace Fine\Event;

class Event
{

    protected $_id;
    protected $_subject;
    protected $_val;
    protected $_propagationStopped = false;
    protected $_filter;
    protected $_dispatcher;

    public function __construct(array $config = array())
    {
        foreach ($config as $method => $arg) {
            $this->{$method}($arg);
        }
    }

    public function __call($method, $args)
    {
        $action = substr($method, 0, 3);
        $property = lcfirst(substr($method, 3));

        if ($action === 'set') {
            $this->$property = $args[0];
            return $this;

        } elseif ($action === 'get') {
            return $this->$property;

        } elseif ($action == 'has') {
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
    
    public function setFilter($filter) 
    {
        $this->_filter = $filter;
        return $this;
    }

    public function getFilter() 
    {
        return $this->_filter;
    }

    public function stopPropagation()
    {
        $this->_propagationStopped = true;
        return $this;
    }

    public function isPropagationStopped()
    {
        return $this->_propagationStopped;
    }

    public function setDispatcher($dispatcher)
    {
        $this->_dispatcher = $dispatcher;
        return $this;
    }

    public function run()
    {
        return $this->_dispatcher->run($this);
    }

}
