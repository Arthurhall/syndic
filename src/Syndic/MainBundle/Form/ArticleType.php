<?php

namespace Syndic\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content', 'textarea', array(
				'label' => 'Contenu',
				'attr' => array(
					'class' => 'tinymce'
				)
			))
            ->add('createdAt')
            ->add('updatedAt')
            ->add('publishedAt')
            ->add('isPublished')
            ->add('isPrivate')
            ->add('slug')
            ->add('category')
            ->add('user')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Syndic\MainBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'syndic_mainbundle_article';
    }
}
