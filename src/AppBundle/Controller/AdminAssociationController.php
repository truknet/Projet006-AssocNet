<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Associations;
use AppBundle\Services\SendEmail;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\AssociationsAdminType;
use AppBundle\Form\Type\AssociationsRejectType;
use Symfony\Component\HttpFoundation\File\File;



class AdminAssociationController extends Controller
{
    /**
     *
     * @Route("/admin/viewallassociations/{page}", name="admin_view_all_associations")
     * @param $page
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET"})
     *
     */
    public function viewAllAssociationsAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:Associations')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,                 /* query NOT result */
            $page,                  /*page number*/
            25                      /*limit per page*/
        );
        return $this->render('Admin/viewAllAssociations.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     *
     * @Route("/admin/viewoneassociation/{slug}", name="admin_view_one_association")
     * @param Associations $associations
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param $slug
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET"})
     */
    public function viewOneAssociationAction(Associations $associations)
    {
        return $this->render('Admin/viewOneAssociation.html.twig', array(
            'association' => $associations,
        ));
    }

    /**
     *
     * @Route("/admin/delassociation/{slug}", name="admin_del_association")
     * @param $associations
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function delAssociationAction(Associations $associations, Request $request)
    {
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
            return $this->redirectToRoute('admin_view_all_associations', array('page' => 1));
        }
        return $this->render('Admin/delAssociation.html.twig', array(
            'associations' => $associations,
            'form'   => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/admin/editassociation/{slug}", name="admin_edit_association")
     * @param $associations
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function editAssociationAction(Associations $associations, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $oldLogo = $associations->getLogo();
        if ($oldLogo !== null)
        {
            $associations->setLogo(new File($this->getParameter('uploads_images_directory').'/'.$associations->getLogo()));
        }
        $form = $this->get('form.factory')->create(AssociationsAdminType::class, $associations);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
            $request->getSession()->getFlashBag()->add('success', "L'association a bien été modifiée.");
            return $this->redirectToRoute('admin_view_one_association', array('slug' => $associations->getSlug()));
        }
        return $this->render('Admin/editAssociation.html.twig', array(
            'associations' => $associations,
            'form'   => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/admin/validassociation/{slug}", name="admin_valid_association")
     * @param $associations
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function validAssociationAction(Associations $associations, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('form.factory')->create();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $associations->setStatus($this->getParameter('var_project')['status_assoc_valid']);
            $associations->setApprouvedBy($this->getUser());
            $associations->setRejectMessage(null);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "L'association a bien été validée.");
            return $this->redirectToRoute('admin_view_all_associations', array('page' => 1));
        }
        return $this->render('Admin/validAssociation.html.twig', array(
            'associations' => $associations,
            'form'   => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/admin/rejectassociation/{slug}", name="admin_reject_association")
     * @param Associations $associations
     * @param Request $request
     * @param SendEmail $sendEmail
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function rejectAssociationAction(Associations $associations, Request $request, SendEmail $sendEmail)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('form.factory')->create(AssociationsRejectType::class, $associations);
        if ($associations->getLogo() !== null)
        {
            $associations->setLogo(new File($this->getParameter('uploads_images_directory').'/'.$associations->getLogo()));
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $associations->setStatus($this->getParameter('var_project')['status_assoc_rejected']);
            $associations->setApprouvedBy($this->getUser());
            $em->flush();
            // Envoi d'un Email à l'auteur de l'observation.
            $sendEmail->sendEmailReject($associations);
            $request->getSession()->getFlashBag()->add('success', "L'association a bien été rejetée.");
            return $this->redirectToRoute('admin_view_all_associations', array('page' => 1));
        }
        return $this->render('Admin/rejectAssociation.html.twig', array(
            'associations' => $associations,
            'form'   => $form->createView(),
        ));
    }


}


