<?php

namespace AlSanchez\BakDigestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DeleteBackupController extends Controller
{
    public function indexAction($backupId)
    {
        $backup = $this->getDoctrine()->getRepository('AlSanchezBakDigestBundle:Backup')->find($backupId);
        if($backup === NULL)
        {
            return new Response('404 Not Found', 404);
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($backup);
        $manager->flush();

        return new Response('204 No Content', 204);
    }
} 