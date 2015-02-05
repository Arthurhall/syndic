<?php

namespace Syndic\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Syndic\MainBundle\Form\ContactType;

/**
 * Category controller.
 *
 * @Route("/categorie")
 */
class CategoryController extends Controller
{
    /**
     * Category articles list
     *
     * @Route("/{slug}", name="category_articles")
     * @Method("GET")
     * @Template("SyndicMainBundle:Category:articles.html.twig")
     */
    public function articlesAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $category = $em->getRepository('SyndicMainBundle:Category')->findOneBySlug( $slug );
        if(!$category) {
            throw $this->createNotFoundException('Catégorie introuvable.');
        }
        
        $qb = $em->getRepository('SyndicMainBundle:Article')->listByCategory( $category->getId() );
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $qb->getQuery(),
            $request->query->get('page', 1) /*page number*/,
            $request->query->get('perPage', 10) /*limit per page*/
        );

        
        
        $ca = $this->get('syndic_main.category_authorization');
        if(!$ca->isAuthorized($category))
        {
            return $ca->getRedirectResponse($category);
        }
        
        return array(
            'category' => $category,
            'pagination' => $pagination,
        );
    }
    
}
