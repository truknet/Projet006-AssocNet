<?php

namespace AppBundle\Services;

use AppBundle\Entity\Associations;
use Symfony\Component\HttpFoundation\Session\Session;


class CheckAssoc
{
    private $user;
    private $session;

    public function __construct($token, Session $session)
    {
        $this->user = $token->getToken()->getUser();
        $this->session = $session;
    }

    public function checkAssoc(Associations $associations)
    {
        // Vérification que l'association existe en base de données
        if ($associations === null) {
            $this->session->getFlashBag()->add("warning", "Cette association n'existe pas.");
            return false;
        }
        // Vérification que l'association appartient à l'utilisateur courant
        if ($associations->getAuthor()->getId() != $this->user->getId()) {
            $this->session->getFlashBag()->add("warning", "Cette association ne vous appartient pas.");
            return false;
        }
        return true;
    }

}

