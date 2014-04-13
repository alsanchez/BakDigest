<?php

namespace AlSanchez\BakDigestBundle\Controller;

use AlSanchez\BakDigestBundle\Entity\Backup;
use AlSanchez\BakDigestBundle\Model\BackupInfo;
use DateInterval;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UpdateDigestDeliveryController extends Controller
{
    public function indexAction($digestId)
    {
        $digest = $this->getDoctrine()->getRepository('AlSanchezBakDigestBundle:Digest')->find($digestId);
        if($digest === NULL)
        {
            return new Response('404 Not Found', 404);
        }

        $currentDate = new DateTime();
        $targetDate = $digest->getLastDelivery()->add(new DateInterval(sprintf('PT%dS', $digest->getPeriodicity())));
        if($currentDate < $targetDate)
        {
            return new Response('304 Not Modified', 304);
        }

        $correctBackups = [];
        $incorrectBackups = [];
        foreach($digest->getBackups() as $backup)
        {
            $targetDate = clone $currentDate;
            $targetDate = $targetDate->sub(new DateInterval(sprintf('PT%dS', $backup->getFrequency())));
            $lastNotification = static::getLatestNotification($backup);
            $lastNotificationDate = $lastNotification === NULL
                ? NULL
                : $lastNotification->getDate();
            $info = new BackupInfo($backup->getName(), $lastNotificationDate);

            if($lastNotificationDate === NULL || $lastNotificationDate < $targetDate || $lastNotification->getSuccessful() === FALSE)
            {
                if($lastNotificationDate === NULL)
                {
                    $info->setStatus('No backup ever performed');
                }
                elseif($lastNotificationDate < $targetDate)
                {
                    $info->setStatus(sprintf('No backup performed in the last %d seconds', $backup->getFrequency()));
                }
                elseif($lastNotification->getSuccessful() === FALSE)
                {
                    $info->setStatus('The backup process failed');
                }

                $incorrectBackups[] = $info;
            }
            else
            {
                $info->setStatus('OK');
                $correctBackups[] = $info;
            }
        }

        $correctBackupsCount = count($correctBackups);
        $incorrectBackupsCount = count($incorrectBackups);

        if($incorrectBackups === 0)
        {
            $subject = sprintf('[OK] All %d backups correct', $correctBackupsCount);
        }
        elseif($correctBackups === 0)
        {
            $subject = sprintf('[ERROR] All %d backups are failing', $incorrectBackupsCount);
        }
        else
        {
            $subject = sprintf('[ERROR] %d backups are failing, %d correct', $incorrectBackupsCount, $correctBackupsCount);
        }

        $allBackups = array_merge($incorrectBackups, $correctBackups);
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom([$this->container->getParameter('mailer_user') => 'BakDigestgm'])
            ->setTo($digest->getEmail())
            ->setBody($this->renderView('@AlSanchezBakDigest/UpdateDigestDelivery/index.html.twig', [
                'backups' => $allBackups
            ]), 'text/html');

        $this->get('mailer')->send($message);

        $digest->setLastDelivery($currentDate);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($digest);
        $manager->flush();

        return new Response('200 OK', 200);
    }

    /**
     * @param Backup $backup
     * @return \AlSanchez\BakDigestBundle\Entity\BackupNotification|null
     */
    private static function getLatestNotification(Backup $backup)
    {
        $latestNotification = NULL;

        foreach($backup->getNotifications() as $notification)
        {
            if($latestNotification == NULL || $notification->getDate() > $latestNotification)
            {
                $latestNotification = $notification;
            }
        }

        return $latestNotification;
    }
} 