<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Showcase;
use AppBundle\Form\Type\ShowcaseType;
use AppBundle\Services\LoadConfig;
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

class FrontController extends Controller
{

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {

        return $this->render('Front/index.html.twig');
    }


    /**
     * @Route("/front", name="front")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function frontAction(Request $request)
    {
        return $this->render('Front/front.html.twig');
    }

    /**
     * @Route("/viewallcategories", name="view_all_categories")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAllCategoriesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listCategories = $em->getRepository('AppBundle:Categories')->findAll();
        $listCategoriesWithAssocValid = array();
        foreach ($listCategories as $value)
        {
            $nbAssocValid = count($em->getRepository('AppBundle:Associations')->findby(array('categorie' => $value, 'status' => 'validated')));
            $listCategoriesWithAssocValid[] = array('categorie' => $value, 'nbAssocValid' => $nbAssocValid);
        }
        $nbAssocations = count($em->getRepository('AppBundle:Associations')->findby(array('status' => $this->getParameter('var_project')['status_assoc_valid'])));
        return $this->render('Front/_viewCategories.html.twig', array(
            'nbAssocations' => $nbAssocations,
            'listCategoriesWithAssocValid' => $listCategoriesWithAssocValid
        ));
    }

    /**
     * @Route("/sidebarviewallcategories", name="sidebar_view_all_categories")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sidebarViewAllCategoriesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listCategories = $em->getRepository('AppBundle:Categories')->findAll();
        $listCategoriesWithAssocValid = array();
        foreach ($listCategories as $value)
        {
            $nbAssocValid = count($em->getRepository('AppBundle:Associations')->findby(array('categorie' => $value, 'status' => 'validated')));
            $listCategoriesWithAssocValid[] = array('categorie' => $value, 'nbAssocValid' => $nbAssocValid);
        }
        $nbAssocations = count($em->getRepository('AppBundle:Associations')->findby(array('status' => $this->getParameter('var_project')['status_assoc_valid'])));

        return $this->render('Front/_sidebarViewCategories.html.twig', array(
            'nbAssocations' => $nbAssocations,
            'listCategoriesWithAssocValid' => $listCategoriesWithAssocValid
        ));
    }

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
     * @Method({"GET", "POST"})
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
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET", "POST"})
     */
    public function editAssociationAction(Request $request, Associations $associations = null, FileUploader $fileUploader)
    {
        // Vérification que l'association existe en base de données
        if ($associations === null) {
            $request->getSession()->getFlashBag()->add("warning", "Cette association n'existe pas.");
            return $this->redirectToRoute('user_association');
        }
        // Vérification que l'association appartient à l'utilisateur courant
        if ($associations->getAuthor() != $this->getUser()) {
            $request->getSession()->getFlashBag()->add("warning", "Cette association ne vous appartient pas.");
            return $this->redirectToRoute('user_association');
        }
        $loadConfig = $this->get(LoadConfig::class);
        $em = $this->getDoctrine()->getManager();
        $oldLogo = $associations->getLogo();
        if ($oldLogo != null)
        {
            $associations->setLogo(new File($this->getParameter('uploads_images_directory').'/'.$associations->getLogo()));
        }
        $form = $this->get('form.factory')->create(AssociationsType::class, $associations);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($loadConfig->loadConfig()->getAdminValidAutoSubmissionAssoc()) {
                $userManager = $this->get('fos_user.user_manager');
                $admin = $userManager->findUserByUsername('admin');
                $associations->setStatus($this->getParameter('var_project')['status_assoc_valid']);
                $associations->setDateApproval(new \DateTime());
                $associations->setApprouvedBy($admin);
            } else {
                $associations->setApprouvedBy(null);
                $associations->setDateApproval(null);
                $associations->setStatus($this->getParameter('var_project')['status_assoc_waiting']);
                $request->getSession()->getFlashBag()->add("info", "Vos modifications vont être analysées par un de nos Administrateurs.");
            }
            if ($associations->getLogo() === null AND $oldLogo != null)
            {
                $associations->setLogo($oldLogo);
            }
            $em->persist($associations);
            $em->flush();
            if ($oldLogo != null and $associations->getLogo() != $oldLogo)
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
     * @param $associations
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET", "POST"})
     */
    public function delAssociationAction(Request $request, Associations $associations = null)
    {
        // Vérification que l'association existe en base de données
        if ($associations === null) {
            $request->getSession()->getFlashBag()->add("warning", "Cette association n'existe pas.");
            return $this->redirectToRoute('user_association');
        }
        // Vérification que l'association appartient à l'utilisateur courant
        if ($associations->getAuthor() != $this->getUser()) {
            $request->getSession()->getFlashBag()->add("warning", "Cette association ne vous appartient pas.");
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
     *
     * @Route("/legalnotice", name="legal_notice")
     * @Method({"GET"})
     */
    public function legalNoticeAction()
    {
        return $this->render('Commun/_legalNotice.html.twig');
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

    /**
     *
     * @Route("/contact", name="modal_contact")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Method({"GET", "POST"})
     */
    public function modalContactAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $contact = new Contact();
        $form = $this->get('form.factory')->create(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Affichage d'un message flash
            $request->getSession()->getFlashBag()->add('success', 'Votre message à bien été envoyé !');
            // Envoyer le mail
            $this->get(SendEmail::class)->sendEmailContact($contact);
            // Sauvegarder en Base de données
            $em->persist($contact);
            $em->flush();
            // Retour à la page d'accueil
            return $this->redirectToRoute('front');
        }
        return $this->render('Front/_modalContact.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/editshowcase/{slug}", name="edit_showcase")
     * @param Associations $associations
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param $slug
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET", "POST"})
     */
    public function editShowcaseAction(Associations $associations, Request $request)
    {
        // Vérification que l'association existe en base de données
        if ($associations === null) {
            $request->getSession()->getFlashBag()->add("warning", "Cette association n'existe pas.");
            return $this->redirectToRoute('user_association');
        }
        // Vérification que l'association appartient à l'utilisateur courant
        if ($associations->getAuthor() != $this->getUser()) {
            $request->getSession()->getFlashBag()->add("warning", "Cette association ne vous appartient pas.");
            return $this->redirectToRoute('user_association');
        }
        $loadConfig = $this->get(LoadConfig::class);
        $em = $this->getDoctrine()->getManager();
        $showcase = $associations->getShowcase();
        $form = $this->get('form.factory')->create(ShowcaseType::class, $showcase);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($loadConfig->loadConfig()->getAdminValidAutoSubmissionAssoc()) {
                $userManager = $this->get('fos_user.user_manager');
                $admin = $userManager->findUserByUsername('admin');
                $associations->setStatus($this->getParameter('var_project')['status_assoc_valid']);
                $associations->setDateApproval(new \DateTime());
                $associations->setApprouvedBy($admin);
            } else {
                $associations->setApprouvedBy(null);
                $associations->setDateApproval(null);
                $associations->setStatus($this->getParameter('var_project')['status_assoc_waiting']);
                $request->getSession()->getFlashBag()->add("info", "Vos modifications vont être analysées par un de nos Administrateurs.");
            }

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

