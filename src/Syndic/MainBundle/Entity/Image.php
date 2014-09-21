<?php

namespace Syndic\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="Syndic\MainBundle\Entity\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
	
	

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=100, nullable=true)
     */
    private $alt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
	 * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
	 * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Article", mappedBy="image")
     */
    private $article;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    }
    
	public function __toString() {
		return (string) $this->getWebPath();
	}
	
	
	/**
	 * @Assert\File(maxSize="6000000")
	 */
	private $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;
	
	public function upload()
	{
		// la propriété « file » peut être vide si le champ n'est pas requis
		if (null === $this->file) {
			return;
		}
        
		$uniqid = uniqid();
        
        if(null !== $this->file) {
            $name = $uniqid.'.'.$this->file->guessExtension();
            $this->file->move($this->getUploadRootDir(), $name);
            $this->path = $name;   
        }
		
        unset($this->file);
        return;
	}
	
	public function getAbsolutePath() {
		return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
	}
    
	public function getWebPath() {
		return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
	}
    
	public function getUploadRootDir()
	{
		// le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
		return __DIR__.'/../../../../web/'.$this->getUploadDir();
	}
	
	protected function getUploadDir()
	{
		// on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
		// le document/image dans la vue.
		return 'uploads/image';
	}
	
	/**
	 * @ORM\PostRemove()
	 */
	public function removeUpload()
	{
		if ($file = $this->getAbsolutePath()) {
			unlink($file);
		}
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
     * Set title
     *
     * @param string $title
     * @return Image
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    
        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Image
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Image
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add article
     *
     * @param \Amap\MainBundle\Entity\Article $article
     * @return Image
     */
    public function addArticle(\Amap\MainBundle\Entity\Article $article)
    {
        $this->article[] = $article;
    
        return $this;
    }

    /**
     * Remove article
     *
     * @param \Amap\MainBundle\Entity\Article $article
     */
    public function removeArticle(\Amap\MainBundle\Entity\Article $article)
    {
        $this->article->removeElement($article);
    }

    /**
     * Get article
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
	
	/**
     * Set file
     *
     * @param string $file
     * @return Image
     */
    public function setFile($file)
    {
        $this->file = $file;
    
        return $this;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }
}