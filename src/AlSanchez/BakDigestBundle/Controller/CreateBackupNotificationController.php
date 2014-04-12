<?php

namespace AlSanchez\BakDigestBundle\Controller;

use AlSanchez\BakDigestBundle\Entity\BackupNotification;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CreateBackupNotificationController extends Controller
{
    public function indexAction($backupId)
    {
        $requestBody = $this->get('request')->getContent();

        $requestData = json_decode($requestBody, TRUE);
        if($requestData === NULL)
        {
            return new Response('400 Bad Request', 400);
        }

        $backup = $this->getDoctrine()->getRepository('AlSanchezBakDigestBundle:Backup')
            ->find($backupId);

        if($backup === NULL)
        {
            return new Response('404 Not Found', 404);
        }

        $notification = new BackupNotification();
        $notification->setBackup($backup);
        $notification->setDate(new DateTime());

        if(array_key_exists('successful', $requestData))
        {
            $notification->setSuccessful($requestData['successful']);
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($notification);
        $manager->flush();

        return new Response('201 Created', 201);
    }
} 