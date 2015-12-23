<?php

namespace JanetTransit\WikiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JanetTransit\WikiBundle\Entity\Category;

class WikiController extends Controller
{
    public function indexAction(){

        $em         = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('JanetTransitWikiBundle:Category')->findBy(array('parent' => null));

        return $this->render('JanetTransitWikiBundle:Wiki:index.html.twig', array(
            'categories' => $categories,
            'infos'      => 'Catégories'
        ));
    }

    public function articlesAction($id){

        $em         = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('JanetTransitWikiBundle:Category')->findBy(array('parent' => $id));
        $articles   = $em->getRepository('JanetTransitWikiBundle:Article')->findBy(array('category' => $id));
        $category   = $em->getRepository('JanetTransitWikiBundle:Category')->find($id);

        if (count($categories) > 0) {
            return $this->render('JanetTransitWikiBundle:Wiki:index.html.twig', array(
                'categories' => $categories,
                'infos'      => 'Sous-Catégories'
            ));
        }
        else {
//            count($category->getArticles());

            return $this->render('JanetTransitWikiBundle:Wiki:article.html.twig', array(
                'articles' => $articles,
                'category' => $category
            ));
        }
    }

    public function showAction($id, $idCat){
        $em         = $this->getDoctrine()->getManager();
        $article    = $em
            ->getRepository('JanetTransitWikiBundle:Article')
            ->find($id);

        return $this->render('JanetTransitWikiBundle:Wiki:show.html.twig', array(
            'article' => $article,
            'idCat'   => $idCat
        ));

    }
}
