<?php 

namespace Syndic\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;


class TeamAdmin extends Admin
{
	// setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'createdAt'
    );
	
	protected function configureRoutes(RouteCollection $collection)
    {
		$collection
			//->remove('delete')
		;
    }
    
    public function prePersist($object)
    {
        $object->upload();
    }
    
    public function preUpdate($object)
    {
        $object->upload();
    }
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        // get the current Image instance
        $image = $this->getSubject();

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array(
            'required' => false,
        );
        if ($image && ($webPath = $image->getWebPath())) 
        {
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request')->getBasePath().'/'.$webPath;

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = 'Photo obligatoire ! <br /><img src="' . $fullPath . '" />';
        }

        $formMapper
            ->add('firstName', null, array(
                'label' => 'Prénom'
            ))
			->add('lastName', null, array(
                'label' => 'Nom'
            ))
            ->add('job', null, array(
                'label' => 'Fonction'
            ))
            ->add('order', null, array(
                'label' => 'Ordre',
                'help' => 'Ordre d\'affichage, comptez de 10 en 10.'
            ))
            ->add('file', 'file', $fileFieldOptions)
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        	->add('firstName')
            ->add('lastName')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            //->addIdentifier('id')
			->addIdentifier('firstName')
            ->add('lastName')
            ->add('job')
            ->add('webPath', 'image')
            ->add('order')
			->add('createdAt')
			
			->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'delete' => array(),
                    //'edit' => array(),
                )
            ))
        ;
    }
	
	protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
			->add('user')
            ->add('content')
			->add('isPublished')
            ->add('category')
            ->add('image') // , 'image'
            ->with('Dates')
                ->add('publishedAt')
                ->add('createdAt')
    			->add('updatedAt')
            ->end()
       	;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        // $errorElement
			// ->with('content')
                // ->assertMaxLength(array('limit' => 500))
            // ->end()
        // ;
    }
}