<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\CategoriesType;
use AppBundle\Entity\Categories;

class AdminCategorieController extends Controller
{
    /**
     *
     * @Route("/admin/viewallcategories/{page}", name="admin_view_all_categories")
     * @param $page
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET"})
     *
     */
    public function viewAllCategoriesAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:Categories')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,                 /* query NOT result */
            $page,                  /*page number*/
            25                      /*limit per page*/
        );
        return $this->render('Admin/viewAllCategories.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     *
     * @Route("/admin/addcategorie", name="admin_add_categorie")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function addCategorieAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = new Categories();
        $form   = $this->get('form.factory')->create(CategoriesType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($categorie);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Catégorie bien enregistrée.');
            return $this->redirectToRoute('admin_view_all_categories', array('page' => 1));
        }
        return $this->render('Admin/addCategorie.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/admin/editcategorie/{id}", name="admin_edit_categorie")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function editCategorieAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('AppBundle:Categories')->findOneById($id);
        $form   = $this->get('form.factory')->create(CategoriesType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($categorie);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Catégorie bien modifiée.');
            return $this->redirectToRoute('admin_view_all_categories', array('page' => 1));
        }
        return $this->render('Admin/editCategorie.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     *
     * @Route("/admin/delcategorie/{id}", name="admin_del_categorie")
     * @param $categories
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Method({"GET", "POST"})
     *
     */
    public function delCategorieAction(Categories $categories, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('form.factory')->create();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (count($categories->getAssociations()) > 0)
            {
                $request->getSession()->getFlashBag()->add('warning', "La catégorie ne peut pas être supprimée car elle contient ". count($categories->getAssociations()) ." associations.");
            } else {
                $em->remove($categories);
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', "La catégorie a bien été supprimée.");
            }
            return $this->redirectToRoute('admin_view_all_categories', array('page' => 1));
        }
        return $this->render('Admin/delCategorie.html.twig', array(
            'categorie' => $categories,
            'form'   => $form->createView(),
        ));
    }
}


