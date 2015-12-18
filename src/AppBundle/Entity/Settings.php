<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Settings
 *
 * @ORM\Table(name="settings")
 * @ORM\Entity
 */
class Settings
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
     * @ORM\Column(name="api_base_url", type="string", length=50)
     * @Assert\Url()
     * @Assert\NotBlank()
     */
    protected $apiBaseUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="printbox_pid", type="string", length=36)
     * @Assert\NotBlank()
     */
    protected $printboxPid;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set apiBaseUrl
     *
     * @param string $apiBaseUrl
     *
     * @return Settings
     */
    public function setApiBaseUrl($apiBaseUrl)
    {
        $this->apiBaseUrl = $apiBaseUrl;

        return $this;
    }

    /**
     * Get apiBaseUrl
     *
     * @return string
     */
    public function getApiBaseUrl()
    {
        return $this->apiBaseUrl;
    }

    /**
     * Set printboxPid
     *
     * @param string $printboxPid
     *
     * @return Settings
     */
    public function setPrintboxPid($printboxPid)
    {
        $this->printboxPid = $printboxPid;

        return $this;
    }

    /**
     * Get printboxPid
     *
     * @return string
     */
    public function getPrintboxPid()
    {
        return $this->printboxPid;
    }
}
