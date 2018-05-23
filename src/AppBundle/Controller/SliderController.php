<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Slider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Slider controller.
 */
class SliderController extends Controller
{
    /**
     * Lists all slider entities.
     *
     * @Route("admin/slider/", name="admin_slider_index")
     * @Method("GET")
     */
    public function adminIndexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator');

        $sliders = $em->getRepository('AppBundle:Slider')->findAll();
        $pagination = $paginator->paginate(
            $sliders,
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('slider/admin_index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Creates a new slider entity.
     *
     * @Route("admin/slider/new", name="slider_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $slider = new Slider();
        $form = $this->createForm('AppBundle\Form\SliderType', $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($slider);
            $em->flush();

            return $this->redirectToRoute('slider_edit', array('id' => $slider->getId()));
        }

        return $this->render('slider/new.html.twig', array(
            'slider' => $slider,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing slider entity.
     *
     * @Route("admin/slider/{id}/edit", name="slider_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Slider $slider)
    {
        $deleteForm = $this->createDeleteForm($slider);
        $editForm = $this->createForm('AppBundle\Form\SliderType', $slider);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('slider_edit', array('id' => $slider->getId()));
        }

        return $this->render('slider/edit.html.twig', array(
            'slider' => $slider,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a slider entity.
     *
     * @Route("admin/slider/{id}", name="slider_delete")
     * @Method({"GET", "DELETE"})
     */
    public function deleteAction(Request $request, Slider $slider)
    {
        $form = $this->createDeleteForm($slider);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE')) {
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($slider);
                $em->flush();
            }
        }
        elseif ($request->isMethod('GET')) {
            return $this->render('slider/delete.html.twig', array(
                'slider' => $slider,
                'delete_form' => $form->createView(),
            ));
        }
        return $this->redirectToRoute('admin_slider_index');
    }

    /**
     * Creates a form to delete a slider entity.
     *
     * @param Slider $slider The slider entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Slider $slider)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('slider_delete', array('id' => $slider->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
