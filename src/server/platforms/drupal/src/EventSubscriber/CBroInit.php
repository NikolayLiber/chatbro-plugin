<?php

namespace Drupal\chatbro\EventSubscriber;

require_once('test.php');
// require_once('../Controller/CBroController.php');
// require_once('../common/settings/settings.php');
// require_once('../common/permissions/permissions.php');
// require_once('../common/user/user.php');
// require_once('../common/utils/utils.php');


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class CBroInit implements EventSubscriberInterface {
  public static function getSubscribedEvents() {
    echo "<h1>getSubscribedEvents()</h1>";
    // die("<h1>getSubscribedEvents()</h1>");
    $events[KernelEvents::REQUEST][] = "init";
    return $events;
  }

  public function init(GetResponseEvent $event) {
  }
}

?>
