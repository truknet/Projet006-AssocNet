<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ShowcaseType;
use AppBundle\Services\GetAdminValidAuto;
use AppBundle\Services\LoadConfig;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Associations;
use AppBundle\Services\CheckAssoc;

class FrontShowcaseController extends Controller
{
    /**
     *
     * @Route("/editshowcase/{slug}", name="edit_showcase")
     * @param Associations $associations
     * @param Request $request
     * @param CheckAssoc $checkAssoc
     * @param GetAdminValidAuto $getAdminValidAuto
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param $slug
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET", "POST"})
     */
    public function editShowcaseAction(Associations $associations, Request $request, CheckAssoc $checkAssoc, GetAdminValidAuto $getAdminValidAuto)
    {
        if (!$checkAssoc->checkAssoc($associations)) {
            return $this->redirectToRoute('user_association');
        }
        $loadConfig = $this->get(LoadConfig::class);
        $em = $this->getDoctrine()->getManager();
        $showcase = $associations->getShowcase();
        $form = $this->get('form.factory')->create(ShowcaseType::class, $showcase);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $getAdminValidAuto->getAdminValidAuto($associations);
            $associations->setShowcase($showcase);
            $em->persist($associations);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Vos modifications ont bien été enregistrées !');
            return $this->redirectToRoute('user_association');
        }
        if (!$loadConfig->loadConfig()->getAdminValidAutoSubmissionAssoc())
        {
            if ($associations->getStatus($this->getParameter('var_project')['status_assoc_valid']))
            {
                $request->getSession()->getFlashBag()->add("info", "A lire : En cas de modification de votre association, le status de celle-ci passera automatiquement en mode 'En attente' pour être analysée par un de nos Administrateurs.");
            }
        }
        return $this->render('Front/editShowcase.html.twig', array(
            'association' => $associations,
            'form' => $form->createView(),
        ));
    }


    /**
     *
     * @Route("/page/{slug}", name="showcase")
     * @param Associations $associations
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param $slug
     * @Method({"GET"})
     */
    public function showcaseAction(Associations $associations)
    {
        return $this->render('Showcase/template1.html.twig', array(
            'association' => $associations,
        ));
    }

}

