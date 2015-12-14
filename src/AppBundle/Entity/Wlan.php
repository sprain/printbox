<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Wlan
 *
 * @ORM\Table(name="wlans")
 * @ORM\Entity
 */
class Wlan
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ssid", type="string", length=50, unique=true)
     * @Assert\NotBlank()
     */
    private $ssid;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ssid
     *
     * @param string $ssid
     *
     * @return Wlan
     */
    public function setSsid($ssid)
    {
        $this->ssid = $ssid;

        return $this;
    }

    /**
     * Get ssid
     *
     * @return string
     */
    public function getSsid()
    {
        return $this->ssid;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Wlan
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}

