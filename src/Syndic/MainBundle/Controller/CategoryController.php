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
        
        $articles = $em->getRepository('SyndicMainBundle:Article')->findByCategory( $category );
        
        return array(
            'category' => $category,
            'articles' => $articles,
        );
    }
    
    /**
     * Contact
     *
     * @Route("/contact", name="contact")
     * @Method({"GET", "POST"})
     * @Template("SyndicMainBundle:Main:contact.html.twig")
     */
    public function contactAction(Request $request)
    {
        $url = $this->generateUrl('contact');
        
        $form = $this->createForm(new ContactType(), null, array(
            'action' => $url,
            'method' => 'POST',
        ));
        
        $form->handleRequest($request);

        if ($form->isValid()) 
        {
            $data = $form->getData();
            
            $message = \Swift_Message::newInstance()
                ->setSubject('Contact - Syndic')
                ->setFrom( $data['email'] )
                ->setTo( 'test@test.fr' )
                ->setCharset('UTF-8')    
                ->setContentType('text/html')
                ->setBody( $this->renderView('SyndicMainBundle:Main:contact_mail.html.twig', array('data' => $data)) )
            ;
            
            $this->get('mailer')->send($message); 
            
            $flash = $this->get('braincrafted_bootstrap.flash');
            $flash->success('Votre message a bien été envoyé.');    
            
            return $this->redirect($url);
        }
        
        return array(
            'form' => $form->createView(),
        );
    }
}
