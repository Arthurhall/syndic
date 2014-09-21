<?php 

namespace Syndic\UserBundle\Entity;
 
use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

 
/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Syndic\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	/**
     * @ORM\OneToMany(targetEntity="Syndic\MainBundle\Entity\Article", mappedBy="user")
     */
    private $articles; 

    /**
     * Constructor
     */
    public function __construct()
    {
    	parent::__construct();
		
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
    }
	
	public function hasArticle($id)
	{
		if($id > 0)
		{
			foreach ($this->articles as $key => $article) 
			{
				if($id == $article->getId()) {
					return true;
				}
			}
		}
		return false;
	}
	
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add articles
     *
     * @param \Syndic\MainBundle\Entity\Article $articles
     * @return User
     */
    public function addArticle(\Syndic\MainBundle\Entity\Article $articles)
    {
        $this->articles[] = $articles;
    
        return $this;
    }

    /**
     * Remove articles
     *
     * @param \Syndic\MainBundle\Entity\Article $articles
     */
    public function removeArticle(\Syndic\MainBundle\Entity\Article $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticles()
    {
        return $this->articles;
    }

}