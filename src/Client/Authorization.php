<?php
namespace Drei\EspoCRM\Client;

use GuzzleHttp\Event\BeforeEvent;
use GuzzleHttp\Event\RequestEvents;
use GuzzleHttp\Event\SubscriberInterface;


class Authorization implements SubscriberInterface {
    private $username;
    
    private $token;

    public function __construct($username,$token) {
        $this->username = $username;
        $this->token = $token;
    }

    public function getEvents() {
        return ['before' => ['sign', RequestEvents::SIGN_REQUEST]];
    }

    public function sign(BeforeEvent $e) {
        if ($e->getRequest()->getConfig()['auth'] == 'espo') {
            $e->getRequest()->setHeader('Espo-Authorization', base64_encode($this->username . ':' . $this->token));
        }
    }
}