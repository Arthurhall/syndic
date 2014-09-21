<?php

namespace Syndic\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;


class UserRepository extends EntityRepository
{
	/**
     * Retourne un objet User à partir de son email
     * @param string $email
     * @return User
     */
	public function findOneByMyWay($email)
	{
      	$query = 'SELECT u, t1, t2 FROM SyndicUserBundle:User u
            JOIN u.article a
            WHERE u.email = :email';
 
      	$queryBuilder = $this->getEntityManager()->createQuery($query)->setParameter('email', $email);
		
      	try
      	{
			return $queryBuilder->getSingleResult();
      	}
      	catch (\Doctrine\ORM\NoResultException $e)
      	{
         	return null;
      	}
   	}
}