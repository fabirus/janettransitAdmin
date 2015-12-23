<?php

namespace JanetTransit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JanetTransit\AdminBundle\Entity\Operation;
use JanetTransit\AdminBundle\Form\OperationType;

/**
 * Operation controller.
 *
 * @Route("/operation")
 */
class OperationController extends Controller
{

    /**
     * Lists all Operation entities.
     *
     * @Route("/", name="operation")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em         = $this->getDoctrine()->getManager();
        $entities   = $em->getRepository('JanetTransitAdminBundle:Operation')->findAll();

        return array(
            'entities' => $entities,
        );
    }

}
