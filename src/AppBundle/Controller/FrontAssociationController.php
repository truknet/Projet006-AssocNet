<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Showcase;
use AppBundle\Services\CheckAssoc;
use AppBundle\Services\LoadConfig;
use AppBundle\Services\GetAdminValidAuto;
use AppBundle\Services\SendEmail;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Associations;
use AppBundle\Form\Type\AssociationsType;
use AppBundle\Services\FileUploader;
use Symfony\Component\HttpFoundation\File\File;
use AppBundle\Entity\Contact;
use AppBundle\Form\Type\ContactType;

class FrontAssociationController extends Controller
{

    /**
     * @Route("/directory/{slug}/{page}", name="directory")
     * @param $slug
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function directoryAction($slug, $page = 1)
    {
        $loadConfig = $this->get(LoadConfig::class);
        $em = $this->getDoctrine()->getManager();
        if ($slug == 'all') {
            $categorie = null;
            $listAssociations = $em->getRepository('AppBundle:Associations')->findby(
                array('status' => 'validated'),                    // Critere
                array('id' => 'desc')                         // Tri
            );
        } else {
            $categorie = $em->getRepository('AppBundle:Categories')->findOneBy(array('slug' => $slug));
            $listAssociations = $em->getRepository('AppBundle:Associations')->findby(
                array('categorie' => $categorie, 'status' => 'validated'),                    // Critere
                array('id' => 'desc')                                // Tri
            );
        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $listAssociations,      /* query NOT result */
            $page,                  /*page number*/
            $loadConfig->loadConfig()->getFrontListAssocNb()    /*limit per page*/
        );
        return $this->render('Front/directory.html.twig', array(
            'categorie' => $categorie,
            'pagination' => $pagination
        ));
    }

    /**
     *
     * @Route("/viewoneassociation/{slug}", name="view_one_association")
     * @param Associations $associations
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param $slug
     * @Method({"GET"})
     */
    public function viewOneAssociationAction(Associations $associations)
    {
        return $this->render('Front/viewOneAssociation.html.twig', array(
            'association' => $associations,
        ));
    }

    /**
     * @Route("/addassociation", name="add_association")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET", "POST"})
     */
    public function addAssociationAction(Request $request)
    {
        $loadConfig = $this->get(LoadConfig::class);
        $em = $this->getDoctrine()->getManager();
        $associations = new Associations();
        $form = $this->get('form.factory')->create(AssociationsType::class, $associations);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $associations->setAuthor($this->getUser());
            if ($loadConfig->loadConfig()->getAdminValidAutoSubmissionAssoc())
            {
                $userManager = $this->get('fos_user.user_manager');
                $admin = $userManager->findUserByUsername('admin');
                $associations->setStatus($this->getParameter('var_project')['status_assoc_valid']);
                $associations->setDateApproval(new \DateTime());
                $associations->setApprouvedBy($admin);
            } else {
                $associations->setStatus($this->getParameter('var_project')['status_assoc_waiting']);
            }
            $showcase = new Showcase();
            $associations->setShowcase($showcase);
            $em->persist($associations);
            $em->flush();
            $request->getSession()->getFlashBag()->add("success", "L'association à bien été sauvegardée.");
            return $this->redirectToRoute('user_association');
        }
        return $this->render('Front/addAssociation.html.twig', array(
            'associations' => $associations,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/userassociation", name="user_association")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET"})
     */
    public function userAssociationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $listAssociations = $em->getRepository('AppBundle:Associations')->findby(
            array('author' => $user), // Critere
            array('id' => 'desc')
        );                     // Tri
        return $this->render('Front/userAssociation.html.twig', array(
            'listAssociations' => $listAssociations,
        ));
    }

    /**
     * @Route("/editassociation/{slug}", name="edit_association")
     * @param Request $request
     * @param Associations $associations
     * @param CheckAssoc $checkAssoc
     * @param GetAdminValidAuto $getAdminValidAuto
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @internal param FileUploader $fileUploader
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET", "POST"})
     */
    public function editAssociationAction(Request $request, Associations $associations = null, CheckAssoc $checkAssoc, GetAdminValidAuto $getAdminValidAuto)
    {

        if (!$checkAssoc->checkAssoc($associations)) {
            return $this->redirectToRoute('user_association');
        }
        $loadConfig = $this->get(LoadConfig::class);
        $em = $this->getDoctrine()->getManager();
        $oldLogo = $associations->getLogo();
        if ($oldLogo !== null)
        {
            $associations->setLogo(new File($this->getParameter('uploads_images_directory').'/'.$associations->getLogo()));
        }
        $form = $this->get('form.factory')->create(AssociationsType::class, $associations);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $getAdminValidAuto->getAdminValidAuto($associations);
            if ($associations->getLogo() === null && $oldLogo !== null)
            {
                $associations->setLogo($oldLogo);
            }
            $em->persist($associations);
            $em->flush();
            if ($oldLogo !== null && $associations->getLogo() !== $oldLogo)
            {
                if (file_exists($this->getParameter('uploads_images_directory') . '/' . $oldLogo))
                {
                    unlink($this->getParameter('uploads_images_directory') . '/' . $oldLogo);
                }
            }
            $request->getSession()->getFlashBag()->add("success", "L'association à bien été sauvegardée.");
            return $this->redirectToRoute('user_association');
        }
        if (!$loadConfig->loadConfig()->getAdminValidAutoSubmissionAssoc())
        {
            if ($associations->getStatus($this->getParameter('var_project')['status_assoc_valid']))
            {
                $request->getSession()->getFlashBag()->add("info", "A lire : En cas de modification de votre association, le status de celle-ci passera automatiquement en mode 'En attente' pour être analysée par un de nos Administrateurs.");
            }
        }
        return $this->render('Front/addAssociation.html.twig', array(
            'associations' => $associations,
            'form' => $form->createView()
        ));
    }

    /**
     *
     * @Route("/delassociation/{slug}", name="del_association")
     * @param Request $request
     * @param Associations $associations
     * @param CheckAssoc $checkAssoc
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET", "POST"})
     */
    public function delAssociationAction(Request $request, Associations $associations = null, CheckAssoc $checkAssoc)
    {
        if (!$checkAssoc->checkAssoc($associations)) {
            return $this->redirectToRoute('user_association');
        }
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('form.factory')->create();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (is_file($this->getParameter('uploads_images_directory').'/'.$associations->getLogo())) {
                unlink($this->getParameter('uploads_images_directory').'/'.$associations->getLogo());
            }
            $em->remove($associations);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "L'association a bien été supprimée.");
            return $this->redirectToRoute('user_association');
        }
        return $this->render('Front/delAssociation.html.twig', array(
            'associations' => $associations,
            'form'   => $form->createView(),
        ));
    }

    /**
     * @Route("/viewlastassociations", name="view_last_associations")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewLastAssociationsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listAssociations = $em->getRepository('AppBundle:Associations')->findby(
            array('status' => 'validated'), // Critere
            array('id' => 'desc'),                      // Tri
            10,   // Limite
            0                                           // Offset
        );
        return $this->render('Front/_viewLastAssociations.html.twig', array(
            'listAssociations' => $listAssociations
        ));
    }

    /**
     * @Route("/sidebarviewlastassociations", name="sidebar_view_last_associations")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sidebarViewLastAssociationsAction(Request $request)
    {
        $loadConfig = $this->get(LoadConfig::class);
        $em = $this->getDoctrine()->getManager();
        $listAssociations = $em->getRepository('AppBundle:Associations')->findby(
            array('status' => 'validated'), // Critere
            array('id' => 'desc'),                      // Tri
            $loadConfig->loadConfig()->getFrontSidebarLastAssocNb(),   // Limite
            0                                           // Offset
        );
        return $this->render('Front/_sidebarViewLastAssociations.html.twig', array(
            'listAssociations' => $listAssociations
        ));
    }
}

