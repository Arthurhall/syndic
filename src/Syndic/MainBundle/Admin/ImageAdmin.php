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
        $formMapper
            ->add('title')
            ->add('alt')
			->add('file', 'file', array('required' => false))
            //->add('articleId', 'sonata_type_model_hidden')
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