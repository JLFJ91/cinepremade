<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pagina;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $slider = $em->getRepository('AppBundle:Slider')->findBy([], ['id' => 'DESC'], 3);
        $paginas = $em->getRepository('AppBundle:Pagina')->findPublicPaginasOrderByPosicion();

        return $this->render('main/index.html.twig', [
            'slider' => $slider,
            'paginas' => $paginas,
        ]);
    }

}
