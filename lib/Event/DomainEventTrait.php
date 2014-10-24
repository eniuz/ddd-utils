<?php
/**
 * Created by PhpStorm.
 * User: mariogiustiniani
 * Date: 18/09/14
 * Time: 14:43
 */

namespace Manticora\Common\Event;

/**
 * Class DomainEventTrait
 * @package Manticora\Common\Event
 */
trait DomainEventTrait {

    /**
     * @var array
     */
    protected $pendingEvents = array();

    /**
     * @param $event
     */
    protected function raise($event) {
        $this->pendingEvents[] = $event;
    }

    /**
     * @return array
     */
    public function releaseEvents() {
        $events = $this->pendingEvents;
        $this->pendingEvents = array();
        return $events;
    }

} 