<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\TypeVoiture;
use JanetTransit\AdminBundle\Form\TypeVoitureType;

/**
 * TypeVoiture controller.
 *
 * @Route("/typevoiture")
 */
class TypeVoitureController extends Controller
{

    /**
     * Lists all TypeVoiture entities.
     *
     * @Route("/", name="typevoiture")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JanetTransitAdminBundle:TypeVoiture')->findAll();

        return array(
            'entities' => $entities,
        );
    }
}
