<?php

namespace UserBundle\Repository;

/**
 * commentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class commentRepository extends \Doctrine\ORM\EntityRepository
{
    public function findcommParameter($id){
        $query = $this->getEntityManager()
            ->createQuery("
                    select comment from UserBundle:comment comment WHERE comment.forum=:id
            ")
            ->setParameter('id',$id);
        return $query->getResult();
    }


}