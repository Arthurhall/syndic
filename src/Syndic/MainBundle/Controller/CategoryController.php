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
    public function articlesAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        
        $category = $em->getRepository('SyndicMainBundle:Category')->findOneBySlug( $slug );
        if(!$category) {
            throw $this->createNotFoundException('Catégorie introuvable.');
        }
        
        $ca = $this->get('syndic_main.category_authorization');
        if(!$ca->isAuthorized($category))
        {
            return $ca->getRedirectResponse($category);
        }
        
        $articles = $em->getRepository('SyndicMainBundle:Article')->findByCategory( $category );
        
        return array(
            'category' => $category,
            'articles' => $articles,
        );
    }
    
}
