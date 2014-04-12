<?php

namespace AlSanchez\BakDigestBundle\Entity;

use DateTime;

class BackupNotification
{
    /** @var int */
    private $id;
    /** @var DateTime */
    private $date;
    /** @var boolean */
    private $successful;
    /** @var Backup */
    private $backup;

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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
     * @return boolean
     */
    public function getSuccessful()
    {
        return $this->successful;
    }

    /**
     * @param boolean $successful
     */
    public function setSuccessful($successful)
    {
        $this->successful = $successful;
    }

    /**
     * @return Backup
     */
    public function getBackup()
    {
        return $this->backup;
    }

    /**
     * @param Backup $backup
     */
    public function setBackup($backup)
    {
        $this->backup = $backup;
    }
}