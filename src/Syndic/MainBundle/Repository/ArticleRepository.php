<?php

namespace Syndic\MainBundle\Repository;

use Doctrine\ORM\EntityRepository;


class ArticleRepository extends EntityRepository
{
	public function findHome()
	{
		$qb = $this->createQueryBuilder('a')
			->addSelect('i')
            ->leftJoin('a.image', 'i')
		;
        
        $r = $qb->getQuery()
            ->getOneOrNullResult();
		return $r;
	}
	
    public function findAllPublished()
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('c')
            
            ->InnerJoin('a.category', 'c')
            
            ->where('a.isPublished = 1')
			
			->orderBy('a.publishedAt', 'DESC')
        ;
        
        $r = $qb->getQuery()
        ->getResult();
    
        return $r;
    }
    
    public function findByCategory( array $arr )
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('c')
            
            ->InnerJoin('a.category', 'c')
			
			->where('a.isPublished = 1')
			->andWhere('c.slug = :slug')
            ->setParameter('slug', $arr['slug'])
			
			->orderBy('a.publishedAt', 'DESC')
        ;
		
        $r = $qb->getQuery()
        ->getResult();
    
        return $r;
    }
	
	public function findAllByMonth( array $arr = null )
    {
    	$sql = "
    		SELECT a.id, a.slug, a.title, c.id as c_id, c.slug as c_slug, c.title as c_title,
    		DATE_FORMAT(a.created_at,'%Y-%m') as formatted_date
    		FROM article as a
    		INNER JOIN category as c 
    		ON a.category_id = c.id
    		WHERE a.is_published = 1
    		";
    	
		$conn = $this->getEntityManager()->getConnection();
		$r = array();
		foreach($conn->query($sql)->fetchAll() as $k => $row)
		{
			$r[$k] = $row;
			$dates[$k] = $row['formatted_date'];
		}
		
		if(!$r) return $r;
		
		$uniq_dates = array_unique($dates);
		
		foreach($uniq_dates as $k => $d)
		{
			foreach ($r as $key => $row) 
			{
				$res[$d][$row['id']] = $row;
			}
		}
		//echo "<pre>"; print_r($r) ; die();
		return $res;
   	}
	
    public function search( array $arr )
    {
    	$search = $arr['search'];
        $qb = $this->createQueryBuilder('a');
		$qb
		->where(
			$qb->expr()->orX(
				$qb->expr()->like('a.title', $qb->expr()->literal('%'.$search.'%')),
				$qb->expr()->like('a.content', $qb->expr()->literal('%'.$search.'%'))
			)
		)
		->orderBy('a.publishedAt', 'DESC')
		->groupBy('a.id')
		;
		
		$r = $qb->getQuery()
	    	->getResult()
		;
		
		return $r;
    }
}
