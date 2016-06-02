<?php

namespace Fine\Event;

class Listener
{

    protected $_id;
    protected $_callback;
    protected $_priority;

    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId() 
    {
        return $this->_id;
    }

    public function setPriority($priority)
    {
        $this->_priority = $priority;
        return $this;
    }
    
    public function getPriority()
    {
        return $this->_priority;
    }

    public function setCallback($callback)
    {
        $this->_callback = $callback;
        return $this;
    }

    public function getCallback()
    {
        return $this->_callback;
    }

}
