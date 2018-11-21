<?php

namespace Drupal\chatbro_com§\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class CBroInit implements EventSubscriberInterface {
  public static function getSubscribedEvents() {
    die("AAA!")
    echo "<h1>getSubscribedEvents()</h1>";
    // die("<h1>getSubscribedEvents()</h1>");
    $events[KernelEvents::REQUEST][] = "init";
    return $events;
  }

  public function init(GetResponseEvent $event) {
  }
}

?>
