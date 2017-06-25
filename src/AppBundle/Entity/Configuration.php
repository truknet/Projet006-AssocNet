<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Configuration
 *
 * @ORM\Table(name="configuration")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConfigurationRepository")
 */
class Configuration
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="themefront", type="string", length=255, nullable=true)
     */
    private $themeFront;

    /**
     * @var string
     *
     * @ORM\Column(name="themeadmin", type="string", length=255, nullable=true)
     */
    private $themeAdmin;

    /**
     * @var integer
     *
     * @ORM\Column(name="frontsidebarlastassocnb", type="integer", nullable=true)
     */
    private $frontSidebarLastAssocNb;

    /**
     * @var integer
     *
     * @ORM\Column(name="frontlistassocnb", type="integer", nullable=true)
     */
    private $frontListAssocNb;

    /**
     * @var boolean
     *
     * @ORM\Column(name="adminvalidautosubmissionassoc", type="boolean", nullable=true)
     */
    private $adminValidAutoSubmissionAssoc;


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
     * Set name
     *
     * @param string $name
     *
     * @return Configuration
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set themeFront
     *
     * @param string $themeFront
     *
     * @return Configuration
     */
    public function setThemeFront($themeFront)
    {
        $this->themeFront = $themeFront;

        return $this;
    }

    /**
     * Get themeFront
     *
     * @return string
     */
    public function getThemeFront()
    {
        return $this->themeFront;
    }

    /**
     * Set themeAdmin
     *
     * @param string $themeAdmin
     *
     * @return Configuration
     */
    public function setThemeAdmin($themeAdmin)
    {
        $this->themeAdmin = $themeAdmin;

        return $this;
    }

    /**
     * Get themeAdmin
     *
     * @return string
     */
    public function getThemeAdmin()
    {
        return $this->themeAdmin;
    }

    /**
     * Set frontSidebarLastAssocNb
     *
     * @param integer $frontSidebarLastAssocNb
     *
     * @return Configuration
     */
    public function setFrontSidebarLastAssocNb($frontSidebarLastAssocNb)
    {
        $this->frontSidebarLastAssocNb = $frontSidebarLastAssocNb;

        return $this;
    }

    /**
     * Get frontSidebarLastAssocNb
     *
     * @return integer
     */
    public function getFrontSidebarLastAssocNb()
    {
        return $this->frontSidebarLastAssocNb;
    }

    /**
     * Set frontListAssocNb
     *
     * @param integer $frontListAssocNb
     *
     * @return Configuration
     */
    public function setFrontListAssocNb($frontListAssocNb)
    {
        $this->frontListAssocNb = $frontListAssocNb;

        return $this;
    }

    /**
     * Get frontListAssocNb
     *
     * @return integer
     */
    public function getFrontListAssocNb()
    {
        return $this->frontListAssocNb;
    }

    /**
     * Set adminValidAutoSubmissionAssoc
     *
     * @param boolean $adminValidAutoSubmissionAssoc
     *
     * @return Configuration
     */
    public function setAdminValidAutoSubmissionAssoc($adminValidAutoSubmissionAssoc)
    {
        $this->adminValidAutoSubmissionAssoc = $adminValidAutoSubmissionAssoc;

        return $this;
    }

    /**
     * Get adminValidAutoSubmissionAssoc
     *
     * @return boolean
     */
    public function getAdminValidAutoSubmissionAssoc()
    {
        return $this->adminValidAutoSubmissionAssoc;
    }
}
