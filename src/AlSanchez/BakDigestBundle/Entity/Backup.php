<?php

namespace AlSanchez\BakDigestBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
/** @var Groups */
use JMS\Serializer\Annotation\Groups;

class Backup
{
    /**
     * @Groups({"list"})
     * @var int
     */
    protected $id;

    /**
     * @Groups({"list"})
     * @var string
     */
    protected $name;

    /**
     * @Groups({"list"})
     * @var string
     */
    protected $description;

    /**
     * @Groups({"list"})
     * @var int
     */
    protected $frequency;

    /** @var BackupNotification[] */
    protected $notifications;


    function __construct()
    {
        $this->notifications = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @param int $frequency
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;
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
     * @return BackupNotification[]
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @param BackupNotification[] $notifications
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;
    }
} 