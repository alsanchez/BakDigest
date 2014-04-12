<?php

namespace AlSanchez\BakDigestBundle\Controller;

use AlSanchez\BakDigestBundle\Entity\Digest;
use AlSanchez\BakDigestBundle\Exceptions\KeyNotFoundException;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CreateDigestController extends Controller
{
    public function indexAction()
    {
        $requestBody = $this->get('request')->getContent();

        $requestData = json_decode($requestBody, TRUE);
        if ($requestData === NULL)
        {
            return new Response('400 Bad Request', 400);
        }

        try
        {
            $digest = new Digest();
            $digest->setPeriodicity(static::getValue($requestData, 'periodicity'));
            $digest->setEmail(static::getValue($requestData, 'email'));
            $digest->setLastDelivery(new DateTime(static::getValue($requestData, 'start_date')));

            $backupRepository = $this->getDoctrine()->getRepository('AlSanchezBakDigestBundle:Backup');
            foreach(static::getValue($requestData, 'backup_ids') as $backupId)
            {
                $backup = $backupRepository->find($backupId);
                if($backup === NULL)
                {
                    return new Response('409 Conflict', 409);
                }
                $digest->addBackup($backup);
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($digest);
            $manager->flush();

            return new Response('201 Created', 201);

        }
        catch (KeyNotFoundException $e)
        {
            return new Response('400 Bad Request');
        }
    }

    private static function getValue($array, $key)
    {
        if (!array_key_exists($key, $array))
        {
            throw new KeyNotFoundException();
        }

        return $array[$key];
    }
} 