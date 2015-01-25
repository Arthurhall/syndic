<?php 

namespace Syndic\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;


class ImageAdmin extends Admin
{
	public function prePersist($object) {
    	$object->upload();
	}

  	public function preUpdate($object) {
    	$object->upload();
  	}
 
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
	
	
    protected function configureFormFields(FormMapper $formMapper)
    {
        // get the current Image instance
        $image = $this->getSubject();

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array(
            'required' => false,
            'attr' => array('class' => 'with-image-preview')
        );
        if ($image && ($webPath = $image->getWebPath())) 
        {
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request')->getBasePath().'/'.$webPath;

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['attr']['data-image-path'] = $fullPath;
        }
        
        $formMapper
            ->add('title')
            ->add('alt')
			->add('file', 'file', $fileFieldOptions)
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        	->add('title')
            ->add('alt')
            ->add('createdAt')
			->add('updatedAt')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('title')
            ->add('alt')
            ->add('path')
            ->add('article')
            ->add('webPath', 'image')
			->add('createdAt')
			->add('updatedAt')
            
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
            ->add('alt')
			->add('webPath', 'image')
            ->with('Dates')
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