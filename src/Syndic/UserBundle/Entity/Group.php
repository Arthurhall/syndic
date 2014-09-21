<?php

namespace Syndic\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseGroup as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="Syndic\UserBundle\Repository\GroupRepository")
* @ORM\Table(name="group")
*/
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
}