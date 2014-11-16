<?php
namespace Syndic\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;


class MenuBuilder
{
	private $factory;
	
	/**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }
	
    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->addChild('Accueil', array('route' => 'home'));
		$menu->addChild('Contact', array('route' => 'contact'));
        
        return $menu;
    }
}