<?php

namespace AppBundle\Controller;

use AppBundle\Services\SendEmail;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Contact;
use AppBundle\Form\Type\ContactType;

class FrontController extends Controller
{

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('Front/index.html.twig');
    }


    /**
     * @Route("/front", name="front")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Method({"GET"})
     */
    public function frontAction(Request $request)
    {
        return $this->render('Front/front.html.twig');
    }

    /**
     * @Route("/viewallcategories", name="view_all_categories")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Method({"GET"})
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
     * @Method({"GET"})
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
     *
     * @Route("/legalnotice", name="legal_notice")
     * @Method({"GET"})
     */
    public function legalNoticeAction()
    {
        return $this->render('Commun/_legalNotice.html.twig');
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
}

