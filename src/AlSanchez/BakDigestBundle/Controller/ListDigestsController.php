<?php

namespace AlSanchez\BakDigestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ListDigestsController extends Controller
{
    public function indexAction()
    {
        $digests = $this->getDoctrine()->getRepository('AlSanchezBakDigestBundle:Digest')->findAll();
        $serializer = $this->get('jms_serializer');
        $data = $serializer->serialize($digests, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
} 