<?php

namespace boxiweb\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * userRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GroupRepository extends EntityRepository
{
    
     public function findByRoles($id)
{
         
$qb = $this->createQueryBuilder('u')
                    ->select('u.roles')
        
                    ->where('u.id = :id')
                    ->setParameter('id', $id);
        return $qb->getQuery()->getResult();
        
}
}
 