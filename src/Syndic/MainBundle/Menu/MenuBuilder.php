<?php
namespace Syndic\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;


class MenuBuilder
{
	private $factory;
	
	private $em;
	
	/**
     * @param FactoryInterface $factory
	 * @param EntityManager $em
     */
    public function __construct(FactoryInterface $factory, EntityManager $em)
    {
        $this->factory = $factory;
		$this->em = $em;
    }
	
    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->addChild('Accueil', array('route' => 'home'));
		
		$menu->addChild('Catégories')->setAttribute('dropdown', true);
		foreach ($this->em->getRepository('SyndicMainBundle:Category')->findAll() as $key => $category) 
		{
			$menu['Catégories']->addChild(
				$category->getTitle(), 
				array(
					'route' => 'category_articles',
					'routeParameters' => array('slug' => $category->getSlug()),
				)
			)->setAttribute('divider_append', true);
		}
		
		$menu->addChild('Contact', array('route' => 'contact'));
        
        return $menu;
    }
}