<?php

namespace \Fine\Event;

class Dispatcher
{

    protected $_listener = array();

    public function on($id, $callback, $priority = 0)
    {
        $listener = array('priority' => $priority, 'callback' => $callback);

        /* @TODO insert by priority */

        $this->_listener[$eventId][] = $listener;
    }

    public function run(Event $event)
    {
        $id = $event->id();

        if (!isset($this->_listener[$id])) {
            return $this;
        }

        foreach ($this->_listener[$id] as $listener) {
            call_user_func($listener['callback'], $event);
            if ($event->isCanceled()) {
                break;
            }
        }

        return $this;
    }

    public function runId($id)
    {
        return $this->run((new Event())->setId($id));
    }

}
