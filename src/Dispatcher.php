<?php

namespace \Fine\Event;

class Dispatcher
{

    protected $_listeners = [];

    public function on($id, $callback, $priority = 0, $filter = null)
    {
        $listener = (object)['priority' => $priority, 'callback' => $callback, 'filter' => $filter];

        if (!$this->_listeners[$id]) {
            $this->_listeners[$id] = [];
        }
        
        $pos = count($this->_listeners[$id]);
        foreach ($this->_listeners[$id] as $k => $v) {
            if ($v->priority > $listener->priority) {
                $pos = $k;
                break;
            }            
        }
        
        array_splice($this->_listeners[$id], $pos, 0, [$listener]);

        return $this;
    }

    public function run(Event $event)
    {
        $id = $event->id();

        if (!isset($this->_listeners[$id])) {
            return $this;
        }

        foreach ($this->_listeners[$id] as $listener) {
            
            if ($listener->filter !== null && $listener->filter !== $event->getFilter()) {
                continue;
            }
            
            call_user_func($listener->callback, $event);
            if ($event->isPropagationStopped()) {
                break;
            }
            
        }

        return $event;
    }

}
