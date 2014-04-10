<?php

namespace Tele\ComBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestFormatRemoveListener
{

    public function onKernelRequest(GetResponseEvent $e)
    {
        // Had to do it, because ApiDoc sandbox always sends this parameter and it conflicts with forms (maybe there's a better way to do it on the form's side)
        if ($e->getRequest()->request->has("_format")) {
            $e->getRequest()->request->remove("_format");
        }
    }

}
