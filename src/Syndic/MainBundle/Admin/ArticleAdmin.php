<?php 

namespace Syndic\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;


class ArticleAdmin extends Admin
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
        if($object && $object->getImage())
        {
            foreach ($object->getImage() as $key => $img) {
                $img->upload();
            }
            $object->setImage($object->getImage());
        }
    }
    
    public function preUpdate($object)
    {
        if($object && $object->getImage())
        {
            foreach ($object->getImage() as $key => $img) {
                $img->upload();
            }
            $object->setImage($object->getImage());
        }
    }
    
    public $supportsPreviewMode = true;
	
	
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', null, array(
                'label' => 'titre'
            ))
			->add('isPublished', 'checkbox', array(
                'required' => false,
                'label' => 'Publié'
            ))
			->add('category', null, array(
                'label' => 'Catégorie'
            ))
			->add('user', null, array(
                'label' => 'Auteur'
            ))
            ->add('content', 'textarea', array(
                'label' => 'Contenu',
        		'attr' => array(
        			'required' => false,
        			'class' => 'tinymce',
        			'data-theme' => 'advanced',
    			)
			))
			->add('image', 'sonata_type_collection', array(
                'label' => 'Image(s)',
                'by_reference' => false,
                'type_options' => array('delete' => true),
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'id',
                'allow_delete' => true
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        	->add('title')
            ->add('content')
			->add('category')
            // ->add('createdAt', 'doctrine_orm_date', array('input_type' => 'date'))
			// ->add('updatedAt', 'doctrine_orm_date', array('input_type' => 'date'))
            // ->add('publishedAt', 'doctrine_orm_date', array('input_type' => 'date'))
            ->add('isPublished')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
			->add('user')
            ->add('isPublished')
            ->add('category')
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