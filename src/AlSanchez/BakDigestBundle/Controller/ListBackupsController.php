<?php

namespace AlSanchez\BakDigestBundle\Controller;

use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ListBackupsController extends Controller
{
    public function indexAction()
    {
        $backups = $this->getDoctrine()->getRepository('AlSanchezBakDigestBundle:Backup')->findAll();
        $serializer = $this->get('jms_serializer');
        $data = $serializer->serialize($backups, 'json', SerializationContext::create()->setGroups(['list']));
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}