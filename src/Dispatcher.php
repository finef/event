<?php

namespace Fine\Event;

class Dispatcher
{

    protected $_listeners = [];

    public function bind(Listener $listener)
    {
        if (!$this->_listeners[$listener->getId()]) {
            $this->_listeners[$listener->getId()] = [];
        }
        
        $pos = count($this->_listeners[$listener->getId()]);
        foreach ($this->_listeners[$listener->getId()] as $k => $v) {
            if ($v->priority > $listener->getPriority()) {
                $pos = $k;
                break;
            }            
        }
        
        array_splice($this->_listeners[$listener->getId()], $pos, 0, [$listener]);

        return $this;
    }
    
    public function on($id, $callback, $priority = 0)
    {
        return $this->bind((new Listener())->setId($id)->setCallback($callback)->setPriority($priority));
    }

    public function run(Event $event)
    {
        foreach ((array)$this->_listeners[$event->getId()] as $listener) {
            call_user_func($listener->getCallback(), $event);
            if ($event->isPropagationStopped()) {
                break;
            }
        }

        return $event;
    }

}
