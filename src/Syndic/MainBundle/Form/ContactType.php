<?php

namespace Syndic\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	
        $builder
        	->add('civilite', 'choice', array(
                'label' => 'Civilité',
				'choices' => array(
					'Mlle' => 'Mlle',
					'Mme' => 'Mme',
					'Mr' => 'Mr',
				),
				'expanded' => false,
				'required' => false
			))
            
			->add('nom', 'text', array(
                'label' => 'Nom',
                'attr' => array('placeholder' => 'Nom') 
            ))
			->add('prenom', 'text', array(
                'label' => 'Prénom',
                'attr' => array('placeholder' => 'Prénom') 
            ))
			->add('email', 'email', array(
                'label' => 'email',
                'attr' => array('placeholder' => 'Votre e-mail') 
            ))
			->add('tel', 'text', array(
                'label' => 'Téléphone',
                'required' => false, 
                'attr' => array('placeholder' => 'Téléphone') 
            ))

			
			->add('sujet', 'text', array(
                'label' => 'Sujet',
                'attr' => array('placeholder' => 'Sujet'), 
            ))
			
			->add('message', 'textarea', array(
                'label' => 'Message',
        		'attr' => array(
        			'class' => 'tinymce',
            		'data-theme' => 'simple'
				),
				'required' => false
    		))
            
            ->add('submit', 'submit', array(
                'label' => 'Envoyer'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        
    }

    public function getName()
    {
        return 'syndic_mainbundle_contacttype';
    }
}
