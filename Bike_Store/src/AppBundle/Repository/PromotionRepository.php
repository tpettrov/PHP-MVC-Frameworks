<?php

namespace AppBundle\Repository;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * PromotionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PromotionRepository extends \Doctrine\ORM\EntityRepository
{

    public function fetchActivePromotions()
    {
        $qb = $this->createQueryBuilder('p');

        $today = new \DateTime();

        $qb->select('p')
            ->where($qb->expr()->lte('p.start', ':today'))
            ->andWhere($qb->expr()->gte('p.end', ':today'))
            ->setParameter(':today', $today->format('Y-m-d'));

         $result = $qb->getQuery()->getResult();


        return $promotions = new ArrayCollection($result);



    }


}
