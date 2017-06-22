<?php

namespace AppBundle\Controller;

use AppBundle\Services\LoadConfig;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\ConfigurationType;

class AdminController extends Controller
{
    /**
     *
     * @Route("/admin", name="admin")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET"})
     *
     */
    public function indexAction(Request $request)
    {
        return $this->render('Admin/index.html.twig');
    }

    /**
     *
     * @Route("/admin/configuration", name="admin_configuration")
     * @param Request $request
     * @param LoadConfig $loadConfig
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function configurationAction(Request $request, LoadConfig $loadConfig)
    {
        $em = $this->getDoctrine()->getManager();
        // Récuperation de la configuration
        $config = $loadConfig->loadConfig();
        // Formulaire
        $form = $this->get('form.factory')->create(ConfigurationType::class, $config);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'La configuration à bien été sauvegardée.');
            return $this->redirectToRoute('admin_configuration');
        }
        return $this->render('Admin/configuration.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}


