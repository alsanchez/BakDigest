<?php

namespace AlSanchez\BakDigestBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

class Digest
{
    /** @var int */
    protected $id;
    /** @var Backup[] */
    protected $backups;
    /** @var int */
    protected $periodicity;
    /** @var string */
    protected $email;
    /** @var DateTime */
    protected $last_delivery;

    function __construct()
    {
        $this->backups = new ArrayCollection();
    }

    public function addBackup(Backup $backup)
    {
        $this->backups->add($backup);
    }

    /**
     * @return Backup[]
     */
    public function getBackups()
    {
        return $this->backups;
    }

    /**
     * @param Backup[] $backups
     */
    public function setBackups($backups)
    {
        $this->backups = $backups;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getPeriodicity()
    {
        return $this->periodicity;
    }

    /**
     * @param int $periodicity
     */
    public function setPeriodicity($periodicity)
    {
        $this->periodicity = $periodicity;
    }

    /**
     * @return DateTime
     */
    public function getLastDelivery()
    {
        return $this->last_delivery;
    }

    /**
     * @param DateTime $last_delivery
     */
    public function setLastDelivery($last_delivery)
    {
        $this->last_delivery = $last_delivery;
    }
}