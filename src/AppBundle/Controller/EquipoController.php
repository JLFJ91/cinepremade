<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Equipo;
use AppBundle\Form\BuscadorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Equipo controller.
 *
 */
class EquipoController extends Controller
{
    /**
     * Lists all equipo entities.
     *
     * @Route("equipo/", name="equipo_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator');

        $fundadores = $em->getRepository('AppBundle:Equipo')->findByTipo('fundador');

        $form = $this->createForm('AppBundle\Form\BuscadorType');

        $tag = '';

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid() && $form->get('tag')->getData()) {
                $tag = $form->get('tag')->getData();
                $socios = $em->getRepository('AppBundle:Equipo')->findByTag($form->get('tag')->getData());
            }
            else {
                $socios = $em->getRepository('AppBundle:Equipo')->findByTipo('socio');
            }
        }
        else {
            $socios = $em->getRepository('AppBundle:Equipo')->findByTipo('socio');
        }

        $pagination = $paginator->paginate(
            $socios,
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('equipo/index.html.twig', array(
            'fundadores' => $fundadores,
            'pagination' => $pagination,
            'buscadorForm' => $form->createView(),
            'categoria' => $tag,
        ));
    }
    
    /**
     * Lists all equipo entities.
     *
     * @Route("admin/equipo/", name="admin_equipo_index")
     * @Method("GET")
     */
    public function adminIndexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator');

        $equipos = $em->getRepository('AppBundle:Equipo')->findAll();
        $pagination = $paginator->paginate(
            $equipos,
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('equipo/admin_index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Creates a new equipo entity.
     *
     * @Route("admin/equipo/new", name="equipo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $equipo = new Equipo();
        $form = $this->createForm('AppBundle\Form\EquipoType', $equipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipo);
            $em->flush();

            return $this->redirectToRoute('equipo_edit', array('id' => $equipo->getId()));
        }

        return $this->render('equipo/new.html.twig', array(
            'equipo' => $equipo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing equipo entity.
     *
     * @Route("admin/equipo/{id}/edit", name="equipo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Equipo $equipo)
    {
        $deleteForm = $this->createDeleteForm($equipo);
        $editForm = $this->createForm('AppBundle\Form\EquipoType', $equipo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipo_edit', array('id' => $equipo->getId()));
        }

        return $this->render('equipo/edit.html.twig', array(
            'equipo' => $equipo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a equipo entity.
     *
     * @Route("admin/equipo/{id}", name="equipo_delete")
     * @Method({"GET", "DELETE"})
     */
    public function deleteAction(Request $request, Equipo $equipo)
    {
        $form = $this->createDeleteForm($equipo);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE')) {
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($equipo);
                $em->flush();
            }
        }
        elseif ($request->isMethod('GET')) {
            return $this->render('equipo/delete.html.twig', array(
                'equipo' => $equipo,
                'delete_form' => $form->createView(),
            ));
        }
        return $this->redirectToRoute('admin_equipo_index');
    }

    /**
     * Creates a form to delete a equipo entity.
     *
     * @param Equipo $equipo The equipo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Equipo $equipo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('equipo_delete', array('id' => $equipo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
