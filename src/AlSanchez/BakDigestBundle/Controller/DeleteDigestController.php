<?php

namespace AlSanchez\BakDigestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DeleteDigestController extends Controller 
{
    public function indexAction($digestId)
    {
        $digest = $this->getDoctrine()
            ->getRepository('AlSanchezBakDigestBundle:Digest')->find($digestId);
        
        if($digest === NULL)
        {
            return new Response('404 Not Found', 404);
        }
        
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($digest);
        $manager->flush();
        
        return new Response('204 No Content', 204);
    }
} 