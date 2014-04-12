<?php

namespace AlSanchez\BakDigestBundle\Controller;

use AlSanchez\BakDigestBundle\Entity\Backup;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CreateBackupController extends Controller
{
    public function indexAction()
    {
        $requestBody = $this->get('request')->getContent();

        $requestData = json_decode($requestBody, TRUE);
        if($requestData === NULL)
        {
            return new Response('400 Bad Request', 400);
        }

        $backup = new Backup();

        if(array_key_exists('name', $requestData))
        {
            $backup->setName($requestData['name']);
        }
        else
        {
            return new Response('400 Bad Request', 400);
        }

        if(array_key_exists('description', $requestData))
        {
            $backup->setDescription($requestData['description']);
        }

        if(array_key_exists('frequency', $requestData))
        {
            $backup->setFrequency($requestData['frequency']);
        }
        else
        {
            return new Response('400 Bad Request', 400);
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($backup);
        $manager->flush();

        return new Response('201 Created', 201);
    }
} 