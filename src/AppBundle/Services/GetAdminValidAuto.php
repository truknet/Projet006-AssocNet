<?php

namespace AppBundle\Services;

use AppBundle\Entity\Associations;
use Symfony\Component\HttpFoundation\Session\Session;
use FOS\UserBundle\Model\UserManagerInterface;

class GetAdminValidAuto
{
    private $user;
    private $session;
    private $loadConfig;
    protected $userManager;

    /**
     * @param $token
     * @param Session $session
     * @param \AppBundle\Services\LoadConfig $loadConfig
     * @param UserManagerInterface $userManager
     * @param $var_project
     * @internal param EntityManagerInterface $em
     */
    public function __construct($token, Session $session, $var_project, LoadConfig $loadConfig, UserManagerInterface $userManager)
    {
        $this->user = $token->getToken()->getUser();
        $this->session = $session;
        $this->var_project = $var_project;
        $this->loadConfig = $loadConfig;
        $this->userManager = $userManager;
    }

    public function getAdminValidAuto(Associations $associations)
    {
        if ($this->loadConfig->loadConfig()->getAdminValidAutoSubmissionAssoc()) {
            $admin = $this->userManager->findUserByUsername('admin');
            $associations->setStatus($this->var_project['status_assoc_valid']);
            $associations->setDateApproval(new \DateTime());
            $associations->setApprouvedBy($admin);
        } else {
            $associations->setApprouvedBy(null);
            $associations->setDateApproval(null);
            $associations->setStatus($this->var_project['status_assoc_waiting']);
            $this->session->getFlashBag()->add("info", "Vos modifications vont être analysées par un de nos Administrateurs.");
        }
        return $associations;
    }

}

