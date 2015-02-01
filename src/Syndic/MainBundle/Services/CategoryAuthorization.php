<?php

namespace Syndic\MainBundle\Services;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Braincrafted\Bundle\BootstrapBundle\Session\FlashMessage;
use Syndic\MainBundle\Entity\Category;
use Syndic\UserBundle\Entity\User;


class CategoryAuthorization
{
    private $sc;
    private $router;
    private $flash;
    
    public function __construct(SecurityContext $sc, Router $router, FlashMessage $flash)
    {
        $this->sc = $sc;
        $this->router = $router;
        $this->flash = $flash;
    }
    
    /**
     * Is authorized
     * 
     * @param \Category $category
     * @return boolean
     */
    public function isAuthorized(Category $category)
    {
        $user = $this->getUser();
        
        // Si la catégorie n'a pas de group elle est accessible par tous
        if(!$category->getGroup())
        {
            return true;
        }
        else 
        {
            foreach ($category->getGroup()->getRoles() as $key => $role) 
            {
                if($user && $user->hasRole($role))
                {
                    return true;
                }
            }
        }
        
        return false;
    }
    
    /**
     * Get RedirectResponse
     * 
     * @param \Category $category
     * @return \RedirectResponse
     * @throw \AccessDeniedException
     */
    public function getRedirectResponse(Category $category)
    {
        $user = $this->getUser();
        
        // Si le user n'est pas connecté on lui propose de se connecter 
        if(!$user) {
            $this->flash->error('Vous n\'êtes pas autorisé à accéder à la rubrique "'.$category.'", connectez-vous.');
            return new RedirectResponse($this->router->generate('fos_user_security_login'));
        }
        // Sinon on refuse l'accès à la catégorie 
        throw new AccessDeniedException('Vous n\'êtes pas autorisé à accéder à la rubrique "'.$category.'".');
    }
    
    /**
     * Get user
     * 
     * @return mixed
     */
    private function getUser()
    {
        $user = $this->sc->getToken()->getUser();
        
        if(!$user instanceof User)
        {
            $user = null;
        }
        
        return $user;
    }
}
