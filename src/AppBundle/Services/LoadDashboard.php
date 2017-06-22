<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManagerInterface;


class LoadDashboard
{
    private $em;
    private $dashboard = array();

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em, $var_project)
    {
        $this->em = $em;
        $this->var_project = $var_project;

    }

    public function loadDashboard()
    {
        $this->dashboard = array(
            'name_project' => $this->var_project['name_project'],
            'member_user' => count($this->em->getRepository('AppBundle:User')->findUserByRoleUser()),
            'member_admin' => count($this->em->getRepository('AppBundle:User')->findUserByRole('ROLE_ADMIN')),
            'count_categorie' => count($this->em->getRepository('AppBundle:Categories')->findAll()),
            'count_association' => count($this->em->getRepository('AppBundle:Associations')->findAll()),
            );
        return $this->dashboard;
    }
}

