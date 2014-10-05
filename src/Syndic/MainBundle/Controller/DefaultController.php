<?php

namespace Syndic\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Syndic\MainBundle\Form\ContactType;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SyndicMainBundle:Default:index.html.twig');
    }
    
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
                ->setTo( $this->container->getParameter('email') )
                ->setCharset('UTF-8')    
                ->setContentType('text/html')
                ->setBody( $this->renderView('AmapMainBundle:Default:contact_mail.html.twig', array('data' => $data)) )
            ;
            
            $this->get('mailer')->send($message); 
            
            $flash = $this->get('braincrafted_bootstrap.flash');
            $flash->success('Votre message a bien été envoyé.');    
            
            return $this->redirect($url);
        }
        
        return $this->render('SyndicMainBundle:Default:contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
