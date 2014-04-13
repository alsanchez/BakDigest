<?php

namespace AlSanchez\BakDigestBundle\Model;

use DateTime;

class BackupInfo
{
    /** @var string */
    private $name;
    /** @var DateTime */
    private $lastBackup;
    /** @var string */
    private $status;

    /**
     * @param string $name
     * @param DateTime $lastBackup
     */
    function __construct($name, $lastBackup)
    {
        $this->name = $name;
        $this->lastBackup = $lastBackup;
    }

    /**
     * @return DateTime
     */
    public function getLastBackup()
    {
        return $this->lastBackup;
    }

    /**
     * @param DateTime $lastBackup
     */
    public function setLastBackup($lastBackup)
    {
        $this->lastBackup = $lastBackup;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}