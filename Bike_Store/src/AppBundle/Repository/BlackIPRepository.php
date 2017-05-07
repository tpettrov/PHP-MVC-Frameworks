<?php

namespace AppBundle\Repository;

/**
 * BlackIPRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BlackIPRepository extends \Doctrine\ORM\EntityRepository
{

    public function fetchAllIps()
    {
        $qb = $this->createQueryBuilder('ip');

        $qb->select('ip.address');


       $result = $qb->getQuery()->getScalarResult();

       $ips = array_column($result, "address");

        return $ips;





    }


}
